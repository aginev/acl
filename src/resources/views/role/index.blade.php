@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading position-relative">Roles
					<a href="{{ url('role/create') }}" class="btn btn-success btn-sm btn-absolute-right"><span class="glyphicon glyphicon-plus"></span> Add New Role</a>
				</div>
				<div class="panel-body">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>Role</th>
								<th>Description</th>
								<th style="width: 105px;">Action</th>
							</tr>
						</thead>
						<tbody>
							@forelse($roles as $role)
								<tr>
									<td>{{ $role->role_title }}</td>
									<td>{{ $role->role_description }}</td>
									<td>
										<a href="{{ action('\Fos\Acl\Http\Controllers\RoleController@edit', $role->id) }}">Edit</a>
										@if ($role->id != 1)
										 / <a href="{{ action('\Fos\Acl\Http\Controllers\RoleController@destroy', $role->id) }}" data-method="DELETE" data-confirm="Are you sure that you want to delete this role?" class="text-danger">Delete</a>
										@endif
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="3">No roles.</td>
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