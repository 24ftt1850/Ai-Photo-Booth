<x-admin-layout title="Google Drive" subtitle="Save generated photos to Drive and read photo frames from it">

    @if (session('error'))
        <div class="mb-6 rounded-2xl border border-red-400/30 bg-red-400/10 px-4 py-3 text-sm text-red-300">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid gap-5 lg:grid-cols-3">

        {{-- Connection --}}
        <div class="rounded-3xl border border-white/10 bg-white/[0.03] p-6 lg:col-span-2">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Google account</p>

                    @if ($isConnected)
                        <h3 class="mt-2 text-lg font-bold">Connected</h3>
                        <p class="mt-1 text-sm text-gray-400">{{ $connectedEmail ?? 'Google account' }}</p>
                    @else
                        <h3 class="mt-2 text-lg font-bold">Not connected</h3>
                        <p class="mt-1 text-sm text-gray-400">Connect a Google account so generated photos are saved to Drive and frames can be read from it.</p>
                    @endif

                    @if ($connectionError)
                        <p class="mt-3 text-sm text-red-300">{{ $connectionError }}</p>
                    @endif
                </div>

                <span @class([
                    'rounded-full border px-3 py-1 text-[10px] font-semibold uppercase tracking-wider',
                    'border-emerald-400/30 bg-emerald-400/10 text-emerald-300' => $isConnected && ! $connectionError,
                    'border-amber-400/30 bg-amber-400/10 text-amber-300' => $isConnected && $connectionError,
                    'border-white/10 bg-white/5 text-gray-400' => ! $isConnected,
                ])>
                    {{ $isConnected ? ($connectionError ? 'Needs attention' : 'Connected') : 'Disconnected' }}
                </span>
            </div>

            <div class="mt-6 flex flex-wrap items-center gap-3 border-t border-white/5 pt-5">
                <a href="{{ route('google-drive.connect') }}"
                   class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-gray-950 transition hover:bg-gray-100">
                    {{ $isConnected ? 'Reconnect Google' : 'Connect Google' }}
                </a>

                @if ($isConnected)
                    <form method="POST" action="{{ route('admin.google-drive.disconnect') }}" onsubmit="return confirm('Disconnect Google Drive? New photos will not be saved to Drive.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm font-medium text-red-400 hover:text-red-300">Disconnect</button>
                    </form>
                @endif
            </div>
        </div>

        {{-- Folders --}}
        <div class="rounded-3xl border border-white/10 bg-white/[0.03] p-6">
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Drive folders</p>

            <ul class="mt-4 space-y-3 text-sm">
                <li class="flex items-center justify-between gap-3">
                    <span class="text-gray-300">Generated photos</span>
                    <span class="{{ $hasGeneratedFolder ? 'text-emerald-300' : 'text-red-300' }}">{{ $hasGeneratedFolder ? 'Configured' : 'Missing' }}</span>
                </li>
                <li class="flex items-center justify-between gap-3">
                    <span class="text-gray-300">Photo frames</span>
                    <span class="{{ $hasFramesFolder ? 'text-emerald-300' : 'text-red-300' }}">{{ $hasFramesFolder ? 'Configured' : 'Missing' }}</span>
                </li>
            </ul>

            <p class="mt-4 text-xs leading-5 text-gray-600">
                Set <code>GOOGLE_DRIVE_GENERATED_FOLDER_ID</code> and <code>GOOGLE_DRIVE_FRAMES_FOLDER_ID</code> in <code>.env</code>.
            </p>
        </div>
    </div>

    {{-- Frames --}}
    <div class="mt-8 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-bold">Photo frames</h2>
            <p class="mt-1 text-sm text-gray-500">PNG frames read from the Drive frames folder. Guests can pick active frames.</p>
        </div>

        <form method="POST" action="{{ route('admin.google-drive.frames.sync') }}">
            @csrf
            <button type="submit" @disabled(! $isConnected || ! $hasFramesFolder)
                    class="inline-flex items-center gap-2 rounded-xl border border-white/10 bg-white/5 px-4 py-2.5 text-sm font-semibold transition hover:bg-white/10 disabled:cursor-not-allowed disabled:opacity-40">
                Read frames from Drive
            </button>
        </form>
    </div>

    @if ($frames->isEmpty())
        <div class="mt-5 flex min-h-[180px] items-center justify-center rounded-3xl border border-dashed border-white/10 bg-white/[0.02] p-10 text-center">
            <div>
                <p class="font-semibold">No frames yet</p>
                <p class="mt-2 text-sm text-gray-500">Upload transparent PNG frames to the Drive frames folder, then read them here.</p>
            </div>
        </div>
    @else
        <div class="mt-5 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($frames as $frame)
                <div class="flex flex-col overflow-hidden rounded-3xl border border-white/10 bg-white/[0.03]">
                    <div class="relative flex aspect-[3/2] items-center justify-center bg-[repeating-conic-gradient(#1f2330_0%_25%,#171a24_0%_50%)] bg-[length:20px_20px]">
                        <img src="{{ $frame->previewUrl() }}" alt="{{ $frame->frame_name }}" class="h-full w-full object-contain">

                        <span @class([
                            'absolute right-3 top-3 rounded-full border px-3 py-1 text-[10px] font-semibold uppercase tracking-wider',
                            'border-emerald-400/30 bg-emerald-400/10 text-emerald-300' => $frame->is_active,
                            'border-white/10 bg-white/5 text-gray-400' => ! $frame->is_active,
                        ])>
                            {{ $frame->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <div class="flex flex-1 items-center justify-between gap-3 p-4 text-sm">
                        <span class="truncate font-semibold">{{ $frame->frame_name }}</span>

                        <form method="POST" action="{{ route('admin.google-drive.frames.toggle', $frame) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-xs font-medium text-gray-400 hover:text-white">
                                {{ $frame->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</x-admin-layout>
