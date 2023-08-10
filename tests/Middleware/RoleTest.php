<?php

namespace Gatekeeper\Tests\Middleware;

use Mockery;
use Illuminate\Http\Request;
use Gatekeeper\Tests\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Kettasoft\Gatekeeper\Middleware\Role;

beforeEach(function () {
    $this->request = Mockery::mock(Request::class);
    $this->guard = Mockery::mock(Guard::class);
});

function assertObjectHasAttributeFallback($attributeName, $object)
{
    return test()->assertTrue(property_exists($object, $attributeName));
};

test('Handle is guest with mismatching role should abort 403', function () {
    $middleware = new Role($this->guard);

    Auth::shouldReceive('guard')->with('web')->andReturn($this->guard);
    $this->guard->shouldReceive('guest')->andReturn(true);
    App::shouldReceive('abort')
        ->with(403, 'User does not have any of the necessary access rights.')
        ->andReturn(403);

    $this->assertEquals(403, $middleware->handle($this->request, function () {
    }, 'admin|user'));
});

test('Handle is logged in with mismatch role should abort 403', function () {
    $user = Mockery::mock(User::class)->makePartial();
    $middleware = new Role($this->guard);

    $this->guard->shouldReceive('guest')->andReturn(false);
    Auth::shouldReceive('guard')->with(Mockery::anyOf('web', 'api'))->andReturn($this->guard);
    $this->guard->shouldReceive('user')->andReturn($user);
    $user->shouldReceive('hasRole')
        ->with(
            ['admin', 'user'],
            Mockery::anyOf(true, false)
        )
        ->andReturn(false);
    App::shouldReceive('abort')
        ->with(403, 'User does not have any of the necessary access rights.')
        ->andReturn(403);

    /*
    |------------------------------------------------------------
    | Assertion
    |------------------------------------------------------------
    */
    $this->assertEquals(403, $middleware->handle($this->request, function () {
    }, 'admin|user'));

    $this->assertEquals(403, $middleware->handle($this->request, function () {
    }, 'admin|user', 'guard:api'));

    $this->assertEquals(403, $middleware->handle($this->request, function () {
    }, 'admin|user', 'require_all'));

    $this->assertEquals(403, $middleware->handle($this->request, function () {
    }, 'admin|user', 'require_all|guard:api'));
});

test('Handle is logged in with matching role should not abort', function () {
    /*
    |------------------------------------------------------------
    | Set
    |------------------------------------------------------------
    */
    $user = Mockery::mock(User::class)->makePartial();
    $middleware = new Role($this->guard);

    /*
    |------------------------------------------------------------
    | Expectation
    |------------------------------------------------------------
    */
    $this->guard->shouldReceive('guest')->andReturn(false);
    Auth::shouldReceive('guard')->with(Mockery::anyOf('web', 'api'))->andReturn($this->guard);
    $this->guard->shouldReceive('user')->andReturn($user);
    $user->shouldReceive('hasRole')
        ->with(
            ['admin', 'user'],
            Mockery::anyOf(true, false)
        )
        ->andReturn(true);

    /*
    |------------------------------------------------------------
    | Assertion
    |------------------------------------------------------------
    */
    $this->assertNull($middleware->handle($this->request, function () {
    }, 'admin|user'));

    $this->assertNull($middleware->handle($this->request, function () {
    }, 'admin|user', 'guard:api'));

    $this->assertNull($middleware->handle($this->request, function () {
    }, 'admin|user', 'require_all'));

    $this->assertNull($middleware->handle($this->request, function () {
    }, 'admin|user', 'require_all|guard:api'));
});

