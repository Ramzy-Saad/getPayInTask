<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePost;
use App\Http\Requests\UpdatePost;
use App\Models\PlatformUser;
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
        $posts = PostResource::collection($query->latest()->get());
        return view('posts.index', compact('posts'));
    }
    public function create()
    {
        $platforms = auth()->user()->platformUsers()->with('platform:id,name,type')->get()->pluck('platform')->filter();
        return view('posts.create', compact('platforms'));
    }
    public function edit(Post $post)
    {
        $platforms = auth()->user()->platformUsers()->with('platform:id,name,type')->get()->pluck('platform')->filter();
        return view('posts.edit', compact('platforms', 'post'));
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
            return redirect()
                ->back()
                ->withErrors(['scheduled_time' => 'You can only schedule up to 10 posts per day.']);
        }
        $userPlatformIds = $user->platformUsers()->pluck('platform_id')->toArray();

        foreach ($data['platforms'] as $platformId) {
            if (!in_array($platformId, $userPlatformIds)) {
                return back()->with('error', "Platform ID $platformId is not activated.");
            }
        }
        $this->postService->store($data);
        return redirect()->route('posts.index')->with('success', 'post added succcessfullly');
    }

    public function update(UpdatePost $request, Post $post)
    {
        $this->authorize('update', $post);

        $data = $request->validated();
        $post = $this->postService->update($data, $post);
        return redirect()->route('posts.index')->with('success', 'post updated succcessfullly');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();
        return redirect()->route('posts.index')->with('success', 'post deleted succcessfullly');
    }
}
