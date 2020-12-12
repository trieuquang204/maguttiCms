<div class="row form-group ">
    <div class="col-12  col-md-5 col-lg-5">
        <input name="lng" type="text" value="{{$model->lng}}" class=" form-control">
    </div>
    <div class="col-12  col-md-2 col-lg-2">
        <label>
            {{trans('admin.label.lat')}} <mark>*</mark>
        </label>
    </div>
    <div class="col-12  col-md-5 col-lg-5">
        <input name="lat" type="text" value="{{$model->lat}}" class=" form-control">
    </div>

</div>
