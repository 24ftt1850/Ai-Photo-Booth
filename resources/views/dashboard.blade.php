<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>RupaVue - Dashboard</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="min-h-screen bg-[#080A10] text-white">


    <!-- =========================
         NAVIGATION
    ========================== -->

    <nav class="border-b border-white/10 bg-[#080A10]/95">

        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5">

            <!-- Logo -->

            <a href="{{ url('/') }}"
               class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500 to-cyan-400 text-lg font-bold shadow-lg shadow-violet-500/20">

                    ✦

                </div>


                <div>

                    <h1 class="text-lg font-bold tracking-tight">
                        RupaVue
                    </h1>

                    <p class="text-[10px] uppercase tracking-[0.25em] text-gray-500">
                        AI Photo Booth
                    </p>

                </div>

            </a>


            <!-- Navigation -->

            <div class="hidden items-center gap-8 md:flex">

                <a href="{{ url('/dashboard') }}"
                   class="text-sm font-medium text-white">

                    Studio

                </a>


                <a href="#creations"
                   class="text-sm font-medium text-gray-500 transition hover:text-white">

                    My Creations

                </a>


                <a href="#how-it-works"
                   class="text-sm font-medium text-gray-500 transition hover:text-white">

                    How It Works

                </a>

            </div>


            <!-- User -->

            <div class="flex items-center gap-4">


                <div class="hidden text-right sm:block">

                    <p class="text-sm font-medium text-white">

                        {{ Auth::user()->name }}

                    </p>

                    <p class="text-xs text-gray-500">

                        Creator

                    </p>

                </div>


                <div class="flex h-10 w-10 items-center justify-center rounded-full border border-white/10 bg-white/5 text-sm font-bold">

                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}

                </div>


                <form method="POST"
                      action="{{ route('logout') }}">

                    @csrf

                    <button
                        type="submit"
                        title="Logout"
                        class="rounded-lg p-2 text-gray-500 transition hover:bg-white/10 hover:text-white">

                        <svg class="h-5 w-5"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h5a2 2 0 012 2v1" />

                        </svg>

                    </button>

                </form>

            </div>

        </div>

    </nav>



    <!-- =========================
         HERO / STUDIO
    ========================== -->

    <main>


        <section class="relative overflow-hidden">

            <!-- Background Glow -->

            <div class="pointer-events-none absolute -left-40 top-20 h-96 w-96 rounded-full bg-violet-600/20 blur-[120px]"></div>

            <div class="pointer-events-none absolute -right-40 top-40 h-96 w-96 rounded-full bg-cyan-500/10 blur-[120px]"></div>


            <div class="relative mx-auto max-w-7xl px-6 py-16 md:py-24">


                <!-- Small Label -->

                <div class="mb-6 flex items-center gap-3">

                    <span class="h-px w-10 bg-violet-500"></span>

                    <span class="text-xs font-semibold uppercase tracking-[0.3em] text-violet-400">

                        AI Portrait Studio

                    </span>

                </div>


                <!-- Main Heading -->

                <div class="max-w-4xl">

                    <h2 class="text-5xl font-bold leading-[1.05] tracking-tight md:text-7xl">

                        Your moment.

                        <br>

                        <span class="bg-gradient-to-r from-violet-400 via-purple-300 to-cyan-300 bg-clip-text text-transparent">

                            Reimagined.

                        </span>

                    </h2>


                    <p class="mt-7 max-w-2xl text-base leading-8 text-gray-400 md:text-lg">

                        Step into a new world with AI-powered portraits.
                        Choose a scene, capture your moment, and let
                        our AI transform your photo into something unforgettable.

                    </p>


                    <!-- Main Button -->

                    <div class="mt-10">

                        <a href="{{ route('events.index') }}"
                           class="group inline-flex items-center gap-4 rounded-2xl bg-white px-7 py-4 font-semibold text-gray-950 shadow-2xl shadow-violet-500/10 transition duration-300 hover:-translate-y-1 hover:bg-gray-100">


                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500 to-cyan-400 text-white">

                                ✦

                            </span>


                            <span>
                                Create Your Portrait
                            </span>


                            <span class="transition-transform duration-300 group-hover:translate-x-1">

                                →

                            </span>


                        </a>

                    </div>

                </div>


                <!-- Studio Preview -->

                <div class="mt-16 grid gap-5 md:grid-cols-12">


                    <!-- Main Preview -->

                    <div class="relative min-h-[430px] overflow-hidden rounded-3xl border border-white/10 bg-gradient-to-br from-[#171322] via-[#10131E] to-[#0D1A21] md:col-span-8">


                        <!-- Decorative circles -->

                        <div class="absolute -right-20 -top-20 h-72 w-72 rounded-full border border-violet-400/10"></div>

                        <div class="absolute -right-10 -top-10 h-52 w-52 rounded-full border border-cyan-400/10"></div>


                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_70%_30%,rgba(139,92,246,0.16),transparent_40%)]"></div>


                        <div class="relative flex h-full flex-col justify-between p-8 md:p-10">


                            <div>

                                <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-gray-400">

                                    AI EXPERIENCE

                                </span>


                                <h3 class="mt-5 max-w-md text-3xl font-bold leading-tight">

                                    Step into a scene that feels

                                    <span class="text-violet-400">
                                        made for you.
                                    </span>

                                </h3>

                            </div>


                            <!-- Fake preview frame -->

                            <div class="mx-auto mt-8 flex aspect-[4/3] w-full max-w-xl items-center justify-center overflow-hidden rounded-2xl border border-white/10 bg-black/20">


                                <div class="text-center">

                                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-gradient-to-br from-violet-500/20 to-cyan-400/20 text-4xl">

                                        ✦

                                    </div>


                                    <p class="mt-5 text-sm font-medium text-gray-300">

                                        Your AI portrait will appear here

                                    </p>


                                    <p class="mt-2 text-xs text-gray-600">

                                        Choose a theme to begin

                                    </p>

                                </div>


                            </div>


                        </div>

                    </div>


                    <!-- Side Information -->

                    <div class="flex flex-col gap-5 md:col-span-4">


                        <!-- Feature -->

                        <div class="flex-1 rounded-3xl border border-white/10 bg-white/[0.03] p-7">

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-violet-500/10 text-xl">

                                ✦

                            </div>


                            <h3 class="mt-6 text-xl font-bold">

                                Creative Scenes

                            </h3>


                            <p class="mt-3 text-sm leading-7 text-gray-500">

                                Explore cinematic worlds, cultural
                                environments, futuristic cities and
                                memorable event themes.

                            </p>

                        </div>


                        <!-- Feature -->

                        <div class="flex-1 rounded-3xl border border-white/10 bg-white/[0.03] p-7">

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-cyan-400/10 text-xl">

                                ◉

                            </div>


                            <h3 class="mt-6 text-xl font-bold">

                                Your Identity

                            </h3>


                            <p class="mt-3 text-sm leading-7 text-gray-500">

                                Our experience is designed to keep
                                your portrait recognizable while
                                transforming the surrounding scene.

                            </p>

                        </div>


                    </div>

                </div>

            </div>

        </section>



        <!-- =========================
             HOW IT WORKS
        ========================== -->

        <section id="how-it-works"
                 class="border-t border-white/10 bg-[#0C0F17]">


            <div class="mx-auto max-w-7xl px-6 py-20 md:py-24">


                <div class="max-w-2xl">

                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-violet-400">

                        Simple Experience

                    </p>


                    <h2 class="mt-4 text-3xl font-bold md:text-4xl">

                        From photo to imagination.

                    </h2>


                    <p class="mt-4 leading-7 text-gray-500">

                        Creating your AI portrait only takes a few simple steps.

                    </p>

                </div>


                <!-- Steps -->

                <div class="mt-12 grid gap-5 md:grid-cols-3">


                    <!-- Step 01 -->

                    <div class="group rounded-3xl border border-white/10 bg-white/[0.025] p-7 transition hover:border-violet-500/30">


                        <div class="flex items-center justify-between">

                            <span class="text-4xl font-bold text-white/10">

                                01

                            </span>


                            <span class="text-violet-400">

                                →

                            </span>

                        </div>


                        <h3 class="mt-12 text-xl font-bold">

                            Choose a Scene

                        </h3>


                        <p class="mt-3 text-sm leading-7 text-gray-500">

                            Select a creative theme that matches
                            your event, personality or imagination.

                        </p>

                    </div>


                    <!-- Step 02 -->

                    <div class="group rounded-3xl border border-white/10 bg-white/[0.025] p-7 transition hover:border-violet-500/30">


                        <div class="flex items-center justify-between">

                            <span class="text-4xl font-bold text-white/10">

                                02

                            </span>


                            <span class="text-violet-400">

                                →

                            </span>

                        </div>


                        <h3 class="mt-12 text-xl font-bold">

                            Capture Your Moment

                        </h3>


                        <p class="mt-3 text-sm leading-7 text-gray-500">

                            Take a photograph using the photo booth
                            camera and preview it before continuing.

                        </p>

                    </div>


                    <!-- Step 03 -->

                    <div class="group rounded-3xl border border-white/10 bg-white/[0.025] p-7 transition hover:border-violet-500/30">


                        <div class="flex items-center justify-between">

                            <span class="text-4xl font-bold text-white/10">

                                03

                            </span>


                            <span class="text-cyan-400">

                                ✦

                            </span>

                        </div>


                        <h3 class="mt-12 text-xl font-bold">

                            Meet Your New Portrait

                        </h3>


                        <p class="mt-3 text-sm leading-7 text-gray-500">

                            AI transforms your photo into the selected
                            scene and prepares it for download.

                        </p>

                    </div>


                </div>

            </div>

        </section>



        <!-- =========================
             MY CREATIONS
        ========================== -->

        <section id="creations"
                 class="border-t border-white/10 bg-[#080A10]">


            <div class="mx-auto max-w-7xl px-6 py-20 md:py-24">


                <div class="flex flex-col justify-between gap-5 md:flex-row md:items-end">


                    <div>

                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-cyan-400">

                            Your Gallery

                        </p>


                        <h2 class="mt-4 text-3xl font-bold">

                            My Creations

                        </h2>


                        <p class="mt-3 text-gray-500">

                            Your generated portraits will be saved here.

                        </p>

                    </div>


                    <span class="rounded-full border border-white/10 px-4 py-2 text-xs text-gray-500">

                        0 portraits

                    </span>

                </div>


                <!-- Empty Gallery -->

                <div class="mt-10 flex min-h-[280px] items-center justify-center rounded-3xl border border-dashed border-white/10 bg-white/[0.02]">


                    <div class="text-center">


                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl border border-white/10 bg-white/[0.03] text-2xl text-gray-500">

                            ✦

                        </div>


                        <h3 class="mt-5 font-semibold">

                            Your gallery is empty

                        </h3>


                        <p class="mt-2 text-sm text-gray-600">

                            Create your first AI portrait and it will appear here.

                        </p>


                        <a href="{{ route('events.index') }}"
                           class="mt-6 inline-flex rounded-xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-medium transition hover:bg-white/10">

                            Create Your First Portrait →

                        </a>

                    </div>

                </div>

            </div>

        </section>



        <!-- =========================
             CALL TO ACTION
        ========================== -->

        <section class="border-t border-white/10 bg-[#0C0F17]">


            <div class="mx-auto max-w-5xl px-6 py-20 text-center md:py-28">


                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-violet-400">

                    Ready?

                </p>


                <h2 class="mt-5 text-4xl font-bold tracking-tight md:text-6xl">

                    Make your next photo

                    <span class="bg-gradient-to-r from-violet-400 to-cyan-300 bg-clip-text text-transparent">

                        unforgettable.

                    </span>

                </h2>


                <p class="mx-auto mt-6 max-w-xl leading-7 text-gray-500">

                    Choose your event, select a scene and
                    let AI create something unique.

                </p>


                <a href="{{ route('events.index') }}"
                   class="mt-9 inline-flex items-center gap-3 rounded-2xl bg-white px-7 py-4 font-semibold text-gray-950 transition hover:-translate-y-1 hover:bg-gray-100">

                    Start Creating

                    <span>
                        →
                    </span>

                </a>

            </div>

        </section>

    </main>



    <!-- =========================
         FOOTER
    ========================== -->

    <footer class="border-t border-white/10 bg-[#080A10]">

        <div class="mx-auto flex max-w-7xl flex-col justify-between gap-3 px-6 py-8 text-sm text-gray-600 md:flex-row">

            <p>
                © {{ date('Y') }} AI Studio
            </p>


            <p>
                AI-powered event photography
            </p>

        </div>

    </footer>


</body>

</html>