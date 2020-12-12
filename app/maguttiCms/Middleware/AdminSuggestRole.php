<?php

namespace App\maguttiCms\Middleware;

use Closure;
// Add Response namespace
use Illuminate\Http\Response;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminSuggestRole extends AdminRole
{
	public function handle($request, Closure $next)
	{
		$this->request = $request;
		$this->config = config('maguttiCms.admin.list.section.'.Str::plural($request->model));
		if (!$this->canAccess()) {
            return redirect('/admin');
		}
		return $next($this->request);
	}
}
