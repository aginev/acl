@extends('app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading position-relative">Update Permission
						<a href="{{ url('permission') }}" class="btn btn-danger btn-sm btn-absolute-right"><span class="glyphicon glyphicon-arrow-left"></span> Back</a>
					</div>
					<div class="panel-body">

						{!! Form::open(['action' => ['\Fos\Acl\Http\Controllers\PermissionController@update', $permission->id], 'method' => 'PATCH', 'id' => 'permission-form']) !!}

						<div class="form-group">
							<label for="controller">Controller</label>
							{!! Form::text('controller', $permission->controller, ['class' => 'form-control required', 'id' => 'controller', 'placeholder' => 'Controller']) !!}
							{!! $errors->first('controller') !!}
						</div>

						<div class="form-group">
							<label for="method">Method</label>
							{!! Form::text('method', $permission->method, ['class' => 'form-control required', 'id' => 'method', 'placeholder' => 'Method']) !!}
							{!! $errors->first('method') !!}
						</div>

						<div class="form-group">
							<label for="description">Description</label>
							{!! Form::text('description', $permission->description, ['class' => 'form-control', 'id' => 'description', 'placeholder' => 'Description']) !!}
							{!! $errors->first('description') !!}
						</div>

						<button type="submit" class="btn btn-success">Update</button>

						{!! Form::close() !!}

					</div>
				</div>
			</div>
		</div>
	</div>
@endsection