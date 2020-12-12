@include('flash::notification')
{{ Form::open(array('action' => '\App\maguttiCms\Website\Controllers\WebsiteFormController@getContactUsForm')) }}
	<div class="row">
		@if(isset($request_product_id))
			@if(isset($product))
				<div class="col-12">
					{{ Form::hidden('request_product_id', $request_product_id, ['class' => 'form-control']) }}
					<div class="form-group">
						{!! trans('website.message.product_request') !!}
						<mark>{{$product->title}}</mark>
					</div>
				</div>
			@endif
		@endif
		<div class="col-12 col-sm-6">
		    <div class="form-group">
		        {{ Form::text('name', null,  ['class' => 'form-control', 'required' , 'placeholder' => trans('website.name')]) }}
				<x-website.ui.form-error-label class="pt-1" field="name"></x-website.ui.form-error-label>
		    </div>
	    </div>
		<div class="col-12 col-sm-6">
		    <div class="form-group">
		        {{ Form::text('surname', null,  ['class' => 'form-control', 'required', 'placeholder' => trans('website.surname')]) }}
				<x-website.ui.form-error-label class="pt-1" field="surname"></x-website.ui.form-error-label>
		    </div>
	    </div>
		<div class="col-12 col-sm-6">
			<div class="form-group">
				{{ Form::email('email', null,  ['class' => 'form-control', 'required', 'placeholder' => trans('website.email')]) }}
				<x-website.ui.form-error-label class="pt-1" field="email"></x-website.ui.form-error-label>
			</div>
		</div>
		<div class="col-12 col-sm-6">
		    <div class="form-group">
		        {{ Form::text('company', null,  ['class' => 'form-control', 'placeholder' => trans('website.employer')]) }}
				<x-website.ui.form-error-label class="pt-1" field="company"></x-website.ui.form-error-label>
		    </div>
	    </div>
		<div class="col-12">
		    <div class="form-group">
		        {{ Form::text('subject', null,  ['class' => 'form-control', 'required', 'placeholder' => trans('website.subject')]) }}
		      	<x-website.ui.form-error-label class="pt-1" field="subject"></x-website.ui.form-error-label>
		    </div>
	    </div>
		<div class="col-12">
		    <div class="form-group">
		        {{ Form::textarea('message', null,  ['class' => 'form-control', 'rows' => 5, 'required', 'placeholder' => trans('website.message_email')]) }}
		      	<x-website.ui.form-error-label class="pt-1" field="message"></x-website.ui.form-error-label>
		    </div>
	    </div>
		<div class="col-12 col-sm-6">
		    <div class="form-group">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" name="privacy" value="1" id="privacy" required>

					<label class="custom-control-label" for="privacy">
						<a href="https://www.iubenda.com/privacy-policy/{{ data_get($site_settings,'iubenda_code_'.LaravelLocalization::getCurrentLocale()) }}" class="iubenda-nostyle no-brand iubenda-embed " title="{{ trans('website.privacy')}}">
							{{trans('website.message.privacy')}}
						</a>
					</label>
					<x-website.ui.form-error-label class="pt-1" field="privacy"></x-website.ui.form-error-label>

				</div>
		    </div>
	    </div>
		@if (data_get($site_settings,'captcha_site'))
			<div class="col-12 col-sm-6">
				<div class="form-group pull-right">
					<div class="g-recaptcha" data-sitekey="{{data_get($site_settings,'captcha_site')}}"></div>
				</div>
			</div>
		@endif
		<div class="col-12 col-sm-6">
		    <div class="form-group ">
		        {{ Form::submit(trans('website.send'), array('class' => 'btn btn-lg btn-primary btn-block')) }}
	    	</div>
	    </div>
	</div>
{{ Form::close() }}
