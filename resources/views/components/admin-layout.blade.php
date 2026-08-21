@props(['title' => 'Admin'])

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        {{ $title }} - {{ config('app.name', 'RupaVue') }} Admin
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body class="min-h-screen bg-[#080A10] text-white">

<div class="flex min-h-screen">


    <!-- =====================================================
         SIDEBAR
    ====================================================== -->

    <aside
        class="hidden w-64 shrink-0 flex-col border-r border-white/10 bg-[#0A0C13] md:flex"
    >

        <!-- Logo -->

        <a
            href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 border-b border-white/10 px-6 py-5"
        >

            <div
                class="flex h-9 w-9 items-center justify-center rounded-xl
                       bg-gradient-to-br from-violet-500 to-cyan-400
                       text-base font-bold
                       shadow-lg shadow-violet-500/20"
            >
                ✦
            </div>

            <div>

                <p class="text-sm font-bold tracking-tight">
                    RupaVue
                </p>

                <p class="text-[10px] uppercase tracking-[0.25em] text-gray-500">
                    Admin
                </p>

            </div>

        </a>


        <!-- =================================================
             NAVIGATION
        ================================================== -->

        <nav class="flex-1 space-y-1 px-3 py-6">

            @php

                $links = [

                    [
                        'route' => 'admin.dashboard',
                        'label' => 'Dashboard',
                        'icon' => '◧',
                    ],

                    [
                        'route' => 'admin.events.index',
                        'label' => 'Events',
                        'icon' => '◷',
                    ],

                    [
                        'route' => 'admin.themes.index',
                        'label' => 'Themes',
                        'icon' => '✦',
                    ],

                    [
                        'route' => 'admin.analytics.index',
                        'label' => 'Analytics',
                        'icon' => '◎',
                    ],

                    [
                        'route' => 'admin.feedback.index',
                        'label' => 'Feedback',
                        'icon' => '♡',
                    ],

                ];

            @endphp


            @foreach ($links as $link)

            @php
                $active = request()->routeIs($link['route']);
            @endphp

            <a
                href="{{ route($link['route']) }}"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5
                    text-sm font-medium transition
                    {{ $active
                            ? 'bg-white/10 text-white'
                            : 'text-gray-400 hover:bg-white/5 hover:text-white'
                    }}"
            >

                <span
                    class="{{ $active
                        ? 'text-violet-400'
                        : 'text-gray-600'
                    }}"
                >
                    {{ $link['icon'] }}
                </span>

                {{ $link['label'] }}

            </a>

        @endforeach

        </nav>


        <!-- =================================================
             BOTTOM SIDEBAR
        ================================================== -->

        <div class="space-y-3 border-t border-white/10 p-4">


            <!-- Back to Studio -->

            <a
                href="{{ url('/') }}"
                class="flex items-center gap-2 rounded-xl px-3 py-2
                       text-sm text-gray-500 transition
                       hover:bg-white/5 hover:text-white"
            >

                ← Back to Studio

            </a>


            <!-- Admin Account -->

            <div
                class="flex items-center gap-3 rounded-xl
                       border border-white/10 bg-white/[0.03] p-3"
            >

                <div
                    class="flex h-9 w-9 items-center justify-center
                           rounded-full border border-white/10
                           bg-white/5 text-sm font-bold"
                >
                    A
                </div>


                <div class="min-w-0 flex-1">

                    <p class="truncate text-sm font-medium">
                        Administrator
                    </p>

                    <p class="truncate text-xs text-gray-500">
                        {{ session('admin_email') }}
                    </p>

                </div>


                <!-- Logout -->

                <form
                    method="POST"
                    action="{{ route('admin.logout') }}"
                >

                    @csrf

                    <button
                        type="submit"
                        title="Logout"
                        class="rounded-lg p-1.5 text-gray-500
                               transition hover:bg-white/10 hover:text-white"
                    >

                        <svg
                            class="h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h5a2 2 0 012 2v1"
                            />

                        </svg>

                    </button>

                </form>

            </div>

        </div>

    </aside>


    <!-- =====================================================
         MAIN CONTENT
    ====================================================== -->

    <div class="flex min-w-0 flex-1 flex-col">


        <!-- Header -->

        <header
            class="flex items-center justify-between
                   border-b border-white/10
                   bg-[#080A10]/95
                   px-6 py-5 md:px-10"
        >

            <div>

                <h1 class="text-2xl font-bold tracking-tight">
                    {{ $title }}
                </h1>


                @isset($subtitle)

                    <p class="mt-1 text-sm text-gray-500">
                        {{ $subtitle }}
                    </p>

                @endisset

            </div>


            @isset($actions)

                <div class="flex items-center gap-3">

                    {{ $actions }}

                </div>

            @endisset

        </header>


        <!-- Main -->

        <main class="flex-1 px-6 py-8 md:px-10">


            <!-- Success message -->

            @if (session('status'))

                <div
                    class="mb-6 rounded-2xl
                           border border-emerald-400/30
                           bg-emerald-400/10
                           px-4 py-3
                           text-sm text-emerald-300"
                >

                    {{ session('status') }}

                </div>

            @endif


            <!-- Errors -->

            @if ($errors->any())

                <div
                    class="mb-6 rounded-2xl
                           border border-red-400/30
                           bg-red-400/10
                           px-4 py-3
                           text-sm text-red-300"
                >

                    <ul class="list-inside list-disc space-y-1">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <!-- Page content -->

            {{ $slot }}

        </main>

    </div>

</div>

</body>

</html>