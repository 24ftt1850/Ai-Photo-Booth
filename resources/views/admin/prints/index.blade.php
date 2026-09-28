<x-admin-layout title="Print Queue" subtitle="Photos guests have asked to print — print them from this computer">

    <x-slot:actions>
        <span class="rounded-full border border-violet-400/30 bg-violet-400/10 px-3 py-1 text-xs font-semibold text-violet-300">
            {{ $queuedPrints->count() }} waiting
        </span>
    </x-slot:actions>

    @if ($queuedPrints->isEmpty())
        <div class="flex min-h-[220px] items-center justify-center rounded-3xl border border-dashed border-white/10 bg-white/[0.02] p-10 text-center">
            <div>
                <p class="font-semibold">No photos waiting to print</p>
                <p class="mt-2 text-sm text-gray-500">When a guest taps “Print Photo”, it will appear here.</p>
            </div>
        </div>
    @else
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($queuedPrints as $print)
                <div class="flex flex-col overflow-hidden rounded-3xl border border-white/10 bg-white/[0.03]">
                    <div class="flex h-56 items-center justify-center overflow-hidden bg-black/40">
                        @if ($print->generated_photo_path)
                            <img src="{{ Storage::url($print->generated_photo_path) }}" alt="Photo #{{ $print->id }}" class="h-full w-full object-contain">
                        @else
                            <span class="text-sm text-gray-500">Photo file missing</span>
                        @endif
                    </div>

                    <div class="flex flex-1 flex-col p-6">
                        <h3 class="text-lg font-bold">Photo #{{ $print->id }}</h3>
                        <p class="mt-1 text-xs text-gray-500">
                            Requested {{ $print->print_requested_at?->diffForHumans() }}
                        </p>

                        <div class="mt-5 flex items-center justify-between border-t border-white/5 pt-4 text-xs font-medium">
                            <form method="POST" action="{{ route('admin.prints.destroy', $print) }}" onsubmit="return confirm('Remove this print request?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300">Remove</button>
                            </form>

                            <div class="flex items-center gap-3">
                                <form method="POST" action="{{ route('admin.prints.printed', $print) }}" id="printedForm{{ $print->id }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-gray-400 hover:text-white">Mark printed</button>
                                </form>

                                @if ($print->generated_photo_path)
                                    <button
                                        type="button"
                                        class="admin-print-button rounded-xl bg-white px-4 py-2 text-sm font-semibold text-gray-950 transition hover:bg-gray-100"
                                        data-photo-url="{{ Storage::url($print->generated_photo_path) }}"
                                        data-printed-form="printedForm{{ $print->id }}"
                                    >
                                        🖨️ Print
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if ($recentlyPrinted->isNotEmpty())
        <h2 class="mb-4 mt-10 text-sm font-semibold uppercase tracking-wider text-gray-500">Recently printed</h2>

        <div class="grid grid-cols-3 gap-3 sm:grid-cols-4 lg:grid-cols-6">
            @foreach ($recentlyPrinted as $print)
                <div class="overflow-hidden rounded-2xl border border-white/10 bg-white/[0.03]">
                    @if ($print->generated_photo_path)
                        <img src="{{ Storage::url($print->generated_photo_path) }}" alt="Photo #{{ $print->id }}" class="h-24 w-full object-cover opacity-70">
                    @endif
                    <p class="px-3 py-2 text-[11px] text-gray-500">#{{ $print->id }} · {{ $print->printed_at?->diffForHumans() }}</p>
                </div>
            @endforeach
        </div>
    @endif

    <script>
        /*
         * Print a queued photo on this (admin) computer, then
         * mark it as printed once the print dialog closes.
         */
        let isPrinting = false;

        document.querySelectorAll('.admin-print-button').forEach(function (button) {
            button.addEventListener('click', function () {
                const printWindow = window.open('', '_blank');

                if (!printWindow) {
                    alert('Please allow pop-ups to print the photo.');

                    return;
                }

                isPrinting = true;

                const printDoc = printWindow.document;

                printDoc.title = 'RupaVue Photo';

                const printStyle = printDoc.createElement('style');

                printStyle.textContent =
                    '@page { size: auto; margin: 0; }' +
                    'html, body { margin: 0; padding: 0; width: 100%; min-height: 100%; display: flex; justify-content: center; align-items: center; }' +
                    'img { width: 3in; height: 2in; object-fit: cover; display: block; }';

                printDoc.head.appendChild(printStyle);

                const printImage = printDoc.createElement('img');

                printImage.alt = 'RupaVue Photo';

                printImage.onload = function () {
                    printWindow.focus();
                    printWindow.print();
                    printWindow.close();

                    document.getElementById(button.dataset.printedForm).submit();
                };

                printImage.onerror = function () {
                    printWindow.close();
                    isPrinting = false;

                    alert('Unable to load the photo for printing.');
                };

                printImage.src = new URL(button.dataset.photoUrl, window.location.href).href;

                printDoc.body.appendChild(printImage);
            });
        });

        /*
         * Keep the queue fresh so new guest requests show up
         * without the admin reloading the page.
         */
        setInterval(function () {
            if (!isPrinting) {
                window.location.reload();
            }
        }, 15000);
    </script>

</x-admin-layout>
