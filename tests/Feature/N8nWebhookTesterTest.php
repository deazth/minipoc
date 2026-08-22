<?php

use App\Livewire\N8nWebhookTester;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;

test('guests can view the n8n webhook tester page', function () {
    $this->get(route('n8n.webhook'))
        ->assertSuccessful()
        ->assertSee(__('Webhook URL'))
        ->assertSee(__('POST body (JSON)'));
});

test('landing page links to the n8n webhook tester', function () {
    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee(route('n8n.webhook'), false);
});

test('sending a webhook posts json and shows the response', function () {
    Http::preventStrayRequests();

    Http::fake([
        'https://n8n.example.com/webhook/test' => Http::response(['ok' => true, 'id' => 42], 200),
    ]);

    Livewire::test(N8nWebhookTester::class)
        ->set('webhookUrl', 'https://n8n.example.com/webhook/test')
        ->set('body', '{"message":"hello"}')
        ->call('send')
        ->assertHasNoErrors()
        ->assertSet('responseStatus', 200)
        ->assertSet('error', null)
        ->assertSee('42');

    Http::assertSent(function ($request): bool {
        return $request->url() === 'https://n8n.example.com/webhook/test'
            && $request['message'] === 'hello';
    });
});

test('invalid json body is rejected', function () {
    Http::preventStrayRequests();

    Livewire::test(N8nWebhookTester::class)
        ->set('webhookUrl', 'https://n8n.example.com/webhook/test')
        ->set('body', '{not-json')
        ->call('send')
        ->assertHasErrors(['body'])
        ->assertSet('responseStatus', null);
});

test('webhook url is required', function () {
    Http::preventStrayRequests();

    Livewire::test(N8nWebhookTester::class)
        ->set('webhookUrl', '')
        ->set('body', '{}')
        ->call('send')
        ->assertHasErrors(['webhookUrl']);
});

test('connection errors are shown without clearing inputs', function () {
    Http::preventStrayRequests();

    Http::fake([
        'https://n8n.example.com/webhook/down' => Http::failedConnection(),
    ]);

    Livewire::test(N8nWebhookTester::class)
        ->set('webhookUrl', 'https://n8n.example.com/webhook/down')
        ->set('body', '{"keep":"me"}')
        ->call('send')
        ->assertHasNoErrors()
        ->assertSet('webhookUrl', 'https://n8n.example.com/webhook/down')
        ->assertSet('body', '{"keep":"me"}')
        ->assertSet('responseStatus', null)
        ->assertSet('error', fn (?string $error): bool => filled($error));
});
