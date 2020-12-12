<?php namespace App\maguttiCms\Tools;
/**
 * Class JsonResponseTrait
 *
 *
 */
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

trait JsonResponseTrait
{

    protected $error  = false;
    protected $msg    = "";
    protected $status = "KO";
    protected $data   = null;
    protected $meta   = null;
    protected $last_update = null;
    protected $httpStatus = "200";
    protected $enableLog  = true;

    public static function bootJsonResponseTrait()
    {
        static::created(function($item){
            // Index the item
        });
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param mixed $error
     */
    public function setError($error)
    {
        $this->error = $error;
        return;
    }

    /**
     * @param mixed $msg
     * @return JsonResponseTrait
     */
    public function setMsg($msg)
    {
        $this->msg = $msg;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * @param string $status
     * @return JsonResponseTrait
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param array $data
     * @return JsonResponseTrait
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param null $meta
     * @return JsonResponseTrait
     */
    public function setMeta($meta)
    {
        $this->meta = $meta;
        return $this;
    }

    public function getMeta()
    {
        return $this->meta;
    }


    /**
     * @param string $httpStatus
     * @return JsonResponseTrait
     */
    public function setHttpStatus($httpStatus)
    {
        $this->httpStatus = $httpStatus;
        return $this;
    }
    /**
     * @return string
     */
    public function getHttpStatus()
    {
        return $this->httpStatus;
    }

    /*
    |--------------------------------------------------------------------------
    | Response  Handler shorcuts
    |--------------------------------------------------------------------------
    */

    /**
     * @param string $message
     * @return $this
     */
    public  function responseSuccess($message=''){
        $this->setStatus('OK');
        if($message) $this->setMsg($message);
        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public  function responseWithError($message=''){
        $this->setStatus('KO');
        $this->setHttpStatus(422);
        $this->setError(true);
        $this->errorLogger($message);
        if($message) $this->setMsg($message);
        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public  function responseNotFound($message=''){
        if($message) $this->responseWithError($message);
        else $this->responseWithError(__('api.errors.item_not_found') );
        return $this;
    }

    /**
     * @return $this
     */
    public function responseWithInvalidData(){
        $this->responseWithError(__('api.errors.invalid_data') );
        return $this;
    }

    /**
     * Return the  json response
     * @return \Illuminate\Http\JsonResponse
     */
    public  function apiResponse(){
        $result = [];
        $result['status']       = $this->getStatus();
        $result['error']        = $this->getError();
        $result['msg']          = $this->getMsg();
        $result['server_time']  = date("Y-m-d H:i:s");
        if($this->getMeta()!=''){
            $result['meta']     = $this->getMeta();
        }
        $result['data']         = $this->getData();
        return response()->json($result,$this->getHttpStatus());
    }


    public  function errorLogger($message='')
    {
        if($this->isEnableLog()){
            $message.=$this->getMsg();
            Log::error("Api [".Request::fullUrl()."] ".$message . ':'.print_r(Request::all(), TRUE));
        }
      }

    /**
     * @param bool $enableLog
     * @return JsonResponseTrait
     */
    public function setEnableLog($enableLog)
    {
        $this->enableLog = $enableLog;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEnableLog()
    {
        return $this->enableLog;
    }
}
