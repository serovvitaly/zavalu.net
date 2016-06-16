@extends('admin.layout')

@section('content')
    {!! \App\Views\FormView::make($model)->render() !!}
@endsection