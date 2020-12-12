@extends('website.app')
@section('content')
	<x-website.partials.page-header  :title="trans('store.order.title')" :class="'bg-accent'"/>
    <section>
        <div class="container">
            @include('flash::notification')
            <h3>{{trans('store.order.resume')}}</h3>
        	<table class="table">
        		<thead>
        			<tr>
        				<th class="width-10">{{trans('store.cart.table.code')}}</th>
        				<th>{{trans('store.cart.table.name')}}</th>
        				<th class="width-10">{{trans('store.cart.table.quantity')}}</th>
        				<th class="width-10">{{trans('store.cart.table.price')}}</th>
        				<th class="width-10">{{trans('store.cart.table.total')}}</th>
        			</tr>
        		</thead>
        		<tbody>
        			@foreach ($cart->items as $_item)
        				<tr data-price="{{StoreHelper::getProductPrice($_item->product)}}">
        					<td>
        						{{$_item->product->code}}
        					</td>
        					<td>
        						{{$_item->product->title}}
        					</td>
        					<td>{{$_item->quantity}}</td>
        					<td>{{StoreHelper::formatProductPrice($_item->product)}}</td>
        					<td>{{StoreHelper::formatProductPrice($_item->product, $_item->quantity)}}</td>
        				</tr>
        			@endforeach
        		</tbody>
        	</table>
            <hr />
            <form action="" method="post">
        		{{ csrf_field() }}
        		<input id="order-cart" type="hidden" name="cart_id" value="{{$cart->cart->id}}">
        		<h3>{{trans('store.order.addresses')}}</h3>
        		<div class="row">
        			<div class="col-12 col-sm-6">
        				<label>{{trans('store.order.billing')}}</label>
        				<select id="order-shipping-address" class="form-control order-preview" name="billing_address_id" required>
        					@foreach ($addresses as $_address)
        						<option value="{{$_address->id}}">{!!$_address->display_inline!!}</option>
        					@endforeach
        				</select>
        			</div>
        			@if (StoreHelper::isShippingEnabled())
        				<div class="col-12 col-sm-6">
        					<label>{{trans('store.order.shipping')}}</label>
        					<select id="order-shipping-address" class="form-control order-preview" name="shipping_address_id">
        						<option></option>
        						@foreach ($addresses as $_address)
        							<option value="{{$_address->id}}">{!!$_address->display_inline!!}</option>
        						@endforeach
        					</select>
        				</div>
        			@endif
        			<div class="col-12 mt30">
        				<a class="btn btn-primary" href="{{url_locale('/users/address-new')}}">
        					{{trans('store.address.new')}}
        				</a>
        			</div>
        		</div>

                <hr />

        		<div class="row">
        			<div class="col-12 col-sm-6">
        				<h3>{{trans('store.order.totals')}}</h3>
        				<table class="table">
        					<tbody>
        						<tr>
        							<th>{{trans('store.order.products_cost')}}</th>
        							<td class="order-products-cost"></td>
        						</tr>
        						<tr>
        							<th>{{trans('store.order.shipping_cost')}}</th>
        							<td class="order-shipping-cost"></td>
        						</tr>
        						<tr>
        							<th>{{trans('store.order.discount.title')}}</th>
        							<td class="order-discount"></td>
        						</tr>
        						<tr>
        							<th>{{trans('store.order.vat_cost')}}</th>
        							<td class="order-vat-cost"></td>
        						</tr>
        					</tbody>
        					<tfoot>
        						<tr>
        							<th>{{trans('store.order.total_cost')}}</th>
        							<th class="order-total-cost"></th>
        						</tr>
        					</tfoot>
        				</table>
        			</div>
        			<div class="col-12 col-sm-6">
        				<h3>{{trans('store.order.discount.title')}}</h3>
        				<p>{{trans('store.order.discount.insert')}}</p>
        				<input id="order-discount-input" type="text" name="discount_code" class="form-control order-preview">
        				<div id="order-discount-alert">
        					<div class="alert"></div>
        				</div>
        				<hr>
        				<button type="submit" class="btn btn-primary pull-right" href="{{url_locale('cart')}}">
        					{{trans('store.order.confirm')}}
        				</button>
        			</div>
        		</div>
            </form>
        </div>
    </section>

@endsection
