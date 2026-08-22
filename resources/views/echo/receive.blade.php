<x-layouts.echo :title="__('Receive')">
    <div
        class="space-y-6"
        x-data="{
            status: 'connecting',
            messages: [],
            init() {
                if (! window.Echo) {
                    this.status = 'missing-echo';
                    return;
                }

                window.Echo.channel('echo-test')
                    .listen('.message.sent', (event) => {
                        this.messages.unshift({
                            message: event.message,
                            receivedAt: new Date().toLocaleTimeString(),
                        });
                    });

                this.status = 'listening';
            },
        }"
    >
        <flux:callout icon="signal" variant="secondary">
            {{ __('Listening on public channel') }}
            <code class="ms-1 font-mono text-sm">echo-test</code>
            {{ __('for event') }}
            <code class="ms-1 font-mono text-sm">.message.sent</code>
        </flux:callout>

        <div class="flex items-center gap-2">
            <flux:badge x-show="status === 'connecting'" color="amber" size="sm">{{ __('Connecting…') }}</flux:badge>
            <flux:badge x-show="status === 'listening'" color="green" size="sm" x-cloak>{{ __('Listening') }}</flux:badge>
            <flux:badge x-show="status === 'missing-echo'" color="red" size="sm" x-cloak>{{ __('Echo JS not loaded') }}</flux:badge>
        </div>

        <div class="space-y-3">
            <flux:heading size="sm">{{ __('Received messages') }}</flux:heading>

            <template x-if="messages.length === 0">
                <flux:text>{{ __('Waiting for a broadcast…') }}</flux:text>
            </template>

            <ul class="space-y-2" x-show="messages.length > 0" x-cloak>
                <template x-for="(item, index) in messages" :key="index">
                    <li class="rounded-lg border border-zinc-200 bg-white px-4 py-3 dark:border-zinc-700 dark:bg-zinc-800">
                        <div class="font-medium" x-text="item.message"></div>
                        <div class="mt-1 text-sm text-zinc-500 dark:text-zinc-400" x-text="item.receivedAt"></div>
                    </li>
                </template>
            </ul>
        </div>
    </div>
</x-layouts.echo>
