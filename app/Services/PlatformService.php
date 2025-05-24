<?php
namespace App\Services;

use App\Models\Platform;
use Auth;

class PlatformService {


    public function index(){
        $platforms = Platform::select('id', 'name', 'type')->get();
        return $platforms;
    }

    public function toggle($platform_id){
        $user = Auth::user();
        $existing = $user->platformUsers()->where('platform_id', $platform_id)->first();

        if ($existing) {
            $existing->delete();
            $message = "Platform deactivated";
        }else{
            $user->platformUsers()->create([
                'platform_id' => $platform_id,
            ]);
            $message = "Platform activated";
        }
        return $message;
    }

}