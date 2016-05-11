@extends('layouts.default')

@section('title', 'Page not found')

@section('content')
	<div class="error-page">
		<img class="error-image" src="{{ asset('/images/404.png') }}">
	</div>
@stop
