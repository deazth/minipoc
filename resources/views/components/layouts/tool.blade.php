<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-zinc-50 text-zinc-900 dark:bg-zinc-900 dark:text-zinc-100">
        <div class="mx-auto flex min-h-screen w-full max-w-3xl flex-col gap-6 px-6 py-10">
            <header class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <flux:heading size="lg">{{ $title ?? __('Tools') }}</flux:heading>
                    @isset($subtitle)
                        <flux:text class="mt-1">{{ $subtitle }}</flux:text>
                    @endisset
                </div>

                <nav class="flex gap-2">
                    <flux:button :href="route('home')" variant="ghost" size="sm" icon="home">
                        {{ __('Home') }}
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
