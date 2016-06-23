@foreach($records as $record)
<div class="col-lg-12">
    <h4><a href="/document/{{ $record->id }}">{{ $record->title }}</a></h4>
    <p class="small">{!! $record->content !!}</p>
</div>

@endforeach