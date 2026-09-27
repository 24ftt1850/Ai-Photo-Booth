<script>

    /*
     * =========================
     * BUTTON CLICK SOUND
     * =========================
     *
     * Short "tap" synthesised with the Web Audio API,
     * shared by every next / continue button in the
     * photobooth flow. goTo() waits briefly before
     * navigating so the sound is not cut off.
     */

    window.rupavueClickSound = (function () {

        let audioContext = null;

        function play() {

            const AudioContextClass =
                window.AudioContext
                || window.webkitAudioContext;

            if (!AudioContextClass) {
                return;
            }

            if (!audioContext) {
                audioContext = new AudioContextClass();
            }

            if (audioContext.state === 'suspended') {
                audioContext.resume();
            }

            const startTime = audioContext.currentTime;

            const oscillator = audioContext.createOscillator();
            oscillator.type = 'sine';
            oscillator.frequency.setValueAtTime(1400, startTime);
            oscillator.frequency.exponentialRampToValueAtTime(600, startTime + 0.08);

            const gain = audioContext.createGain();
            gain.gain.setValueAtTime(0.5, startTime);
            gain.gain.exponentialRampToValueAtTime(0.001, startTime + 0.1);

            oscillator
                .connect(gain)
                .connect(audioContext.destination);

            oscillator.start(startTime);
            oscillator.stop(startTime + 0.1);

        }

        function goTo(url) {

            play();

            setTimeout(function () {
                window.location.href = url;
            }, 150);

        }

        return { play: play, goTo: goTo };

    })();

</script>
