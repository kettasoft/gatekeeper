<?php

use Illuminate\Http\Request;
use Gatekeeper\Tests\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Kettasoft\Gatekeeper\Middleware\Permission;

beforeEach(function () {
    $this->request = \Mockery::mock(Request::class);
    $this->guard = \Mockery::mock(Guard::class);
});

test('handle is guest with no permission should abort 403', function () {
    Auth::shouldReceive('guard')->with('web')->andReturn($this->guard);
    $this->guard->shouldReceive('guest')->andReturn(true);
    App::shouldReceive('abort')->with(403, 'User does not have any of the necessary access rights.')->andReturn(403);

    $middleware = new Permission;

    $result = $middleware->handle($this->request, function () {
    }, 'admin|editor|author|contributor|subscriber');

    expect($result)->toBe(403);
});

test('handle is logged in with no permission should abort 403', function () {
    $user = \Mockery::mock(User::class)->makePartial();
    $middleware = new Permission($this->guard);

    Auth::shouldReceive('guard')->with(\Mockery::anyOf('web', 'api'))->andReturn($this->guard);
    $this->guard->shouldReceive('guest')->andReturn(false);
    $this->guard->shouldReceive('user')->andReturn($user);
    $user->shouldReceive('hasPermission')->with(
        ['users-create', 'users-update'],
        \Mockery::anyOf(true, false)
    )->andReturn(false);
    App::shouldReceive('abort')->with(403, 'User does not have any of the necessary access rights.')->andReturn(403);

    /*
    |------------------------------------------------------------
    | Assertion
    |------------------------------------------------------------
    */
    $this->assertEquals(403, $middleware->handle($this->request, fn () => null, 'admin|editor|author|contributor|subscriber'));

    $this->assertEquals(403, $middleware->handle($this->request, fn () => null, 'users-create|users-update', 'guard:api'));

    $this->assertEquals(403, $middleware->handle($this->request, fn () => null, 'users-create|users-update', 'require_all'));

    $this->assertEquals(403, $middleware->handle($this->request, fn () => null, 'users-create|users-update', 'guard:api|require_all'));

    $this->assertEquals(403, $middleware->handle($this->request, fn () => null, 'users-create|users-update', 'require_all'));

    $this->assertEquals(403, $middleware->handle($this->request, fn () => null, 'users-create|users-update', 'guard:api|require_all'));
});

test('handle is logged in with permission should not abort.', function () {
    $user = Mockery::mock(User::class)->makePartial();
    $middleware = new Permission($this->guard);

    Auth::shouldReceive('guard')->with(Mockery::anyOf('web', 'api'))->andReturn($this->guard);
    $this->guard->shouldReceive('guest')->andReturn(false);
    $this->guard->shouldReceive('user')->andReturn($user);
    $user->shouldReceive('hasPermission')
        ->with(
            ['users-create', 'users-update'],
            Mockery::anyOf(true, false)
        )
        ->andReturn(true);

    /*
    |------------------------------------------------------------
    | Assertion
    |------------------------------------------------------------
    */
    $this->assertNull($middleware->handle($this->request, function () {
    }, 'users-create|users-update'));

    $this->assertNull($middleware->handle($this->request, function () {
    }, 'users-create|users-update', 'guard:api'));

    $this->assertNull($middleware->handle($this->request, function () {
    }, 'users-create|users-update', 'require_all'));

    $this->assertNull($middleware->handle($this->request, function () {
    }, 'users-create|users-update', 'guard:api|require_all'));

    $this->assertNull($middleware->handle($this->request, function () {
    }, 'users-create|users-update', 'require_all'));

    $this->assertNull($middleware->handle($this->request, function () {
    }, 'users-create|users-update', 'guard:api|require_all'));
});

test('Handle is logged in with no permission should redirect with error.', function () {
    Session::start();
    Config::set('gatekeeper.middleware.handling', 'redirect');
    Config::set('gatekeeper.middleware.handlers.redirect.message.content', 'The message was flashed');
    $user = Mockery::mock(User::class)->makePartial();
    $middleware = new Permission($this->guard);

    Auth::shouldReceive('guard')->with(Mockery::anyOf('web', 'api'))->andReturn($this->guard);
    $this->guard->shouldReceive('guest')->andReturn(false);
    $this->guard->shouldReceive('user')->andReturn($user);
    $user->shouldReceive('hasPermission')
        ->with(
            ['users-create', 'users-update'],
            Mockery::anyOf(true, false)
        )
        ->andReturn(false);

    /*
    |------------------------------------------------------------
    | Assertion
    |------------------------------------------------------------
    */
    $this->assertStringContainsString('/home', $middleware->handle($this->request, function () {
    }, 'users-create|users-update')->getContent());

    $this->assertStringContainsString('/home', $middleware->handle($this->request, function () {
    }, 'users-create|users-update', 'guard:api')->getContent());

    $this->assertStringContainsString('/home', $middleware->handle($this->request, function () {
    }, 'users-create|users-update', 'require_all')->getContent());

    $this->assertStringContainsString('/home', $middleware->handle($this->request, function () {
    }, 'users-create|users-update', 'guard:api|require_all')->getContent());

    $this->assertArrayHasKey('error', Session::all());
    $this->assertStringContainsString('message', Session::get('error'));
});

test('Handle is logged in with no permission should without error', function () {
    Session::start();
    $user = Mockery::mock(User::class)->makePartial();
    $middleware = new Permission($this->guard);
    Config::set('gatekeeper.middleware.handling', 'redirect');

    Auth::shouldReceive('guard')->with(Mockery::anyOf('web', 'api'))->andReturn($this->guard);
    $this->guard->shouldReceive('guest')->andReturn(false);
    $this->guard->shouldReceive('user')->andReturn($user);
    $user->shouldReceive('hasPermission')
        ->with(
            ['users-create', 'users-update'],
            Mockery::anyOf(true, false)
        )
        ->andReturn(false);

    /*
    |------------------------------------------------------------
    | Assertion
    |------------------------------------------------------------
    */
    $this->assertStringContainsString('/home', $middleware->handle($this->request, function () {
    }, 'users-create|users-update')->getContent());

    $this->assertStringContainsString('/home', $middleware->handle($this->request, function () {
    }, 'users-create|users-update', 'guard:api')->getContent());

    $this->assertStringContainsString('/home', $middleware->handle($this->request, function () {
    }, 'users-create|users-update', 'require_all')->getContent());

    $this->assertStringContainsString('/home', $middleware->handle($this->request, function () {
    }, 'users-create|users-update', 'guard:api|require_all')->getContent());

    $this->assertArrayNotHasKey('error', Session::all());
});
