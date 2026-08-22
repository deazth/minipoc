<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .landing {
                --landing-ink: #13222b;
                --landing-mist: #e8f1f0;
                --landing-foam: #f7fbfa;
                --landing-sea: #1f7a6c;
                --landing-sea-deep: #155e54;
                --landing-sand: #c4a574;
            }

            @keyframes landing-rise {
                from {
                    opacity: 0;
                    transform: translateY(18px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes landing-drift {
                0%,
                100% {
                    transform: translate3d(0, 0, 0) scale(1);
                }
                50% {
                    transform: translate3d(12px, -18px, 0) scale(1.04);
                }
            }

            @keyframes landing-sweep {
                from {
                    transform: translateX(-12%) scaleX(0.92);
                    opacity: 0.35;
                }
                to {
                    transform: translateX(0) scaleX(1);
                    opacity: 1;
                }
            }

            .landing-rise {
                animation: landing-rise 0.9s cubic-bezier(0.22, 1, 0.36, 1) both;
            }

            .landing-rise-delay {
                animation-delay: 0.12s;
            }

            .landing-rise-delay-2 {
                animation-delay: 0.24s;
            }

            .landing-drift {
                animation: landing-drift 14s ease-in-out infinite;
            }

            .landing-sweep {
                animation: landing-sweep 1.1s cubic-bezier(0.22, 1, 0.36, 1) both;
            }

            @media (prefers-reduced-motion: reduce) {
                .landing-rise,
                .landing-drift,
                .landing-sweep {
                    animation: none;
                }
            }
        </style>
    </head>
    <body class="landing min-h-screen overflow-x-hidden bg-[var(--landing-foam)] font-sans text-[var(--landing-ink)] antialiased">
        <div class="relative isolate min-h-screen">
            <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden" aria-hidden="true">
                <div class="landing-sweep absolute inset-y-0 start-0 w-[72%] bg-[radial-gradient(120%_80%_at_0%_0%,#d7ebe7_0%,transparent_58%),linear-gradient(135deg,var(--landing-mist)_0%,var(--landing-foam)_55%,#fff_100%)]"></div>
                <div class="landing-drift absolute -top-24 -end-16 size-[28rem] rounded-full bg-[radial-gradient(circle_at_center,rgba(31,122,108,0.28),transparent_68%)] blur-2xl"></div>
                <div class="absolute bottom-[-8rem] start-[-6rem] size-[22rem] rounded-full bg-[radial-gradient(circle_at_center,rgba(196,165,116,0.22),transparent_70%)] blur-2xl"></div>
                <div class="absolute inset-x-0 bottom-0 h-40 bg-[linear-gradient(to_top,rgba(19,34,43,0.06),transparent)]"></div>
            </div>

            <header class="mx-auto flex w-full max-w-6xl items-center justify-between px-6 py-6 sm:px-8">
                <a href="{{ route('home') }}" class="text-lg font-semibold tracking-tight text-[var(--landing-ink)]">
                    {{ config('app.name', 'Laravel') }}
                </a>

                <nav class="flex items-center gap-3 text-sm">
                    @auth
                        <a
                            href="{{ route('dashboard') }}"
                            class="rounded-md px-3 py-2 text-[var(--landing-ink)]/80 transition hover:bg-black/5 hover:text-[var(--landing-ink)]"
                        >
                            {{ __('Dashboard') }}
                        </a>
                    @else
                        @if (Route::has('login'))
                            <a
                                href="{{ route('login') }}"
                                class="rounded-md px-3 py-2 text-[var(--landing-ink)]/80 transition hover:bg-black/5 hover:text-[var(--landing-ink)]"
                            >
                                {{ __('Log in') }}
                            </a>
                        @endif
                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="rounded-md bg-[var(--landing-ink)] px-3 py-2 text-[var(--landing-foam)] transition hover:bg-[var(--landing-sea-deep)]"
                            >
                                {{ __('Register') }}
                            </a>
                        @endif
                    @endauth
                </nav>
            </header>

            <main class="mx-auto flex w-full max-w-6xl flex-col justify-center px-6 pb-20 pt-10 sm:px-8 sm:pt-16 lg:min-h-[calc(100vh-5.5rem)] lg:pb-24 lg:pt-8">
                <div class="max-w-2xl">
                    <p class="landing-rise text-sm font-medium tracking-[0.18em] text-[var(--landing-sea)] uppercase">
                        {{ config('app.name', 'Laravel') }}
                    </p>

                    <h1 class="landing-rise landing-rise-delay mt-5 text-4xl leading-[1.05] font-semibold tracking-tight text-[var(--landing-ink)] sm:text-5xl lg:text-6xl">
                        {{ __('Realtime experiments, ready to wire.') }}
                    </h1>

                    <p class="landing-rise landing-rise-delay-2 mt-5 max-w-xl text-lg leading-relaxed text-[var(--landing-ink)]/70">
                        {{ __('Open a sender and a listener to smoke-test Laravel Echo and Reverb in two tabs.') }}
                    </p>

                    <div class="landing-rise landing-rise-delay-2 mt-10 flex flex-wrap items-center gap-3">
                        <a
                            href="{{ route('echo.send') }}"
                            class="inline-flex items-center justify-center rounded-md bg-[var(--landing-sea)] px-5 py-3 text-sm font-medium text-white transition hover:bg-[var(--landing-sea-deep)]"
                        >
                            {{ __('Echo Send') }}
                        </a>
                        <a
                            href="{{ route('echo.receive') }}"
                            class="inline-flex items-center justify-center rounded-md border border-[var(--landing-ink)]/15 bg-white/70 px-5 py-3 text-sm font-medium text-[var(--landing-ink)] backdrop-blur-sm transition hover:border-[var(--landing-sea)]/40 hover:bg-white"
                        >
                            {{ __('Echo Receive') }}
                        </a>
                        <a
                            href="{{ route('n8n.webhook') }}"
                            class="inline-flex items-center justify-center rounded-md border border-[var(--landing-ink)]/15 bg-white/70 px-5 py-3 text-sm font-medium text-[var(--landing-ink)] backdrop-blur-sm transition hover:border-[var(--landing-sea)]/40 hover:bg-white"
                        >
                            {{ __('n8n Webhook') }}
                        </a>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
