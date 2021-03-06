@extends('admin.index')

@section('title', __('Delete league') . ' - ' . __('Admin') . ' -')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route( 'admin.leagues.destroy', [ 'leagues' => $league->id ] ) }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <div class="form-group text-center">
                        	@lang('Do you want to delete the league :name?', [ 'name' => '<strong>' . $league->name . '</strong>' ])
                        </div>

						@component('admin.form.submit')
							@slot('cancel', route( 'admin.leagues.index' ))
							
							@slot('context', 'danger')
							
							Delete league
						@endcomponent
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