test('Handle is logged in with matching role should redirect without Error', function () {
    /*
    |------------------------------------------------------------
    | Set
    |------------------------------------------------------------
    */
    Session::start();
    Config::set('gatekeeper.middleware.handling', 'redirect');
    $user = Mockery::mock(User::class)->makePartial();
    $middleware = new Role($this->guard);


    /*
    |------------------------------------------------------------
    | Expectation
    |------------------------------------------------------------
    */
    $this->guard->shouldReceive('guest')->andReturn(false);
    Auth::shouldReceive('guard')->with(Mockery::anyOf('web', 'api'))->andReturn($this->guard);
    $this->guard->shouldReceive('user')->andReturn($user);
    $user->shouldReceive('hasRole')
        ->with(
            ['admin', 'user'],
            Mockery::anyOf(true, false)
        )
        ->andReturn(false);
    /*
    |------------------------------------------------------------
    | Assertion
    |------------------------------------------------------------
    */
    assertObjectHasAttributeFallback('content', $middleware->handle($this->request, function () {
    }, 'admin|user'));
    $this->assertStringContainsString('/home', $middleware->handle($this->request, function () {
    }, 'admin|user')->getContent());

    assertObjectHasAttributeFallback('content', $middleware->handle($this->request, function () {
    }, 'admin|user', 'guard:api'));
    $this->assertStringContainsString('/home', $middleware->handle($this->request, function () {
    }, 'admin|user', 'guard:api')->getContent());

    assertObjectHasAttributeFallback('content', $middleware->handle($this->request, function () {
    }, 'admin|user', 'require_all'));

    $this->assertStringContainsString('/home', $middleware->handle($this->request, function () {
    }, 'admin|user', 'require_all')->getContent());

    assertObjectHasAttributeFallback('content', $middleware->handle($this->request, function () {
    }, 'admin|user', 'require_all|guard:api'));
    $this->assertStringContainsString('/home', $middleware->handle($this->request, function () {
    }, 'admin|user', 'require_all|guard:api')->getContent());

    assertObjectHasAttributeFallback('content', $middleware->handle($this->request, function () {
    }, 'admin|user', 'require_all|guard:api'));
    $this->assertStringContainsString('/home', $middleware->handle($this->request, function () {
    }, 'admin|user', 'require_all|guard:api')->getContent());

    $this->assertArrayNotHasKey('error', Session::all());
});

test('Handle is logged in with mismatch role should redirect with error', function () {
    /*
    |------------------------------------------------------------
    | Set
    |------------------------------------------------------------
    */
    Session::start();
    Config::set('gatekeeper.middleware.handling', 'redirect');
    Config::set('gatekeeper.middleware.handlers.redirect.message.content', 'The message was flashed');
    $user = Mockery::mock(User::class)->makePartial();
    $middleware = new Role($this->guard);


    /*
    |------------------------------------------------------------
    | Expectation
    |------------------------------------------------------------
    */
    $this->guard->shouldReceive('guest')->andReturn(false);
    Auth::shouldReceive('guard')->with(Mockery::anyOf('web', 'api'))->andReturn($this->guard);
    $this->guard->shouldReceive('user')->andReturn($user);
    $user->shouldReceive('hasRole')
        ->with(
            ['admin', 'user'],
            Mockery::anyOf(true, false)
        )
        ->andReturn(false);
    /*
    |------------------------------------------------------------
    | Assertion
    |------------------------------------------------------------
    */
    assertObjectHasAttributeFallback('content', $middleware->handle($this->request, function () {
    }, 'admin|user'));
    $this->assertStringContainsString('/home', $middleware->handle($this->request, function () {
    }, 'admin|user')->getContent());

    assertObjectHasAttributeFallback('content', $middleware->handle($this->request, function () {
    }, 'admin|user', 'guard:api'));
    $this->assertStringContainsString('/home', $middleware->handle($this->request, function () {
    }, 'admin|user', 'guard:api')->getContent());

    assertObjectHasAttributeFallback('content', $middleware->handle($this->request, function () {
    }, 'admin|user', 'require_all'));
    $this->assertStringContainsString('/home', $middleware->handle($this->request, function () {
    }, 'admin|user', 'require_all')->getContent());

    assertObjectHasAttributeFallback('content', $middleware->handle($this->request, function () {
    }, 'admin|user', 'require_all|guard:api'));

    $this->assertStringContainsString('/home', $middleware->handle($this->request, function () {
    }, 'admin|user', 'require_all|guard:api')->getContent());

    assertObjectHasAttributeFallback('content', $middleware->handle($this->request, function () {
    }, 'admin|user', 'require_all|guard:api'));
    $this->assertStringContainsString('/home', $middleware->handle($this->request, function () {
    }, 'admin|user', 'require_all|guard:api')->getContent());

    $this->assertArrayHasKey('error', Session::all());
    $this->assertStringContainsString('message', Session::get('error'));
});
