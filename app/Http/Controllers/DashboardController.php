<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $posts = auth()->user()->posts()->orderBy('scheduled_time','asc');
        
        if ($request->status != null) {
            $posts->where('status', $request->status);
        }
        $events = $posts->get()->map(function ($post) {
            return [
                'title' => $post->title,
                'start' => $post->scheduled_time,
                'end' => $post->scheduled_time,
                'allDay' => true,
            ];
        });
        return view('dashboard',compact('events'));
    }

    
}
