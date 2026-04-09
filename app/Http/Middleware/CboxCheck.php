<?php

namespace App\Http\Middleware;

use Closure;
use App\Modules\Chat\Models\Cbox;
use Illuminate\Http\Request;

class CboxCheck
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        $cboxs = Cbox::where('token', $token)->get()->pluck('room_id');
        if(!$cboxs->isEmpty()){
            if($request->room_id && !$cboxs->contains($request->room_id)){
                return false;
            }
            return $next($request);
        }

        return false;
    }
}
