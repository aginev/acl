@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">

			@include('acl::alert')

			<div class="panel panel-default fos-acl">
				<div class="panel-heading position-relative">{!! trans('acl::permission.create.create_new_permission'); !!}
					<a href="{{ action('\Aginev\Acl\Http\Controllers\PermissionController@index') }}" class="btn btn-danger btn-sm btn-absolute-right"><span class="glyphicon glyphicon-arrow-left"></span> {!! trans('acl::permission.create.back'); !!}</a>
				</div>
				<div class="panel-body">

					{!! Form::open(['action' => '\Aginev\Acl\Http\Controllers\PermissionController@store', 'method' => 'POST', 'id' => 'role-form']) !!}

					<div class="form-group">
						<label for="controller">{!! trans('acl::permission.create.controller'); !!}</label>
						{!! Form::text('controller', old('controller'), ['class' => 'form-control required', 'id' => 'controller', 'placeholder' => trans('acl::permission.create.controller_placeholder')]) !!}
						{!! $errors->first('controller') !!}
					</div>

					<div class="form-group">
						<label for="method">{!! trans('acl::permission.create.method'); !!}</label>
						{!! Form::text('method', old('method'), ['class' => 'form-control required', 'id' => 'method', 'placeholder' => trans('acl::permission.create.method_placeholder')]) !!}
						{!! $errors->first('method') !!}
					</div>

					<div class="form-group">
						<label for="description">{!! trans('acl::permission.create.description'); !!}</label>
						{!! Form::text('description', old('description'), ['class' => 'form-control', 'id' => 'description', 'placeholder' => trans('acl::permission.create.description_placeholder')]) !!}
						{!! $errors->first('description') !!}
					</div>
					
					<button type="submit" class="btn btn-success">{!! trans('acl::permission.create.create'); !!}</button>

					{!! Form::close() !!}

				</div>
			</div>
		</div>
	</div>
</div>
@endsection