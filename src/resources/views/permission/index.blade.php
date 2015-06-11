@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			@include('acl::alert')

			<div class="panel panel-default fos-acl">
				<div class="panel-heading position-relative">{!! trans('acl::permission.index.permissions'); !!}
					<a href="{{ action('\Fos\Acl\Http\Controllers\PermissionController@create') }}" class="btn btn-success btn-sm btn-absolute-right">
						<span class="glyphicon glyphicon-plus"></span> {!! trans('acl::permission.index.add_new_permission'); !!}
					</a>
				</div>
				<div class="panel-body">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th class="permission-controller">{!! trans('acl::permission.index.controller_method'); !!}</th>
								<th class="permission-description">{!! trans('acl::permission.index.description'); !!}</th>
								<th class="permission-action">{!! trans('acl::permission.index.action'); !!}</th>
							</tr>
						</thead>
						<tbody>
							@forelse($permissions as $permission)
								<tr>
									<td class="permission-controller">{{ $permission->controller . '@' . $permission->method }}</td>
									<td class="permission-description">{{ $permission->description }}</td>
									<td class="permission-action">
										<a href="{{ action('\Fos\Acl\Http\Controllers\PermissionController@edit', $permission->id) }}" title="{!! trans('acl::permission.index.edit'); !!}" class="btn btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
										<a href="{{ action('\Fos\Acl\Http\Controllers\PermissionController@destroy', $permission->id) }}" title="{!! trans('acl::permission.index.delete'); !!}" data-method="DELETE" class="btn btn-xs text-danger" data-confirm="{!! trans('acl::permission.index.delete_confirm'); !!}"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="3">{!! trans('acl::permission.index.no_permissions'); !!}</td>
								</tr>
							@endforelse
						</tbody>
					</table>

					<div class="text-center">
						<?php echo $permissions->render(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@include('acl::confirm')

@endsection