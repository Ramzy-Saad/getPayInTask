<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePost;
use App\Http\Requests\UpdatePost;
use App\Models\Platform;
use App\Models\PlatformUser;
use App\Models\Post;
use App\Http\Resources\PostResource;
use App\Services\PlatformService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlatformController extends Controller
{

    protected $platformService;

    public function __construct(PlatformService $platformService )
    {
        $this->platformService = $platformService;
    }

    public function index(Request $request)
    {
        $platforms =  $this->platformService->index(); 
        $my_platforms_ids = auth()->user()->platformUsers()->with('platform:id,name,type')->pluck('platform_id')->toArray();
        $platforms = $platforms->map(function($platform) use($my_platforms_ids){
            $platform['status']= in_array($platform->id,$my_platforms_ids);
            $platform['status']= in_array($platform->id,$my_platforms_ids);
            return $platform;
        });
        return view('platforms.index',compact('platforms'));
    }
    public function show(Platform $platform)
    {
        $message = $this->platformService->toggle($platform->id); 
        return back()->with('success',$message);
    }



}
