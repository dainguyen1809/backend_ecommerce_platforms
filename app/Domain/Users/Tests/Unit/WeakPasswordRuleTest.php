<?php

use App\Domain\Users\Rules\WeakPasswordRule;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {

    Cache::forget('weak_password_list');
});

test('password not in weak list should pass', function () {
    $rule = new WeakPasswordRule();

    $result = $rule->passes('password', 'SuperStrong!123');

    expect($result)->toBeTrue();
});
