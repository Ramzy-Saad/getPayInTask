<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Platform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlatformController extends Controller
{
    public function index(Request $request)
    {
        $platforms = Platform::select('id', 'name', 'type')->get();
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

        $user = Auth::user();

        // 2. Determine current state
        $existing = $user->platformUsers()->where('platform_id', $data['platform_id'])->first();

        if ($existing) {
            $existing->delete();

            return response()->json([
                'message' => 'Platform deactivated',
            ]);
        }

        // Activate (create a new relation)
        $user->platformUsers()->create([
            'platform_id' => $data['platform_id'],
        ]);

        return response()->json([
            'message' => 'Platform activated',
        ]);
    }
}
