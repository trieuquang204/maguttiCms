<div class="row cssRow  form-group ">
    <div class="col-12  col-md-3 col-lg-5">
        <input name="date_start" type="text"

               value="{{data_get($model,'date_start',$properties['default_value'])}}"
               class="form-control datetimepicker">
    </div>
    <div class="col-12  col-md-3 col-lg-2"><label>{{trans('admin.label.date_end')}} <mark>*</mark></label></div>
    <div class="col-12  col-md-3 col-lg-5">
        <input name="date_end" type="text" value="{{data_get($model,'date_end',$properties['default_value'])}}"
               class="form-control datetimepicker">
    </div>
</div>
