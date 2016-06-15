@extends('admin.layout')

@section('content')
{!! \App\Views\GridView::make($items)->render() !!}
@endsection