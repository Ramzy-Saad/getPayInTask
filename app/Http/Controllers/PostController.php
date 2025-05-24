<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Http\Requests\UpdatePost;
use App\Models\Post;
use App\Http\Resources\PostResource;
use App\Services\PostService;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    use AuthorizesRequests;

    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request)
    {
        $query = $this->postService->index($request);
        return PostResource::collection($query->latest()->get());
    }
    public function store(StorePost $request)
    {
        $data = $request->validated();
        $user = Auth::user();

        $scheduledCount = auth()
            ->user()
            ->posts()
            ->whereDate('scheduled_time', Carbon::parse($request->scheduled_time)->toDateString())
            ->count();

        if ($scheduledCount >= 10) {
            return response()->json(
                [
                    'errors' => [
                        'scheduled_time' => 'You can only schedule up to 10 posts per day.',
                    ],
                ],
                422,
            );
        }
        $userPlatformIds = $user->platformUsers()->pluck('platform_id')->toArray();

        foreach ($data['platforms'] as $platformId) {
            if (!in_array($platformId, $userPlatformIds)) {
                return response()->json(
                    [
                        'message' => "Platform ID $platformId is not activated.",
                    ],
                    422,
                );
            }
        }
        $post = $this->postService->store($data);
        return new PostResource($post->load('platforms'));
    }

    public function update(UpdatePost $request, Post $post)
    {
        $this->authorize('update', $post);
        $user = Auth::user();
        $userPlatformIds = $user->platformUsers()->pluck('platform_id')->toArray();

        foreach ($request->platforms as $platformId) {
            if (!in_array($platformId, $userPlatformIds)) {
                return response()->json(
                    [
                        'message' => "Platform ID $platformId is not activated.",
                    ],
                    422,
                );
            }
        }
        $data = $request->validated();
        $post = $this->postService->update($data, $post);

        return new PostResource($post->refresh());
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully']);
    }
}
