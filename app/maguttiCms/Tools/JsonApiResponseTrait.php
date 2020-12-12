<?php

namespace App\maguttiCms\Tools;


use Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Response;

trait JsonApiResponseTrait
{

    protected $errors = false;
    protected $msg = "";
    protected $status = "KO";
    protected $data = null;
    protected $type = null;
    protected $attributes = null;
    protected $meta = "";
    protected $description = "";
    protected $httpStatus = "200";
    protected $enableLog = true;
    protected $api_error_channel = "api";
    protected $api_data_channel = "api_data";

    public    $code = "";
    public    $id = "";


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
     * @return mixed
     */
    public function getMsg()
    {
        return $this->msg;
    }


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
     * @param $meta
     * @return $this
     */
    public function addMeta($meta)
    {
        $this->meta = $meta;
        return $this;
    }


    /**
     * @param $httpStatus
     * @return $this
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
    | Response Handler shortcuts
    |--------------------------------------------------------------------------
    */

    /**
     * @param string $message
     * @return $this
     */
    public function responseSuccess($message = 'success')
    {

        $this->setType($message);
        return $this;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function responseWithError($message = '')
    {
        $result = [];
        $result['errors'] = $this->errors;
        $this->errorLogger($message);

        return response()->json($result, $this->getHttpStatus());
    }

    /**
     * @param string $message
     * @return $this
     */
    public function responseNotFound($message = '')
    {

        $this->setHttpStatus(Response::HTTP_BAD_REQUEST);
        $message = ($message) ?: __('api.errors.item_not_found');
        return $this->addValidationError(ErrorCodes::DataNotFound, $message)->responseWithValidationError();

    }

    /**
     * @return $this
     */
    public function responseWithInvalidData()
    {
        $this->setHttpStatus(Response::HTTP_BAD_REQUEST);
        return $this->addValidationError(ErrorCodes::InvalidParameters,
            'invalid_parameters')->responseWithValidationError();
        //return $this->addError(__('api.errors.invalid_data'))->responseWithError();
    }

    public function responseWithValidationError()
    {
        $this->setHttpStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        return $this->responseWithError();
    }

    public function responseWithForbidden()
    {
        $this->setHttpStatus(Response::HTTP_FORBIDDEN);

        return $this->addError('', __('api.errors.user_not_authorized'),
            ErrorCodes::UserUnauthorized)->responseWithError();
    }

    public function responseAsUnauthorized()
    {
        $this->setHttpStatus(Response::HTTP_UNAUTHORIZED);
        return $this->addError('', __('api.errors.unauthorized'), ErrorCodes::AuthUnauthorized)->responseWithError();
    }

    /**
     * Return the  json response
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiResponse()
    {
        $result = [];
        if ($this->id != '') {
            $result['data']['id'] = $this->id;
        }
        $result['data']['type'] = $this->getType();
        if ($this->getAttributes()) {
            $result['data']['attributes'] = $this->getAttributes();
        }
        return response()->json($result, $this->getHttpStatus());
    }

    public function errorLogger($message = '')
    {
        if ($this->isEnableLog()) {
            $message .= $this->getMsg();
            $content = Request::getContent();
            Log::channel('api')->error("Api [" . Request::fullUrl() . "] " . $message . ':' . print_r(Request::all(),
                    true) . ' - ' . $content . ' - ' . print_r($this->errors, true));
        }
    }


    public function dataLogger($message = '')
    {
        if ($this->isEnableLog()) {
            $message .= $this->getMsg();
            $content = Request::getContent();
            Log::channel('api')->info("Api [" . Request::fullUrl() . "] " . $message . ':' . print_r(Request::all(),
                    true) . ' - ' . $content);
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

    /**
     * @return null
     */
    public function getType()
    {
        return $this->type;
    }


    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }


    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }


    public function setModelAttributes($attributes, $show = true)
    {
        $this->setType(strtolower(class_basename($attributes)));
        $this->id = (string)$attributes->id;
        if ($show == true) {
            $this->attributes = $attributes;
        }
        return $this;
    }

    /**
     * @return null
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param null $code
     * @return JsonApiResponseTrait
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @param string $description
     * @return JsonApiResponseTrait
     */
    public function addDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function addValidationError($code, $description = '', $title = '', $meta = '')
    {
        $error['code'] = $code;
        $error['title'] = $title;
        $error['description'] = $description;
        if ($meta) $error['meta'] = $meta;
        $this->errors[] = $error;
        return $this;
    }

    public function addError($title, $description = '', $code = '', $meta = '')
    {

        $error['status'] = $this->getHttpStatus();
        $error['code'] = ($code) ? $code : ErrorCodes::InvalidParameters;
        $error['title'] = $title;
        $error['description'] = $description;
        if ($meta) $error['meta'] = '';
        $this->errors[] = $error;
        return $this;
    }

    public function addErrors($errors, $status = '')
    {
        if ($status) {
            $this->setHttpStatus($status);
        }
        foreach ($errors as $key => $value) {
            $description = (is_array($value)) ? $value[0] : $value;
            $this->addError($key, $description);
        }
        return $this;
    }

    public function validator($action, $request)
    {
        return Validator::make(
            $request->all(),
            config('laraCms.api.form_validation.' . $action)
        );
    }

    public function dataValidator($action, $data)
    {
        return Validator::make(
            $data['attributes'],
            config('laraCms.api.form_validation.' . $action)
        );
    }

}