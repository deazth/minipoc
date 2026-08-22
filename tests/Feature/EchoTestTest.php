<?php

use App\Events\EchoTestMessage;
use Illuminate\Support\Facades\Event;

test('guests can view the echo send page', function () {
    $this->get(route('echo.send'))
        ->assertSuccessful()
        ->assertSee(__('Broadcast'));
});

test('guests can view the echo receive page', function () {
    $this->get(route('echo.receive'))
        ->assertSuccessful()
        ->assertSee(__('Receive'));
});

test('broadcasting a message dispatches the echo test event', function () {
    Event::fake([EchoTestMessage::class]);

    $this->from(route('echo.send'))
        ->post(route('echo.broadcast'), ['message' => 'Hello Reverb'])
        ->assertRedirect(route('echo.send'))
        ->assertSessionHas('status');

    Event::assertDispatched(EchoTestMessage::class, function (EchoTestMessage $event): bool {
        return $event->message === 'Hello Reverb'
            && $event->broadcastAs() === 'message.sent'
            && $event->broadcastWith() === ['message' => 'Hello Reverb'];
    });
});

test('broadcasting requires a message', function () {
    $this->from(route('echo.send'))
        ->post(route('echo.broadcast'), ['message' => ''])
        ->assertRedirect(route('echo.send'))
        ->assertSessionHasErrors('message');
});
