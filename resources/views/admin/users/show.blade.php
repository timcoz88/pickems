@extends('admin.index')

@section('title', 'Delete user - Admin -')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route( 'admin.users.destroy', [ 'users' => $user->id ] ) }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <div class="form-group text-center">
                        	Do you want to delete the user <strong>{{ $user->name }}</strong>?
                        </div>

			@component('admin.form.submit')
				@slot('cancel', route( 'admin.users.index' ))
				
				@slot('context', 'danger')
				
				Delete user
			@endcomponent
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
