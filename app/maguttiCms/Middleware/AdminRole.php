<?php

namespace App\maguttiCms\Middleware;

use Closure;
// Add Response namespace
use Illuminate\Http\Response;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;

class AdminRole
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	protected $model;
	protected $model_id;
	protected $config;
	protected $routeName;
	protected $request;
	protected $modelClass;
	protected $segments;

	public function handle($request, Closure $next)
	{
		$this->request = $request;
		$this->model = $this->request ->route('section');
		$this->model_id = $this->request ->route('id');
		$this->routeName = $this->request ->path();
		$this->config = config('maguttiCms.admin.list.section.'.$this->model);
		$this->modelClass = 'App\\'.$this->config['model'];

		if ($this->getCurrentAction() == 'delete' && $this->canDelete()) {
			return $next($this->request);
		} elseif ($this->canAccess()) {
		    return $next($this->request);
		} else {
			return redirect('/admin');
		}
		return $next($this->request);
	}

	public function canAccess()
	{
		return (!isset($this->config['roles']) || cmsUserHasRole($this->config['roles']))?$this->specialRules():false;
	}

	public function specialRules()
	{
		// user puo creare solo lo shop ma non acceder alla lista;
		if ($this->config['model'] == 'Shop' && !cmsUserHasRole(['su', 'admin']) && $this->isList()) {
			return false;
		}
		return true;
	}

	public function isList()
	{
		return  ($this->getCurrentAction() == 'list') ? true:false;
	}
	public function getCurrentAction()
	{
		return  $this->request->segment('2');
	}
}
