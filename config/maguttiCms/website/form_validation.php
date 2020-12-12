<?php
return [

		'contacts' => [
			'name'	  => 'required',
			'surname' => 'required',
            'subject' => 'required',
			'message' => 'required',
			'privacy' => 'required',
			'email'   => 'required|Between:3,64|Email',
			'request_product_id' => 'exists:products,id',
            'g-recaptcha-response'=>'sometimes|required|recaptcha'
		],

		'newsletter' => [
			'email' => 'required|Between:3,64|Email|unique:newsletters',
			'privacy' => 'required'
		],

		'cart-item-add' => [
			'product_code' => 'required',
			'quantity'     => 'required|numeric|min:1'
		],

		'cart-item-remove' => [
			'id' => 'required',
		],
        'cart-item-update' => [
			'id' => 'required',
            'quantity'     => 'required|numeric|min:1'
		],

		'order-submit' => [
			'cart_id'             => 'required|numeric',
			'billing_address_id'  => 'required|numeric',
			'shipping_address_id' => 'numeric'
		],

		'order-payment' => [
			'order_id'          => 'required|numeric',
			'payment_method_id' => 'required|numeric'
		],

		'order-calc' => [
			'cart' => 'required|numeric',
			'address' => 'required'
		],

		'order-discount' => [
			'code' => 'required|alpha_num'
		],

		'update-ghost' => [
			'id' => 'required|numeric',
			'model' => 'required',
			'field' => 'required',
			'value' => 'required',
		],

		'address-new' => [
			'street'     => 'required',
			'number'     => 'required',
			'zip_code'   => 'required',
			'city'       => 'required',
			'province'   => 'required',
			'country_id' => 'required|numeric',
			'email'      => 'email'
		]
];
