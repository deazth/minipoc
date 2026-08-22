<?php

namespace App\Livewire;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Title;
use Livewire\Component;
use Throwable;

#[Title('n8n Webhook')]
class N8nWebhookTester extends Component
{
    public string $webhookUrl = '';

    public string $body = "{\n    \"message\": \"hello from minipoc\"\n}";

    public ?int $responseStatus = null;

    public ?string $responseBody = null;

    public ?string $error = null;

    public function send(): void
    {
        $this->reset(['responseStatus', 'responseBody', 'error']);

        $validated = $this->validate([
            'webhookUrl' => ['required', 'url', 'max:2048'],
            'body' => ['required', 'string', 'max:65535'],
        ]);

        $payload = json_decode($validated['body'], true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->addError('body', __('Body must be valid JSON.'));

            return;
        }

        try {
            $response = Http::timeout(15)
                ->connectTimeout(5)
                ->acceptJson()
                ->asJson()
                ->post($validated['webhookUrl'], $payload);

            $this->responseStatus = $response->status();
            $this->responseBody = $this->formatResponseBody($response->body());
        } catch (ConnectionException $exception) {
            $this->error = __('Could not connect to the webhook URL: :message', [
                'message' => $exception->getMessage(),
            ]);
        } catch (Throwable $exception) {
            $this->error = __('Unexpected error: :message', [
                'message' => $exception->getMessage(),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.n8n-webhook-tester')
            ->layout('components.layouts.tool', [
                'title' => __('n8n Webhook'),
                'subtitle' => __('POST a payload to an n8n webhook and inspect the response'),
            ]);
    }

    private function formatResponseBody(string $body): string
    {
        if ($body === '') {
            return __('(empty response body)');
        }

        $decoded = json_decode($body, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            return json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?: $body;
        }

        return $body;
    }
}
