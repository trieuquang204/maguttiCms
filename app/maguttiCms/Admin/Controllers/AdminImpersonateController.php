<?php namespace App\maguttiCms\Admin\Controllers;

use App\Http\Controllers\Controller;
use Auth;


/*
|--------------------------------------------------------------------------
| AdminImpersonateController
|--------------------------------------------------------------------------
|
| superuser can impersonate admi user
|
*/
class AdminImpersonateController extends Controller
{

    /**
     * The redirect path after login success.
     * @var string
     */
    protected $redirectToAdmin = '/admin/';
    protected $redirectToUser = '/users/dashboard';

    /**
     * Impersonated Admin User
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function impersonateAdmin($id){
       return  (Auth::guard('admin')->loginUsingId($id)) ? redirect($this->redirectToAdmin) : die('pino');
    }

    /**
     * Impersonated FE User
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function impersonateUser($id){
        return  (Auth::loginUsingId($id)) ? redirect($this->redirectToUser) : die('pino');
    }

}