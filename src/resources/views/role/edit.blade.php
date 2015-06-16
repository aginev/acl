@extends('app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">

				@include('acl::alert')

				<div class="panel panel-default fos-acl">
					<div class="panel-heading position-relative">{!! trans('acl::role.edit.update_role'); !!}
						<a href="{{ action('\Aginev\Acl\Http\Controllers\RoleController@index') }}" class="btn btn-danger btn-sm btn-absolute-right">
							<span class="glyphicon glyphicon-arrow-left"></span> {!! trans('acl::role.edit.back'); !!}
						</a>
					</div>
					<div class="panel-body">

						{!! Form::open(['action' => ['\Aginev\Acl\Http\Controllers\RoleController@update', $role->id], 'method' => 'PATCH', 'id' => 'role-form']) !!}

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

						<div class="form-group">
							<label>{!! trans('acl::role.create.role_permissions'); !!}</label>

							<div class="row role-permissions">
								@forelse ($permissions as $controller => $methods)
									<div class="col-md-4">
										<label class="controller"><input type="checkbox" name="controller[]" value="{{ $controller }}" class="check-all" data-id="{{ md5($controller) }}" /> {!! $controller !!}</label>

										<ul class="methods">
											@foreach ($methods as $method)
												<li class="method">
													<label>
														<input
															type="checkbox"
															name="permission_id[{{ $method->id }}]"
															value="{{ $method->id }}"
															data-controller="{{ md5($controller) }}"
															@if($role_permissions->has($method->id)) checked="checked" @endif
														/> {!! $method->method !!}
													</label>
												</li>
											@endforeach
										</ul>
									</div>
								@empty
									<p class="text-danger">{!! trans('acl::role.create.no_permissions_found'); !!}</p>
								@endforelse
							</div>
						</div>

						<button type="submit" class="btn btn-success">{!! trans('acl::role.edit.update'); !!}</button>

						{!! Form::close() !!}

					</div>
				</div>
			</div>
		</div>
	</div>
@endsection