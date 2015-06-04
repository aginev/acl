@extends('app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default fos-acl">
					<div class="panel-heading position-relative">{!! trans('acl::role.edit.update_role'); !!}
						<a href="{{ url('role') }}" class="btn btn-danger btn-sm btn-absolute-right">
							<span class="glyphicon glyphicon-arrow-left"></span> {!! trans('acl::role.edit.back'); !!}
						</a>
					</div>
					<div class="panel-body">

						{!! Form::open(['action' => ['\Fos\Acl\Http\Controllers\RoleController@update', $role->id], 'method' => 'PATCH', 'id' => 'role-form']) !!}

						<div class="form-group">
							<label for="role_title">{!! trans('acl::role.edit.role'); !!}</label>
							{!! Form::text('role_title', $role->role_title, ['class' => 'form-control required', 'id' => 'role_title', 'placeholder' => trans('acl::role.edit.role_placeholder')]) !!}
							{!! $errors->first('role_title') !!}
						</div>

						<div class="form-group">
							<label for="role_description">{!! trans('acl::role.edit.role_description'); !!}</label>
							{!! Form::text('role_description', $role->role_description, ['class' => 'form-control', 'id' => 'role_description', 'placeholder' => trans('acl::role.edit.role_description_placeholder')]) !!}
							{!! $errors->first('role_description') !!}
						</div>

						<button type="submit" class="btn btn-success">{!! trans('acl::role.edit.update'); !!}</button>

						{!! Form::close() !!}

					</div>
				</div>
			</div>
		</div>
	</div>
@endsection