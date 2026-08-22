<?php

test('returns a successful response', function () {
    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertSee(config('app.name'), false)
        ->assertSee(route('echo.send'), false)
        ->assertSee(route('echo.receive'), false)
        ->assertSee(__('Echo Send'), false)
        ->assertSee(__('Echo Receive'), false);
});
