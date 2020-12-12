<div class="row form-group ">
    <div class="col-12  col-md-3 col-lg-7">
        <label class="text-left">{{trans('admin.label.street')}} <mark>*</mark></label>
        <input name="street" type="text" value="{{$model->street}}" class=" form-control">
    </div>
    <div class="col-12  col-md-3 col-lg-2">
        <label class="text-left">{{trans('admin.label.number')}} <mark>*</mark></label>
        <input name="number" type="text" value="{{$model->number}}" class=" form-control">
    </div>
    <div class="col-12  col-md-3 col-lg-3">
        <label class="text-left">{{trans('admin.label.zip_code')}} <mark>*</mark></label>
        <input name="zip_code" type="text" value="{{$model->zip_code}}" class=" form-control">
    </div>

</div>
<div class="row form-group ">
    <div class="col-12  col-md-7 col-lg-7">
        <label class="text-left">{{trans('admin.label.city')}} <mark>*</mark></label>
        <input name="city" type="text" value="{{$model->city}}" class=" form-control">
    </div>
    <div class="col-12  col-md-5 col-lg-5">
        <label class="text-left">{{trans('admin.label.province')}} <mark>*</mark></label>
        <input name="province" type="text" value="{{$model->province}}" class=" form-control">
    </div>
</div>
