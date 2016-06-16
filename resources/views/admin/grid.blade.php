<div class="small">{!! $model->links() !!}</div>
<table class="table table-bordered small">
    @foreach($model as $item)
        {!! \App\Views\GridRowView::make($item)->render() !!}
    @endforeach
</table>
<div class="small">{!! $model->links() !!}</div>

