@extends('layout')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <hr>
    </div>
    <div class="col-lg-12">
        <div class="input-group">
            <input class="form-control input-lg" type="text" placeholder="введите запрос для поиска">
            <span class="input-group-btn">
                <button class="btn btn-default btn-lg" type="button" title="Поиск"><span class="glyphicon glyphicon-search"></span></button>
            </span>
        </div>
    </div>
    <div class="col-lg-12">
        <hr>
    </div>
</div>
@endsection