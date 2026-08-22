<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-zinc-50 text-zinc-900 dark:bg-zinc-900 dark:text-zinc-100">
        <div class="mx-auto flex min-h-screen w-full max-w-2xl flex-col gap-6 px-6 py-10">
            <header class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <flux:heading size="lg">{{ $title ?? __('Echo / Reverb') }}</flux:heading>
                    <flux:text class="mt-1">{{ __('Simple Laravel Echo + Reverb smoke test') }}</flux:text>
                </div>

                <nav class="flex gap-2">
                    <flux:button
                        :href="route('echo.send')"
                        :variant="request()->routeIs('echo.send') ? 'primary' : 'ghost'"
                        size="sm"
                    >
                        {{ __('Send') }}
                    </flux:button>
                    <flux:button
                        :href="route('echo.receive')"
                        :variant="request()->routeIs('echo.receive') ? 'primary' : 'ghost'"
                        size="sm"
                    >
                        {{ __('Receive') }}
                    </flux:button>
                </nav>
            </header>

            <main class="flex-1">
                {{ $slot }}
            </main>
        </div>

        @fluxScripts
    </body>
</html>
