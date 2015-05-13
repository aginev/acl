@extends('app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading position-relative">Update Role
						<a href="{{ url('role') }}" class="btn btn-danger btn-sm btn-absolute-right"><span class="glyphicon glyphicon-arrow-left"></span> Back</a>
					</div>
					<div class="panel-body">

						{!! Form::open(['action' => ['\Fos\Acl\Http\Controllers\RoleController@update', $role->id], 'method' => 'PATCH', 'id' => 'role-form']) !!}

						<div class="form-group">
							<label for="role_title">Role</label>
							{!! Form::text('role_title', $role->role_title, ['class' => 'form-control required', 'id' => 'role_title', 'placeholder' => 'Role Title']) !!}
							{!! $errors->first('role_title') !!}
						</div>

						<div class="form-group">
							<label for="role_description">Role Description</label>
							{!! Form::text('role_description', $role->role_description, ['class' => 'form-control', 'id' => 'role_description', 'placeholder' => 'Role Description']) !!}
							{!! $errors->first('role_description') !!}
						</div>

						<button type="submit" class="btn btn-success">Update</button>

						{!! Form::close() !!}

					</div>
				</div>
			</div>
		</div>
	</div>
@endsection