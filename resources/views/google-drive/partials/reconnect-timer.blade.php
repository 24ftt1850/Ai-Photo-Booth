{{--
    Live countdown to when Google stops accepting the refresh token.
    Expects $deadline (CarbonImmutable) and inherits the page's styles.
--}}
<p class="drive-timer" data-reconnect-deadline="{{ $deadline->toIso8601String() }}">
    Reconnect within
    <strong class="drive-timer-remaining">{{ $deadline->diffForHumans(syntax: \Carbon\CarbonInterface::DIFF_ABSOLUTE, parts: 3) }}</strong>
    <span class="drive-timer-date">(by {{ $deadline->timezone(config('app.timezone'))->format('j M Y, g:i A') }})</span>
</p>

<script>
    document.querySelectorAll('[data-reconnect-deadline]').forEach(function (timer) {
        const deadline = new Date(timer.dataset.reconnectDeadline).getTime();
        const remaining = timer.querySelector('.drive-timer-remaining');

        function tick() {
            const seconds = Math.floor((deadline - Date.now()) / 1000);

            if (seconds <= 0) {
                timer.classList.add('is-expired');
                timer.textContent = 'Google Drive access has expired. Please reconnect now.';

                return;
            }

            const days = Math.floor(seconds / 86400);
            const hours = Math.floor((seconds % 86400) / 3600);
            const minutes = Math.floor((seconds % 3600) / 60);

            remaining.textContent = days + 'd ' + hours + 'h ' + minutes + 'm ' + (seconds % 60) + 's';

            timer.classList.toggle('is-soon', seconds < 86400);

            setTimeout(tick, 1000);
        }

        tick();
    });
</script>
