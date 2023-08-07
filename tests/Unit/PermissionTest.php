<?php

use Gatekeeper\Tests\Models\User;

beforeEach(function () {
    $this->user = User::create([
        'name' => 'John Doe',
        'email' => 'john@mail.com',
        'password' => 'password'
    ]);
});

test('Check if user has permission.', function () {
    $this->user->givePermission(['edit articles']);

    $this->assertTrue($this->user->hasPermission('edit articles'));
});