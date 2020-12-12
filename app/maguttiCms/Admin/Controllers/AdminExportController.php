<?php

namespace App\maguttiCms\Admin\Controllers;

use App\maguttiCms\Exports\ExportHelper;
use App\maguttiCms\Exports\AdminListExporter;
use App\maguttiCms\Exports\CollectionExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

use Input;



/**
 * Class AdminExportController
 * @package App\maguttiCms\Admin\Controllers
 */
class AdminExportController extends Controller
{
    protected $model;
    protected $models;
    protected $modelClass;
    protected $curObject;
    protected $request;
    protected $config;
    protected $id;

    /*
    |--------------------------------------------------------------------------
    |
    | EXPORT  WITH MAATWEBSITE\EXCEL\FACADES\EXCEL
    |
    |--------------------------------------------------------------------------
    */
    public function list($model, $sub = '')
    {
        if (request()->filled('debug')) return ExportHelper::exportFilename($model);
        return Excel::download(new AdminListExporter($model), ExportHelper::exportFilename($model));
    }


    public function list_from_collection($model, $sub = '')
    {
        $ExportHelper = new AdminListExporter($model);
        $data = $ExportHelper->addHeader()->getDataToExport();
        if (request()->filled('debug')) return $ExportHelper->getFileName();
        return Excel::download(new CollectionExport($data), $ExportHelper->getFileName());
    }



    /*
    |--------------------------------------------------------------------------
    |
    | EXPORT IN CSV FORMAT
    |
    |--------------------------------------------------------------------------
    */

    /**
     *
     * @param $model
     * @return mixed
     */
    public function list_csv($model)
    {
        return (new AdminListExporter($model))->setExtension('csv')->downloadData();
    }

    /**
     * RUN QUEUE TO GENERATE REPORT
     * @param $model
     * @return mixed
     */
    public function queue($model)
    {
        Artisan::queue('export:csv', ['report' => $model]);
        $responseMessage = trans('admin.message.report_in_execution');
        return $this->responseSuccess($responseMessage)->apiResponse();
    }

    /**
     * DOWNLOAD REPORT
     * @param $model
     * @return mixed
     */
    public function download($model)
    {
        return (new AdminListExporter())->init($model)->responseWithData();
    }

    public function run($model)
    {
        Artisan::call('export:csv', ['report' => $model]);
    }
}