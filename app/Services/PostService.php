<?php
namespace App\Services;

use Auth;

class PostService {


    public function index($request){
        $query = Auth::user()->posts()->with('platforms');
        
        if ($request->status != null) {
            $query->where('status', $request->status);
        }
        
        if ($request->date != null) {
            $query->whereDate('scheduled_time', $request->date);
        }
        
        return $query;
    }
    public function store($data){
        $post = Auth::user()->posts()->create($data);

        $post->platforms()->attach(
            collect($data['platforms'])->mapWithKeys(function ($id) {
                return [$id => ['platform_status' => 'pending']];
            }),
        );
        return $post;
    }

    public function update($data, $post){
        $post->update($data);
        $post->platforms()->sync(
            collect($data['platforms'])->mapWithKeys(function ($id) {
                return [$id => ['platform_status' => 'pending']];
            }),
        );
        return $post;
    }

}