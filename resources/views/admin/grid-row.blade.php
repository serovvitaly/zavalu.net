<tr>
    @foreach($model->getAttributes() as $attribute_name => $attribute)
        <td>{!! $model->getFieldWidget($attribute_name, 'grid') !!}</td>
    @endforeach
    <td style="width: 70px;">
        <a href="/admin/product/{{ $model->id }}/edit" class="btn btn-default btn-xs" title="Редактировать"><span class="glyphicon glyphicon-pencil"></span></a>
        <button type="button" class="btn btn-danger btn-xs" title="Удалить"><span class="glyphicon glyphicon-remove"></span></button>
    </td>
</tr>