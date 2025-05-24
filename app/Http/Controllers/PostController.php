<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Http\Requests\UpdatePost;
use App\Models\Post;
use App\Http\Resources\PostResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    use AuthorizesRequests;
    public function store(StorePost $request)
    {
        $data = $request->validated();
        $user = Auth::user();
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
        $post = Auth::user()->posts()->create($data);

        $post->platforms()->attach(
            collect($data['platforms'])->mapWithKeys(function ($id) {
                return [$id => ['platform_status' => 'pending']];
            }),
        );

        return new PostResource($post->load('platforms'));
    }
    public function index(Request $request)
    {
        $query = Auth::user()->posts()->with('platforms');

        if ($request->status != null) {
            $query->where('status', $request->status);
        }

        if ($request->date != null) {
            $query->whereDate('scheduled_time', $request->date);
        }

        return PostResource::collection($query->latest()->get());
    }

    public function update(UpdatePost $request, Post $post)
    {
        $this->authorize('update', $post);

        $data = $request->validated();

        $post->update($data);
        $post->platforms()->sync(
            collect($data['platforms'])->mapWithKeys(function ($id) {
                return [$id => ['platform_status' => 'pending']];
            }),
        );

        return new PostResource($post->refresh());
    }

    // Delete a post
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }
}
