@extends('layouts.app')

@section('content')

<div class="container">
  	<div class="row justify-content-center">
    	<div class="col-md-12">
	      	<router-view name="usersIndex"></router-view>
	    	<router-view></router-view>
    	</div>
  	</div>
</div>

@endsection 