<form class="form-horizontal">
    @foreach($model->getAttributes() as $attribute_name => $attribute_value)
        <div class="form-group">
            <label class="col-sm-2 control-label" for="attribute-{{ $attribute_name }}">{{ $model->getFieldTitle($attribute_name) }}</label>
            <div class="col-sm-8">
                {!! $model->getFieldWidget($attribute_name, 'form') !!}
            </div>
        </div>
    @endforeach
</form>