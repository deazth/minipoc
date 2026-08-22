<div class="space-y-6">
    <flux:callout icon="information-circle" variant="secondary">
        {{ __('Enter an n8n webhook URL and a JSON body, then submit. Inputs stay on the page after each request.') }}
    </flux:callout>

    <form wire:submit="send" class="space-y-4">
        <flux:field>
            <flux:label>{{ __('Webhook URL') }}</flux:label>
            <flux:input
                wire:model="webhookUrl"
                type="url"
                placeholder="https://n8n.example.com/webhook/..."
                autofocus
            />
            <flux:error name="webhookUrl" />
        </flux:field>

        <flux:field>
            <flux:label>{{ __('POST body (JSON)') }}</flux:label>
            <flux:textarea wire:model="body" rows="10" class="font-mono text-sm" />
            <flux:error name="body" />
        </flux:field>

        <flux:button type="submit" variant="primary" icon="paper-airplane" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="send">{{ __('Send request') }}</span>
            <span wire:loading wire:target="send">{{ __('Sending…') }}</span>
        </flux:button>
    </form>

    @if ($error)
        <flux:card class="space-y-2">
            <flux:heading size="sm">{{ __('Error') }}</flux:heading>
            <flux:text class="text-red-600 dark:text-red-400">{{ $error }}</flux:text>
        </flux:card>
    @elseif (! is_null($responseStatus))
        <flux:card class="space-y-3">
            <div class="flex flex-wrap items-center justify-between gap-2">
                <flux:heading size="sm">{{ __('Response') }}</flux:heading>
                <flux:badge :color="$responseStatus >= 200 && $responseStatus < 300 ? 'green' : 'red'">
                    {{ __('HTTP :status', ['status' => $responseStatus]) }}
                </flux:badge>
            </div>

            <pre class="overflow-x-auto rounded-lg bg-zinc-100 p-4 text-sm break-words whitespace-pre-wrap dark:bg-zinc-800">{{ $responseBody }}</pre>
        </flux:card>
    @endif
</div>
