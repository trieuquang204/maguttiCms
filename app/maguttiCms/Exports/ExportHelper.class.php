<?php

namespace App\maguttiCms\Exports;

use Response;
use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

/**
 * Class ExportHelper
 * @package App\LaraCms\Exports
 */
class ExportHelper
{

    protected $model;
    protected $modelClass;
    protected $config;
    protected $fileName;
    protected $storage = "app/report/";
    protected $itemsArray = [];
    protected $ext = 'xlsx';
    /**
     * @var array|\Illuminate\Http\Request|string
     */
    protected $request;


    function fileStorage()
    {
        (new Filesystem)->ensureDirectoryExists(storage_path($this->storage));
        return storage_path($this->storage . $this->fileName);
    }

    function storage($storage)
    {
        $this->storage = $storage;
        return $this;
    }

    public function setFilename($name)
    {
        $this->fileName = $name.'.'.$this->ext ;
        return $this;
    }
    function setExtension($ext){

        $this->ext =$ext;
        return $this;
    }

    public function getHeadersFromConfig()
    {
        return collect($this->config['field_exportable'])->pluck('label')->toArray();
    }


    function reportPath()
    {
        return "report/" . $this->fileName;

    }

    function getLatestGenaratedReport($model)
    {
        $report = (new self)->setFilename($model)->reportPath();
        return (Storage::exists($report)) ? Carbon::createFromTimestamp(Storage::lastModified($report))->toDateTimeString() : null;
    }

    /**
     * @return mixed
     */
    public function downloadData()
    {
        $time_start = microtime(true);
        $FH = fopen($this->fileStorage(), 'w');
        fputcsv($FH, $this->getHeadersFromConfig(), ';');
        $items = $this->getData();
        $items->each(function ($item) use ($FH) {

            $item = $this->mapData($item);
            fputcsv($FH, $item, ';');
        }, 50000);

        $time[] = 'Total execution time in seconds: ' . (microtime(true) - $time_start) . " - Created at " . Carbon::now();

        if (auth() && auth_user('admin')->isSu()) {
            fputcsv($FH, $time, ';');
        }

        fclose($FH);
        return $this->responseWithData();
    }

    /*
     *  STORE DATA FOR REPORT
     */
    public function storeData()
    {
        $time_start = microtime(true);
        $FH = fopen($this->fileStorage(), 'w');
        fputcsv($FH, $this->getHeadersFromConfig(), ';');
        echo $end = 'Start: ' . (microtime(true) - $time_start) . " - Created at " . Carbon::now() . '' . PHP_EOL;
        $items = $this->getData();
        //echo $items->toSql() . '' . PHP_EOL;
        echo $end = 'Get Data: ' . (microtime(true) - $time_start) . " - Created at " . Carbon::now() . '' . PHP_EOL;
        $items->each(function ($item) use ($FH) {
            $item = $this->mapData($item);
            fputcsv($FH, $item, ';');
        }, 50000);
        /*$items = $this->gen();
        foreach ($items as $item){
            $item  = $this->mapData($item);
            fputcsv($FH, $item,';');
        }*/
        echo $end = 'Total execution time in seconds: ' . (microtime(true) - $time_start) . " - Created at " . Carbon::now();
        $time[] = $end;
        fputcsv($FH, $time, ';');
        fclose($FH);
    }

    /** DOWNLOAD REPORT
     * @return mixed
     */
    function responseWithData(){
        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
            ,   'Content-type'        => 'text/csv'
            ,   'Content-Disposition' => 'attachment; filename='.$this->fileName
            ,   'Expires'             => '0'
            ,   'Pragma'              => 'public'
        ];
        return Response::download($this->fileStorage(),$this->fileName, $headers);
    }

    /**
     *  STREAM REPORT
     * @param $data
     * @return mixed
     */
    function stream($data){
        $callback = function() use ($data)
        {
            $FH = fopen('php://output', 'w');
            foreach ($data as $row) {
                fputcsv($FH, $row,';');
            }
            fclose($FH);
        };
        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
            ,   'Content-type'        => 'text/csv'
            ,   'Content-Disposition' => 'attachment; filename='.$this->getFileName()
            ,   'Expires'             => '0'
            ,   'Pragma'              => 'public'
        ];
        return Response::stream($callback, 200, $headers);
    }

    static function exportFilename($filename)
    {
        return $filename . '_' . date('Y-m-d') . '.xlsx';
    }
}
