@foreach($records as $record)
<div class="col-lg-12">
    <h3><a href="/document/{{ $record->id }}">{{ $record->title }}</a></h3>
    <p>{{ str_limit($record->content, 300) }}</p>
</div>

@endforeach