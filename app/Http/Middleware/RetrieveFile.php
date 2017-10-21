<?php

namespace App\Http\Middleware;

use App\File;
use Closure;

class RetrieveFile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $id = $request->route()->parameter('file');
        $file = File::find($id);
        if($request->user_id == $file->user_id || $file->id == 268 || $file->id == 267){
            return $next($request);
        }
        return redirect("/home");
    }
}
