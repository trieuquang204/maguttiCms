<?php namespace App\maguttiCms\Api\V1\Controllers;

use App\Article;
use App\Block;
use App\maguttiCms\Admin\AdminFormFieldsProcessor as AdminFormFieldsProcessor;
use App\maguttiCms\Admin\DashBoardComponent;
use App\maguttiCms\Admin\NavBarComponent;
use App\maguttiCms\Domain\Block\Resources\BlockCollection;
use App\maguttiCms\Domain\Block\Resources\BlockResource;
use App\maguttiCms\Tools\CodeGeneratorHelper;
use Url;
use Validator;
use Illuminate\Http\Request;

use App\maguttiCms\Tools\JsonResponseTrait;

class AdminCrudController
{
    use JsonResponseTrait;

    protected $request;


    public function create($section,Request $request)
    {
        $this->request = $request;
        $item = getModelFromString($section);
        (new AdminFormFieldsProcessor($request))->requestFieldHandler($item);
        $this->setData($item)->responseSuccess();
        return $this->apiResponse();
    }

    public function update($section,$id,Request $request)
    {
        $this->request = $request;
        $item = getModelFromString($section)::find($id);
        (new AdminFormFieldsProcessor($request))->requestFieldHandler($item);
        $data = new BlockResource($item);
        $this->setData($data)->responseSuccess();
        return $this->apiResponse();
    }

}