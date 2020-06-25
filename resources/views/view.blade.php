@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        @if ( strlen( $error ) != 0 )
            <div class="alert alert-success text-center">
                <p>{{ $error }}</p>
            </div>
        @endif

        <div class="text-left">
            <a href="/user" class="btn btn-info"> Back</a>
        </div>

        <div class="row">

        	<div class="col-md-5 col-sm-12 m-auto">
        		<form method="POST">
        			@csrf
        			@method('PUT')
			        <div class="form-group">
				        <label for="name">Name</label>
				        <input id="name" type="text" name="name" class="form-control" value="{{ $user->name }}">
				    </div>
				    <div class="form-group">
				        <label for="email">Email Address</label>
				        <input id="email" type="email" class="form-control" value="{{ $user->email }}" readonly>
				    </div>
				    <div class="form-group">
				        <label for="phone">Phone Number</label>
				        <input id="phone" type="text" name="phone" class="form-control" value="{{ $user->phone }}">
				    </div>
				    <div class="form-group">
				        <label for="password">Password</label>
				        <input id="password" name="password" type="password" class="form-control" value="{{ $user->password }}">
				    </div>

				    <div class="form-group">
				        <button type="submit" class="btn btn-info"> Update</button>
				    </div>
			    </form>
			</div>
		</div>

    </div>
@endsection
