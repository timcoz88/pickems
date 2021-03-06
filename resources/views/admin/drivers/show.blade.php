@extends('admin.index')

@section('title', __('Delete driver') . ' - ' . __('Admin') . ' -')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route( 'admin.drivers.destroy', [ 'drivers' => $driver->id ] ) }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <div class="form-group text-center">
                        	@lang('Do you want to delete the driver :name?', [ 'name' => '<strong>' . $driver->fullName . '</strong>' ])
                        </div>

						@component('admin.form.submit')
							@slot('cancel', route('admin.drivers.index'))
							
							@slot('context', 'danger')
							
							Delete driver
						@endcomponent
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
