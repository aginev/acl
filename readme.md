1. Add the service provider 'Fos\Acl\AclServiceProvider',
2. Publish assets php artisan vendor:publish --provider="Fos\Acl\AclServiceProvider" --tag="public"
3. Migrate the database php artisan migrate --path="vendor/fos/acl/src/Database/Migrations"
4. Seed the roles php artisan db:seed --class="Fos\Acl\Database\Seeds\RolesTableSeeder"
5. Update user and set his role
6. Add use \Fos\Acl\Http\Traits\User; at User model
7. Add assets in layout
	<link href="{{ asset('/vendor/acl/css/style.css') }}" rel="stylesheet">

	<script src="{{ asset('/vendor/acl/js/script.js') }}"></script>
	<script src="{{ asset('/vendor/acl/js/restful.js') }}"></script>
8.
9.


















# ACL For Laravel 5
Package that easily converts collection of models to a datagrid table.

## Features
- Composer installable
- PSR4 autoloading
- Has filters row
- Has columns sort order
- Easily can add action column with edit/delete/whatever links
- Ability to modify cell data via closure function
- Bootstrap friendly
- Columns has data attributes based on a column data key

## Requires
Build only for Laravel Framework 5 only!

```json
"require": {
	"php": ">=5.4.0",
	"illuminate/support": "5.0.*",
	"illuminate/contracts": "5.0.*",
	"illuminate/view": "5.0.*",
	"illuminate/html": "5.*"
}
```

## Installation
Require package at your composer.json file like so
```json
{
    "require": {
        "fos/datagrid": "1.0.*"
    }
}
```

Because this is a private repository you need to add it at composer.json aswell. Note that composer update will ask you for your password.
```json
"repositories": [
	{
		"type": "vcs",
		"url":  "git@git.1dxr.com:laravel-5-packages/datagrid.git"
	}
]
```

Tell composer to update your dependencies
```sh
composer update
```

Add Service Provider to your config/app.php like so
```php
'Fos\Datagrid\DatagridServiceProvider',
```

Optionaly you could add package alias, if not it will be loaded automatically
```php
'Datagrid' 	=> 'Fos\Datagrid\Datagrid',
```

## HOWTO
Let's consider that we have users and user roles (roles) table at our system.

### Users table consists of:

**id:** primary key

**role_id:** foreign key to roles table primary key

**email:** user email added used as username

**first_name:** user first name

**last_name:** user last name

**password:** hashed password

**created_at:** when it's created

**updated_at:** when is the latest update

### Roles table consists of:

**id:** primary key

**title:** Role title e.g. Administrators Access

**created_at:** when it's created

**updated_at:** when is the latest update

We need a table with all the users data, their roles, edit and delete links at the last column at the table, filters and sort links at the very top, pagination at the very bottom.

```php
<?php

// Grap all the users with their roles
$users = User::with('role')->paginate(25);

// Create Datagrid instance
// You need to pass the users and the URL query params that the package is using
$grid = new \Datagrid($users, Request::get('f', []));

// Or if you do not want to use the alias
//$grid = new \Fos\Datagrid\Datagrid($users, Request::get('f', []));

// Then we are starting to define columns
$grid
	->setColumn('first_name', 'First Name', [
		// Will be sortable column
		'sortable'    => true,
		// Will have filter
		'has_filters' => true
	])
	->setColumn('email', 'Email', [
		'sortable'    => true,
		'has_filters' => true,
		// Wrapper closure will accept two params
		// $value is the actual cell value
		// $row are the all values for this row
		'wrapper'     => function ($value, $row) {
			return '<a href="mailto:' . $value . '">' . $value . '</a>';
		}
	])
	->setColumn('role_id', 'Role', [
		// If you want to have role_id in the URL query string but you need to show role.name as value (dot notation for the user/role relation)
		'refers_to'   => 'role.name',
		'sortable'    => true,
		'has_filters' => true,
		// Pass array of data to the filter. It will generate select field.
		'filters'     => Role::all()->lists('title', 'id'),
	])
	->setColumn('created_at', 'Created', [
		'sortable'    => true,
		'has_filters' => true,
		'wrapper'     => function ($value, $row) {
			// The value here is still Carbon instance, so you can format it using the Carbon methods
			return $value;
		}
	])
	->setColumn('updated_at', 'Updated', [
		'sortable'    => true,
		'has_filters' => true
	])
	// Setup action column
	->setActionColumn([
		'wrapper' => function ($value, $row) {
			return '<a href="' . action('HomeController@index', $row->id) . '" title="Edit" class="btn btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
					<a href="' . action('HomeController@index', $row->id) . '" title="Delete" data-method="DELETE" class="btn btn-xs text-danger" data-confirm="Are you sure?"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>';
		}
	]);

// Finally pass the grid object to the view
return view('grid', ['grid' => $grid]);
```

Lets show the grid in the view. grid-table param is not required and it's the id of the table.
```blade
...
{!! $grid->show('grid-table') !!}
...
```

### Modifying default view

The most stupid thing is to go at vendor/fos/datagrid/src/Views and to edit grid.blade.php. Doing so after a package update all your changes will be overwrited!

Much better way is to publish the view to your project like so:

```sh
php artisan vendor:publish
```

This will copy the view to resources/views/vendor/datagrid/datagrid.blade.php. Editing this file you will be able to modify the grid view as you like with no chance to loose your changes.

## License
DBAD - http://www.dbad-license.org/