<x-layouts.echo :title="__('Broadcast')">
    <div class="space-y-6">
        <flux:callout icon="megaphone" variant="secondary">
            {{ __('Open the Receive page in another tab, then broadcast a message from here.') }}
        </flux:callout>

        @if (session('status'))
            <flux:callout icon="check-circle" variant="success">
                {{ session('status') }}
            </flux:callout>
        @endif

        <form method="POST" action="{{ route('echo.broadcast') }}" class="space-y-4">
            @csrf

            <flux:field>
                <flux:label>{{ __('Message') }}</flux:label>
                <flux:input name="message" :value="old('message', 'Hello from Echo')" required maxlength="255" autofocus />
                <flux:error name="message" />
            </flux:field>

            <flux:button type="submit" variant="primary" icon="paper-airplane">
                {{ __('Broadcast') }}
            </flux:button>
        </form>
    </div>
</x-layouts.echo>
