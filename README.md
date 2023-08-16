# Gatekeeper
This package provides a comprehensive system for managing roles and permissions in Laravel applications. It allows for easy creation and management of roles, assigning permissions to specific roles, and controlling access to different parts of the application based on a user's assigned roles and permissions.

[![Total Downloads](https://img.shields.io/packagist/dt/kettasoft/gatekeeper?style=for-the-badge)](https://packagist.org/packages/kettasoft/gatekeeper)
[![Latest Stable Version](http://poser.pugx.org/kettasoft/gatekeeper/v?style=for-the-badge)](https://packagist.org/packages/kettasoft/gatekeeper)
[![License](http://poser.pugx.org/kettasoft/gatekeeper/license?style=for-the-badge)](https://packagist.org/packages/kettasoft/gatekeeper)
[![PHP Version Require](http://poser.pugx.org/kettasoft/gatekeeper/require/php?style=for-the-badge)](https://packagist.org/packages/kettasoft/gatekeeper)

## Installation

### You can install the package using composer:

```bash
composer require kettasoft/gatekeeper
```

In Laravel 5.5 the service provider will automatically get registered. In older versions of the framework, you must install the service provider:

```php
// config/app.php
'providers' => [
    ...
    Kettasoft\Gatekeeper\Providers\GatekeeperServiceProvider::class,
];
```

### publish the config/gatekeeper.php config
```bash
php artisan vendor:publish --provider="Kettasoft\Gatekeeper\Providers\GatekeeperServiceProvider" --tag="config"
```
### WARNING
If this command did not publish any files, chances are, the Laratrust service provider hasn't been registered. Try clearing your configuration cache
```bash
php artisan config:clear
```

### Run the setup command:

IMPORTANT: Before running the command go to your config/gatekeeper.php file and change the values according to your needs.
```bash
php artisan gatekeeper:init
```
### This command will generate the migrations, create the Role and Permission models

```php
use Kettasoft\Gatekeeper\Contracts\GatekeeperInterface;
use Kettasoft\Gatekeeper\Traits\Gatekeeper;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements GatekeeperInterface
{
    use Gatekeeper;

    // ...
}
```

### Dump the autoloader:
```bash
composer dump-autoload
```

### Run the migrations:
```bash
php artisan migrate
```

## Roles & Permissions

### Setting things up
Let's start by creating the following Roles:
```php
$owner = Role::create([
    'name' => 'owner',
    'display_name' => 'Project Owner', // optional
    'description' => 'User is the owner of a given project', // optional
]);

$admin = Role::create([
    'name' => 'admin',
    'display_name' => 'User Administrator', // optional
    'description' => 'User is allowed to manage and edit other users', // optional
]);
```
Role Assignment & Removal:
```php
$user->addRole($admin); // parameter can be a Role object, array, id or the role string name
// equivalent to $user->roles()->attach([$admin->id]);

$user->addRoles([$admin, $owner]); // parameter can be a Role object, array, id or the role string name
// equivalent to $user->roles()->attach([$admin->id, $owner->id]);

$user->syncRoles([$admin->id, $owner->id]);
// equivalent to $user->roles()->sync([$admin->id, $owner->id]);

$user->syncRolesWithoutDetaching([$admin->id, $owner->id]);
// equivalent to $user->roles()->syncWithoutDetaching([$admin->id, $owner->id]);
```

### Removal
```php
$user->removeRole($admin); // parameter can be a Role object, array, id or the role string name
// equivalent to $user->roles()->detach([$admin->id]);

$user->removeRoles([$admin, $owner]); // parameter can be a Role object, array, id or the role string name
// equivalent to $user->roles()->detach([$admin->id, $owner->id]);
```
### User Permissions Assignment & Removal
You can give single permissions to a user, so in order to do it you only have to make:

## Assignment
```php
$user->givePermission(['admin-create', 'admin-delete']); // parameter can be a Permission object, array, id or the permission string name

$user->syncPermissions([$editUser->id, $createPost->id]);
// equivalent to $user->permissions()->sync([$editUser->id, createPost->id]);

$user->syncPermissionsWithoutDetaching([$editUser, $createPost]); // parameter can be a Permission object, array or id
    // equivalent to $user->permissions()->syncWithoutDetaching([$createPost->id, $editUser->id]);
```
