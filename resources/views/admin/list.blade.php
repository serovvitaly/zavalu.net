@extends('admin.layout')

@section('content')
<div class="small">{!! $items->links() !!}</div>
<table class="table small">
    @foreach($items as $item)
    <tr>
        @foreach($item->getAttributes() as $attribute)
        <td>{{ $attribute }}</td>
        @endforeach
        <td style="width: 70px;">
            <a href="/admin/product/{{ $item->id }}/edit" class="btn btn-default btn-xs" title="Редактировать"><span class="glyphicon glyphicon-pencil"></span></a>
            <button type="button" class="btn btn-danger btn-xs" title="Удалить"><span class="glyphicon glyphicon-remove"></span></button>
        </td>
    </tr>
    @endforeach
</table>
<div class="small">{!! $items->links() !!}</div>
@endsection