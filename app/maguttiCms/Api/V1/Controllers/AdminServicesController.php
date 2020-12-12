<?php namespace App\maguttiCms\Api\V1\Controllers;

use App\maguttiCms\Admin\DashBoardComponent;
use App\maguttiCms\Admin\NavBarComponent;
use App\maguttiCms\Tools\CodeGeneratorHelper;
use Url;
use Validator;
use Illuminate\Http\Request;

use App\maguttiCms\Tools\JsonResponseTrait;

class AdminServicesController
{
    use JsonResponseTrait;

    protected $request;


    public function dashboard(Request $request)
    {
        $this->request = $request;
        $data = (new DashBoardComponent($this->request))->getData();
        ($data) ? $this->setData($data)->responseSuccess(): $this->setEnableLog(false)->responseWithError();
        return $this->apiResponse();
    }

    public function navbar(Request $request)
    {
        $this->request = $request;
        $data = (new NavBarComponent($this->request))->getData();
        ($data) ? $this->setData($data)->responseSuccess(): $this->setEnableLog(false)->responseWithError();
        return $this->apiResponse();
    }

    public function generator(Request $request)
    {
        $this->request = $request;
        $data = (new CodeGeneratorHelper())->handleGenerator($this->request->data,$this->request->value);
        $this->setData($data)->responseSuccess();
        return $this->apiResponse();
    }
}