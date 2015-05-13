@extends('app')

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading position-relative">Create New Role
					<a href="{{ url('role') }}" class="btn btn-danger btn-sm btn-absolute-right"><span class="glyphicon glyphicon-arrow-left"></span> Back</a>
				</div>
				<div class="panel-body">

					{!! Form::open(['action' => '\Fos\Acl\Http\Controllers\RoleController@store', 'method' => 'POST', 'id' => 'role-form']) !!}

					<div class="form-group">
						<label for="role_title">Role</label>
						{!! Form::text('role_title', old('role_title'), ['class' => 'form-control required', 'id' => 'role_title', 'placeholder' => 'Role Title']) !!}
						{!! $errors->first('role_title') !!}
					</div>

					<div class="form-group">
						<label for="role_description">Role Description</label>
						{!! Form::text('role_description', old('role_description'), ['class' => 'form-control', 'id' => 'role_description', 'placeholder' => 'Role Description']) !!}
						{!! $errors->first('role_description') !!}
					</div>

					<div class="form-group">
						<label>Role Permissions</label>
						<ul class="list-unstyled nasted-list-grid clearfix">
						@forelse ($permissions as $controller => $methods)
							<li>
								<label><input type="checkbox" name="controller[]" value="{{ $controller }}" class="check-all" /> {!! $controller !!}</label>

								<ul class="list-unstyled">
									@foreach ($methods as $method)
										<li><label><input type="checkbox" name="permission_id[{{ $method->id }}]" value="{{ $method->id }}" /> {!! $method->method !!}</label></li>
									@endforeach
								</ul>
							</li>
						@empty
							<p class="text-danger">No permissions found.</p>
						@endforelse
						</ul>
					</div>

					<div class="clearfix"></div>
					
					<button type="submit" class="btn btn-success">Create</button>

					{!! Form::close() !!}

				</div>
			</div>
		</div>
	</div>
</div>
@endsection