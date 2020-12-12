@if(data_get($properties,'row-item','start')=='start')
    <div class="row cssRow  form-group {{(isset($properties['cssRow']))? $properties['cssRow']: ''}}">
		@endif
        @if (isset($properties['headerLabel']))
            <div class="col-12">
                <h3>{{$properties['headerLabel']}}</h3>
            </div>
        @endif
       @if(data_get($properties,'is_full_component'))
            {!!$form_element!!}
       @else
            <div class="{{ data_get($properties,'label_css','col-12 col-sm-3 col-lg-2')}}">
                @include('admin.inputs.label')
            </div>

            <div class="col-12  {{ ($css_class!='')? $css_class: 'col-sm-9 col-lg-10' }}">
                {!!$form_element!!}
            </div>
        @endif



		@if(data_get($properties,'row-item','stop')=='stop')
    </div>
@endif

