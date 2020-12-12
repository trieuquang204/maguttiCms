@extends('website.app')
@section('content')
	<x-website.ui.breadcrumbs class="bg-accent">
		<div class="text-white page-breadcrumb d-flex align-items-end">
			@if($article->parent)
				<div class="page-breadcrumb__item">{{$article->parent->title}}</div>
			@endif
			<div class="page-breadcrumb__item">{{$article->menu_title}}</div>
		</div>
	</x-website.ui.breadcrumbs>
	<main class="my-2">
        <div class="container">
			@if (StoreHelper::isStoreEnabled())
				<div class="my-0">
					<h3 class="text-muted">{{trans('store.dashboard.orders')}}</h3>
					<table class="table">
						<thead>
							<tr>
								<th>{{trans('store.dashboard.table.date')}}</th>
								<th>{{trans('store.dashboard.table.products')}}</th>
								<th>{{trans('store.dashboard.table.total')}}</th>
								<th>{{trans('store.dashboard.table.payment')}}</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($orders as $_order)
								<tr>
									<td>
										{{Carbon::parse($_order->created_at)->format('d/m/Y')}}<br>
										{{Carbon::parse($_order->created_at)->format('H:i:s')}}
									</td>
									<td>
										<ul>
											@foreach ($_order->order_items as $_item)
												<li>{{$_item->quantity}}x {{$_item->product->title}}</li>
											@endforeach
										</ul>
									</td>
									<td>{{StoreHelper::formatPrice($_order->total_cost)}}</td>
									@if ($_order->payment)
										<td>
											{{$_order->payment->payment_method->title}} -
											@if ($_order->payment->is_paid)
												{{trans('store.payment.paid')}}
											@else
												{{trans('store.payment.unpaid')}}
											@endif
										</td>
									@else
										<td>
											<a class="btn btn-primary btn-sm" href="{{$_order->getPermalink()}}">
												{{trans('store.payment.pay')}}
											</a>
										</td>
									@endif
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>

				<div class="my-4">
					<h3 class="text-muted">{{ trans('store.dashboard.addresses') }}</h3>
					<ul>
						@foreach ($addresses as $_address)
							<li>{{$_address->display_inline}}</li>
						@endforeach
					</ul>
					<a class="btn btn-primary" href="{{url_locale('/users/address-new')}}">
						{{trans('store.address.new')}}
					</a>
				</div>
			@endif
        </div>
    </main>

@endsection
