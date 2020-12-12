<?php

namespace App\maguttiCms\Website\Controllers;

use App\maguttiCms\Tools\JsonResponseTrait;
use App\maguttiCms\Tools\StoreHelper;
use App\maguttiCms\Website\Requests\AjaxFormRequest;

class StoreAPIController extends APIController
{
	private $response = [];
    use JsonResponseTrait;

	public function __construct() {}

	public function storeCartItemAdd(AjaxFormRequest $request)
	{
		$result = StoreHelper::cartItemAdd($request->only('product_code','quantity','product_model'));
		if ($result) {
			$message= [
				'text'	=> trans('store.alerts.add_success'),
				'type'	=> 'success',
				'time'	=> 3
			];
            $this->setData($result)->responseSuccess();
   		}
		else {
            $message=  [
				'text'	=> trans('store.alerts.add_fail'),
				'type'	=> 'warning',
				'time'	=> 5
			];
		}
        return $this->setMsg($message)->apiResponse();
	}


    public function updateItemQuantity(AjaxFormRequest $request)
    {
        $result = StoreHelper::updateItemQuantity($request->only('id','quantity'));
        if ($result) {
            $message= [
                'text'	=> trans('store.alerts.add_success'),
                'type'	=> 'success',
                'time'	=> 3
            ];
            $this->setData($result)->responseSuccess();
        }
        else {
            $message=  [
                'text'	=> trans('store.alerts.add_fail'),
                'type'	=> 'warning',
                'time'	=> 5
            ];
        }
        return $this->setMsg($message)->apiResponse();
    }

	public function storeCartItemRemove(AjaxFormRequest $request)
	{
	    $result = StoreHelper::cartItemRemove($request->id);
		if ($result) {
			$message= [
				'text'	=> trans('store.alerts.remove_success'),
				'type'	=> 'success',
				'time'	=> 3
			];
            $this->setData($result)->responseSuccess();
		}
		else {
			$message=[
				'text'	=> trans('store.alerts.remove_fail'),
				'type'	=> 'warning',
				'time'	=> 5
			];
		}
        return $this->setMsg($message)->apiResponse();
	}

	public function storeOrderCalc(AjaxFormRequest $request)
	{
		$cart = StoreHelper::getSessionCart();
		if ($cart && $cart->id = $request->cart) {
			$result = StoreHelper::calcCosts($cart, $request->address, $request->discount_code);
			if ($result)
				return response()->json($result);
			else
				return response()->json(false);
		}
		return response()->json(false);
	}

	public function storeOrderDiscount(AjaxformRequest $request)
	{
		$discount = StoreHelper::getDiscount($request->code);
		if ($discount) {
			return response()->json([
				'valid' => true,
				'message' => sprintf(trans('store.order.discount.valid'), $discount->amount)
			]);
		} else {
			return response()->json([
				'valid' => false,
				'message' => trans('store.order.discount.invalid')
			]);
		}
	}
}
