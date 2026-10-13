{{--
    Rupa's voice lines for a photobooth page. Include after the
    background music partial so the music goes lower while she talks.

    voices      - voice files to play one after another (without .mp3)
    delay       - seconds on the page before she starts talking;
                  leave out to start from the page's own script
                  with window.rupavueVoice.start(seconds)
    repeatAfter - seconds to wait after she finishes before saying
                  it again while the guest is still on the page
--}}
<script>

    /*
     * =========================
     * RUPA VOICE
     * =========================
     */

    window.rupavueVoice = (function () {

        const urls = @json(collect($voices)->map(fn (string $voice): string => asset("storage/audio/voice/{$voice}.mp3"))->values());

        const delay = @json($delay ?? null);

        const repeatAfter = @json($repeatAfter ?? null);

        const clips = urls.map(function (url) {
            const clip = new Audio(url);
            clip.preload = 'auto';

            return clip;
        });

        let timer = null;

        let isStarted = false;

        function setTalking(isTalking) {

            if (window.rupavueMusic) {
                window.rupavueMusic.duckForVoice(isTalking);
            }

        }

        function playFrom(index) {

            if (index >= clips.length) {
                setTalking(false);

                if (repeatAfter !== null) {
                    timer = setTimeout(function () {
                        playFrom(0);
                    }, repeatAfter * 1000);
                }

                return;
            }

            const clip = clips[index];

            clip.currentTime = 0;
            clip.onended = function () {
                playFrom(index + 1);
            };

            setTalking(true);

            /*
             * If the browser blocks sound before the guest has
             * touched the screen, say this line on the first tap.
             */
            clip.play().catch(function () {
                setTalking(false);
                playOnFirstTap(index);
            });

        }

        function playOnFirstTap(index) {

            const unlock = function () {
                document.removeEventListener('pointerdown', unlock, true);
                document.removeEventListener('keydown', unlock, true);

                playFrom(index);
            };

            document.addEventListener('pointerdown', unlock, true);
            document.addEventListener('keydown', unlock, true);

        }

        function start(seconds) {

            if (isStarted) {
                return;
            }

            isStarted = true;

            timer = setTimeout(function () {
                playFrom(0);
            }, (seconds || 0) * 1000);

        }

        function stop() {

            clearTimeout(timer);

            clips.forEach(function (clip) {
                clip.onended = null;
                clip.pause();
            });

            setTalking(false);

        }

        if (delay !== null) {
            start(delay);
        }

        window.addEventListener('pagehide', stop);

        /*
         * Coming back with the Back button restores this page from
         * the browser cache; greet the guest again.
         */
        window.addEventListener('pageshow', function (event) {

            if (event.persisted && delay !== null) {
                isStarted = false;
                start(delay);
            }

        });

        return { start: start, stop: stop };

    })();

</script>
