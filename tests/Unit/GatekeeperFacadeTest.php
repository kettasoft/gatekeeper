<?php

use Kettasoft\Gatekeeper\Gatekeeper;

beforeEach(function () {
    $this->gatekeeper = Mockery::mock(Gatekeeper::class)
        ->makePartial()
        ->shouldAllowMockingProtectedMethods();
    $this->user = Mockery::mock(User::class);
});

it('can create a gatekeeper instance', function () {
    $this->assertInstanceOf(Gatekeeper::class, $this->gatekeeper);
});

test('Check permission', function (): void {
    $this->gatekeeper->shouldReceive('user')->andReturn($this->user)->twice()->ordered();
    $this->gatekeeper->shouldReceive('user')->andReturn(null)->once()->ordered();
    $this->user->shouldReceive('hasPermission')->with(['user_can'], false)->andReturn(true)->once();
    $this->user->shouldReceive('hasPermission')->with(['user_cannot'], false)->andReturn(false)->once();

    $this->assertTrue($this->gatekeeper->hasPermission(['user_can']));
    $this->assertFalse($this->gatekeeper->hasPermission(['user_cannot']));
    $this->assertFalse($this->gatekeeper->hasPermission(['any_permission']));
});