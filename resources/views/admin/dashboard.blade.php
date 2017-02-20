@extends('layouts.master')

@section('title')
	Dashboard
@endsection

@section('content')
	<div class="container">
		<ul>
			@foreach($authors as $author)
				<li>{{ $author->name }} ({{ $author->email }})</li>
			@endforeach
		</ul>
	</div>
@endsection