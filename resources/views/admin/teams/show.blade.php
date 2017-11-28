@extends('admin.index')

@section('title', 'Delete team - Admin -')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route( 'admin.teams.destroy', [ 'teams' => $team->id ] ) }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <div class="form-group text-center">
                        	Do you want to delete the team <strong>{{ $team->name }}</strong>?
                        </div>

			@component('admin.form.submit')
				@slot('cancel', route('admin.teams.index'))
				
				@slot('context', 'danger')
				
				Delete team
			@endcomponent
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
