@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>
                        This is a basic CRUD/CMS app written in <a href="https://laravel.com" target="_blank">Laravel</a> and <a href="https://vuejs.org" target="_blank">Vue</a> by <a href="http://doncadavona.com" target="_blank">Don Cadavona</a>.
                    </p>
                    <p>
                        <a href="{{ route('users.index') }}" class="btn btn-primary">Manage Users</a>
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
