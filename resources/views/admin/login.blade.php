@extends('layouts.master')

@section('title')
	Admin Login Page
@endsection

@section('content')
	<div class="container">
	@if(count($errors) > 0)
		<section class="info-box fail">
			@foreach($errors->all() as $error)
				{{ $error }}
			@endforeach
		</section>
	@endif
	@if(Session::has('fail'))
		<section class="info-box fail">
			{{ Session::get('fail') }}
		</section>
	@endif
		<div class="row">
			<div class="col-md-3">
				<form action="{{ route('post_login') }}" method="post">
					<div class="form-group">
						<label for="name">Your Name</label>
						<input type="text" class="form-control" name="name" id="name" placeholder="Your Name">
					</div>
					<div class="form-group">
						<label for="password">Your Password</label>
						<input type="password" class="form-control" name="password" id="password" placeholder="Your Password">
					</div>
					<input type="hidden" name="_token" value="{{ Session::token() }}">
					<button type="submit" class="btn btn-default">Submit</button>
				</form>
			</div>
		</div>
	</div>
@endsection