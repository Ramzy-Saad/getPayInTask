<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Platform;
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
        return response()->json([
            'data' => $platforms,
        ]);
    }
    public function my_platforms(Request $request)
    {
        $user = Auth::user();
        $platforms = $user->platformUsers()->with('platform:id,name,type')->get()->pluck('platform')->filter();

        return response()->json([
            'data' => $platforms,
        ]);
    }

    public function toggle(Request $request)
    {
        $data = $request->validate([
            'platform_id' => 'required|exists:platforms,id',
        ]);
        $message = $this->platformService->toggle($data['platform_id']);
        return response()->json([
            'message' => $message,
        ]);
    }
}
