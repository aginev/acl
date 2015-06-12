## ACL For Laravel 5
Access control list implementation form Laravel 5. Gives you roles and permissions for build in Laravel 5 Auth.

## Features
- CRUD for roles
- CRUD fot permissions
- Route middleware for checking user permissions
- Artisan command for parsing and adding newly created ACL dependant modules
- Composer installable
- PSR4 autoloading
- PSR2 code formatting


## Requires
Build only for Laravel Framework only! The package required Glyph icons (http://glyphicons.com/).

```json
"require": {
	"php": ">=5.4.0",
	"illuminate/foundation": "5.0.*",
	"illuminate/contracts": "5.0.*",
	"illuminate/database": "5.0.*",
	"illuminate/routing": "5.0.*",
	"illuminate/support": "5.0.*",
	"illuminate/view": "5.0.*",
	"illuminate/html": "5.*"
}
```

## Installation
Require package at your composer.json file like so
```json
{
    "require": {
        "fos/acl": "1.0.*"
    }
}
```

Because this is a private repository you need to add it at composer.json as well. Note that composer update will ask you for your password.
```json
"repositories": [
	{
		"type": "vcs",
		"url":  "git@git.1dxr.com:laravel-5-packages/acl.git"
	}
]
```

Tell composer to update your dependencies
```sh
composer update
```

Add Service Provider to your config/app.php like so
```php
'Fos\Acl\AclServiceProvider',
```

Publish package assets
```sh
php artisan vendor:publish --provider="Fos\Acl\AclServiceProvider" --tag="public"
```

Add package CSS to your layout
```blade
<link href="{{ asset('/vendor/acl/css/style.css') }}" rel="stylesheet">
```

Add package javascript to your layout.
- script.js to be able to define role permission easily
- restful.js to be able to execute RESTful delete

Feel free to make your own implementation if you don't have one already.
```blade
<script src="{{ asset('/vendor/acl/js/script.js') }}"></script>
<script src="{{ asset('/vendor/acl/js/restful.js') }}"></script>
```

Add Laravel csrf token as a javascript object. Required only if use restful.js.
```blade
<script>
	Laravel = {
		_token: '{{ csrf_token() }}'
	};
</script>
```

Run package migrations. You need to have your users table migrated.
```sh
php artisan migrate --path="vendor/fos/acl/src/Database/Migrations"
```

Seed the roles table. By default it will create two roles- No Permissions and Admin. No Permissions roles will be 
considered as a default role. You will be not able to delete this role. When deleting other role, all users using deleted
role will be assigned to No Permissions role. By default the seeder will add all resources requesting ACL and will 
assign them to Admin role.
```sh
php artisan db:seed --class="Fos\Acl\Database\Seeds\RolesTableSeeder"
```

Modify one or more of your users to have a valid role_id. By default the added role_id foreign key will have a value of NULL

Add ACL user trait to your User model. It will add definition for the relation between roles and users table;
```php
use \Fos\Acl\Http\Traits\User;
```

At this point you have ACL up and running. Access roles and permissions CRUD at:

/admin/role

/admin/permission

Not happy with the route prefix? Publish the package config and edit routes_prefix value for your own or leave it blank for no prefix.
```sh
php artisan vendor:publish --provider="Fos\Acl\AclServiceProvider" --tag="config"
```

Edit route prefix
```php
...
// Package route prefix. Set to blank for no prefix
'routes_prefix' => 'what-ever-you-want',
...
```

Package has a pagination in index views. If you need more items per page, edit per_page_results (default to 25) value at the config.
```php
...
// Pagination per page results
'per_page_results' => 50,
...
```

To define custom error messages format, edit validation_errors_format value at the config. This format will be applied 
only if your controllers are extending ACL base controller (\Fos\Acl\Http\Controllers\AclController). 
```php
// validation errors format. Set to blank for default
'validation_errors_format' => '<label class="error text-danger">:message</label>',
```

And the most important thing... you want your controller to be ACL dependent. There two options for this.

1.Add ACL middleware at your controller constructor.
```php
$this->middleware('acl');
```

2.Route group at routes.php
```php
Route::group(['middleware' => 'acl'], function () {
	Route::get('group', 'SomeController@index');
});
```

After defining a ACL protected controllers like this you are able to run artisan command that will add all the routes in the 
permissions table
```sh
php artisan acl:fill-permissions
```

If you want to assign new permissions to role you can do it like so
```sh
php artisan acl:fill-permissions --assign-to-roles=2
```

Where 2 is the role_id. If you want pass many roles do it with comma separates list
If you want to assign new permissions to role you can do it like so
```sh
php artisan acl:fill-permissions --assign-to-roles=1,2
```

### Modifying default view

To modify default views you need to publish them
```sh
php artisan vendor:publish --provider="Fos\Acl\AclServiceProvider" --tag="views"
```

### Other

Publish migrations
```sh
php artisan vendor:publish --provider="Fos\Acl\AclServiceProvider" --tag="migrations"
```

Publish seeds
```sh
php artisan vendor:publish --provider="Fos\Acl\AclServiceProvider" --tag="seeds"
```

## License
DBAD - http://www.dbad-license.org/