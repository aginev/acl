@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading position-relative">Permissions
					<a href="{{ url('permission/create') }}" class="btn btn-success btn-sm btn-absolute-right"><span class="glyphicon glyphicon-plus"></span> Add New Permission</a>
				</div>
				<div class="panel-body">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>Controller@method</th>
								<th>Description</th>
								<th style="width: 105px;">Action</th>
							</tr>
						</thead>
						<tbody>
							@forelse($permissions as $permission)
								<tr>
									<td>{{ $permission->controller . '@' . $permission->method }}</td>
									<td>{{ $permission->description }}</td>
									<td>
										<a href="{{ action('\Fos\Acl\Http\Controllers\PermissionController@edit', $permission->id) }}">Edit</a> /
										<a href="{{ action('\Fos\Acl\Http\Controllers\PermissionController@destroy', $permission->id) }}" data-method="DELETE" data-confirm="Are you sure that you want to delete this permission?" class="text-danger">Delete</a>
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="3">No permissions.</td>
								</tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection