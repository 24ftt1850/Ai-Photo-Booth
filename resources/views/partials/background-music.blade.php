{{--
    Background music shared by every photobooth page.

    Pass the page's mood:
    welcome  - silent for 3 seconds, then fades in to full volume
               (if the music is already playing it just carries on)
    soft     - plays quietly (theme, frame and camera pages)
    generate - starts quiet, gets a little louder after 3 seconds
    result   - replays the song from the start, low at first as the
               photo appears, then back to full volume a few
               seconds later
    normal   - plays at full volume
--}}
@php
    /*
     * Versioned by the file's last change so swapping in a new
     * background.mp3 is not hidden by the browser's cache.
     */
    $musicPath = storage_path('app/public/audio/background.mp3');
    $musicVersion = file_exists($musicPath) ? filemtime($musicPath) : null;
@endphp
<audio
    id="rvBackgroundMusic"
    src="{{ asset('storage/audio/background.mp3') }}{{ $musicVersion ? '?v='.$musicVersion : '' }}"
    data-mood="{{ $mood ?? 'normal' }}"
    loop
    preload="auto"
></audio>

<script>

    /*
     * =========================
     * BACKGROUND MUSIC
     * =========================
     *
     * Every page is a full page load, so the playback position
     * and volume are kept in sessionStorage and the next page
     * carries on from the same spot at the same volume. Only the
     * result page, or refreshing a page, starts the song again. Volume runs through a
     * Web Audio gain node so the fades also work where media
     * volume is fixed (iPad / iPhone).
     */

    window.rupavueMusic = (function () {

        const levels = {
            silent: 0,
            duck: 0.03,
            soft: 0.07,
            generate: 0.12,
            normal: 0.2,
        };

        const stateKey = 'rupavueMusicState';

        const audio = document.getElementById('rvBackgroundMusic');

        const mood = audio.dataset.mood;

        const AudioContextClass = window.AudioContext || window.webkitAudioContext;

        let audioContext = null;

        let gain = null;

        let voiceDuck = null;

        let timers = [];

        function setUpGain() {

            if (audioContext || !AudioContextClass) {
                return;
            }

            audioContext = new AudioContextClass();

            gain = audioContext.createGain();
            gain.gain.value = 0;

            voiceDuck = audioContext.createGain();

            audioContext
                .createMediaElementSource(audio)
                .connect(gain)
                .connect(voiceDuck)
                .connect(audioContext.destination);

        }

        function currentLevel() {
            return gain ? gain.gain.value : audio.volume;
        }

        function fadeTo(level, seconds) {

            const target = levels[level] ?? level;

            if (!gain) {
                audio.volume = target;

                return;
            }

            const now = audioContext.currentTime;

            gain.gain.cancelScheduledValues(now);
            gain.gain.setValueAtTime(gain.gain.value, now);

            if (seconds > 0) {
                gain.gain.linearRampToValueAtTime(target, now + seconds);
            } else {
                gain.gain.setValueAtTime(target, now);
            }

        }

        /*
         * Lower the music while Rupa's voice is talking, on top of
         * whatever volume the page has set.
         */
        function duckForVoice(isTalking) {

            if (!voiceDuck) {
                return;
            }

            const now = audioContext.currentTime;

            voiceDuck.gain.cancelScheduledValues(now);
            voiceDuck.gain.setValueAtTime(voiceDuck.gain.value, now);
            voiceDuck.gain.linearRampToValueAtTime(isTalking ? 0.4 : 1, now + (isTalking ? 0.3 : 0.8));

        }

        function later(seconds, callback) {
            timers.push(setTimeout(callback, seconds * 1000));
        }

        /**
         * @returns {{ position: number, level: number } | null}
         */
        function readState() {

            try {
                return JSON.parse(sessionStorage.getItem(stateKey));
            } catch (error) {
                return null;
            }

        }

        /*
         * Refreshing the page starts the song over, as if the
         * guest had just arrived.
         */
        function isReload() {

            const navigation = performance.getEntriesByType
                ? performance.getEntriesByType('navigation')[0]
                : null;

            return navigation !== undefined && navigation !== null && navigation.type === 'reload';

        }

        function saveState() {

            try {
                sessionStorage.setItem(stateKey, JSON.stringify({
                    position: audio.currentTime,
                    level: audio.paused ? 0 : currentLevel(),
                }));
            } catch (error) {
                // Storage unavailable; the next page starts from the beginning.
            }

        }

        /*
         * Seeking only sticks once the browser knows the song's
         * length, so wait for that before jumping to the spot.
         */
        function seekTo(position) {

            if (audio.readyState >= 1) {
                audio.currentTime = position;

                return;
            }

            audio.addEventListener('loadedmetadata', function () {
                audio.currentTime = position;
            }, { once: true });

        }

        function play() {

            setUpGain();

            if (audioContext && audioContext.state === 'suspended') {
                audioContext.resume();
            }

            return audio.play();

        }

        function playOnFirstTap() {

            const unlock = function () {
                document.removeEventListener('pointerdown', unlock, true);
                document.removeEventListener('keydown', unlock, true);

                play().catch(function () {});
            };

            document.addEventListener('pointerdown', unlock, true);
            document.addEventListener('keydown', unlock, true);

        }

        /*
         * Browsers block sound until the guest touches the screen,
         * so if playing is refused, try again on the first tap.
         */
        function playWhenAllowed() {

            play()
                .then(function () {
                    if (audioContext && audioContext.state === 'suspended') {
                        playOnFirstTap();
                    }
                })
                .catch(playOnFirstTap);

        }

        function startMood() {

            timers.forEach(clearTimeout);
            timers = [];

            setUpGain();

            if (mood === 'result') {
                seekTo(0);
                fadeTo('duck', 0);
                playWhenAllowed();

                later(4, function () {
                    fadeTo('normal', 3);
                });

                return;
            }

            const state = isReload() ? null : readState();

            const wasPlaying = state !== null && state.level > 0;

            if (state !== null) {
                seekTo(state.position);
            }

            /*
             * Pick up at the volume the last page left off at, so
             * moving between pages sounds like one song.
             */
            fadeTo(wasPlaying ? state.level : 'silent', 0);

            if (mood === 'welcome' && !wasPlaying) {
                later(3, function () {
                    playWhenAllowed();
                    fadeTo('normal', 5);
                });

                return;
            }

            playWhenAllowed();

            if (mood === 'soft') {
                fadeTo('soft', 1);
            } else if (mood === 'generate') {
                fadeTo('soft', 1);
                later(3, function () {
                    fadeTo('generate', 2);
                });
            } else {
                fadeTo('normal', 1);
            }

        }

        startMood();

        window.addEventListener('pagehide', saveState);

        /*
         * Coming back with the Back button restores this page from
         * the browser cache with the music paused; start it again.
         */
        window.addEventListener('pageshow', function (event) {

            if (event.persisted) {
                audio.play().catch(playOnFirstTap);
            }

        });

        return { fadeTo: fadeTo, duckForVoice: duckForVoice };

    })();

</script>
