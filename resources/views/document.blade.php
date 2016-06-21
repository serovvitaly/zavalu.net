@extends('layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <hr>
        </div>
        <div class="col-lg-12">
            <h1>{{ $model->title }}</h1>
            <p>{{ $model->content }}</p>
        </div>
    </div>
@endsection