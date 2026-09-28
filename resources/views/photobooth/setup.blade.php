<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1">

    <title>RUPAVUE — Setup</title>

    <style>
        /* =========================================================
           RUPAVUE — FIRST-TIME SETUP
           Shown once, before the welcome page.
           ========================================================= */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 24px 16px;

            background:
                radial-gradient(
                    circle at 50% 45%,
                    rgba(7, 58, 145, 0.28) 0%,
                    rgba(3, 25, 63, 0.42) 28%,
                    rgba(1, 8, 23, 0.85) 65%,
                    #010611 100%
                ),
                linear-gradient(
                    135deg,
                    #010611 0%,
                    #02122f 45%,
                    #010816 100%
                );

            color: #ffffff;

            font-family: "Arial Black", Arial, Helvetica, sans-serif;

            -webkit-font-smoothing: antialiased;
        }

        .setup-card {
            width: min(100%, 640px);

            padding: 48px 44px;

            border-radius: 28px;

            border: 1px solid rgba(90, 170, 255, 0.45);

            background:
                linear-gradient(
                    145deg,
                    rgba(10, 45, 115, 0.55),
                    rgba(4, 20, 58, 0.75)
                );

            box-shadow:
                0 0 40px rgba(0, 120, 255, 0.25),
                0 24px 60px rgba(0, 0, 0, 0.5);

            text-align: center;
        }

        .setup-brand {
            color: #5fb4ff;

            font-size: 14px;
            letter-spacing: 0.35em;

            margin-bottom: 14px;
        }

        .setup-steps {
            display: flex;
            justify-content: center;
            gap: 10px;

            margin-bottom: 28px;
        }

        .setup-step-dot {
            width: 36px;
            height: 6px;

            border-radius: 999px;

            background: rgba(255, 255, 255, 0.2);

            transition: background 0.3s ease;
        }

        .setup-step-dot.active {
            background: #3aa8ff;

            box-shadow: 0 0 12px rgba(58, 168, 255, 0.8);
        }

        .setup-step {
            display: none;
        }

        .setup-step.active {
            display: block;

            animation: stepIn 0.4s ease both;
        }

        @keyframes stepIn {
            from {
                opacity: 0;
                translate: 0 12px;
            }

            to {
                opacity: 1;
                translate: 0 0;
            }
        }

        .setup-step h1 {
            font-size: clamp(28px, 5vw, 40px);

            margin-bottom: 10px;

            text-shadow: 0 0 24px rgba(30, 140, 255, 0.55);
        }

        .setup-step p {
            color: rgba(218, 237, 255, 0.75);

            font-family: Arial, Helvetica, sans-serif;
            font-size: 17px;

            margin-bottom: 28px;
        }

        .setup-label {
            display: block;

            text-align: left;

            font-size: 13px;
            letter-spacing: 0.12em;

            color: #8fd0ff;

            margin-bottom: 8px;
        }

        .setup-input {
            width: 100%;

            padding: 18px 20px;

            border-radius: 16px;

            border: 1px solid rgba(90, 170, 255, 0.5);

            background: rgba(1, 8, 23, 0.6);

            color: #ffffff;

            font-family: Arial, Helvetica, sans-serif;
            font-size: 20px;
            letter-spacing: 0.04em;

            outline: none;

            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .setup-input::placeholder {
            color: rgba(218, 237, 255, 0.35);
        }

        .setup-input:focus {
            border-color: #3aa8ff;

            box-shadow: 0 0 0 4px rgba(58, 168, 255, 0.2);
        }

        .setup-error {
            min-height: 22px;

            margin-top: 8px;

            text-align: left;

            color: #ff8f8f;

            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
        }

        .event-options {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;

            margin-bottom: 28px;
        }

        .event-option {
            padding: 22px 16px;

            border-radius: 18px;

            border: 1px solid rgba(90, 170, 255, 0.35);

            background: rgba(255, 255, 255, 0.05);

            color: #ffffff;

            font-family: inherit;
            font-size: 16px;
            letter-spacing: 0.04em;

            cursor: pointer;

            transition:
                border-color 0.2s ease,
                background 0.2s ease,
                transform 0.2s ease;
        }

        .event-option-icon {
            display: block;

            font-size: 30px;

            margin-bottom: 8px;
        }

        .event-option:hover {
            transform: translateY(-2px);

            border-color: rgba(90, 170, 255, 0.8);
        }

        .event-option.selected {
            border-color: #3aa8ff;

            background: rgba(58, 168, 255, 0.18);

            box-shadow: 0 0 20px rgba(58, 168, 255, 0.45);
        }

        .setup-actions {
            display: flex;
            gap: 12px;
        }

        .setup-button {
            flex: 1;

            padding: 18px 24px;

            border-radius: 999px;

            border: none;

            font-family: inherit;
            font-size: 17px;
            letter-spacing: 0.08em;

            cursor: pointer;

            transition: transform 0.2s ease, opacity 0.2s ease;
        }

        .setup-button-primary {
            background: linear-gradient(135deg, #1a8fff, #0052c7);

            color: #ffffff;

            box-shadow: 0 0 24px rgba(20, 140, 255, 0.5);
        }

        .setup-button-secondary {
            flex: 0 0 auto;

            background: rgba(255, 255, 255, 0.08);

            border: 1px solid rgba(255, 255, 255, 0.3);

            color: #ffffff;
        }

        .setup-button:not(:disabled):hover {
            transform: translateY(-2px);
        }

        .setup-button:disabled {
            opacity: 0.4;

            cursor: not-allowed;
        }

        @media (max-width: 480px) {
            .setup-card {
                padding: 36px 20px;
            }

            .event-options {
                grid-template-columns: 1fr;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .setup-step.active {
                animation: none;
            }
        }
    </style>
</head>

<body>

    <main class="setup-card">

        <div class="setup-brand">RUPAVUE SETUP</div>

        <div class="setup-steps" aria-hidden="true">
            <span class="setup-step-dot active" id="stepDotOne"></span>
            <span class="setup-step-dot" id="stepDotTwo"></span>
        </div>

        {{-- The IP address and event are not used yet; this page only completes setup. --}}
        <form method="POST" action="{{ route('setup.complete') }}" id="setupForm">
            @csrf

            <!-- STEP 1: IP ADDRESS -->

            <section class="setup-step active" id="stepIpAddress">

                <h1>Connect Device</h1>

                <p>Enter the IP address to get started.</p>

                <label class="setup-label" for="ipAddress">IP ADDRESS</label>

                <input
                    type="text"
                    id="ipAddress"
                    class="setup-input"
                    placeholder="e.g. 192.168.1.10"
                    inputmode="decimal"
                    autocomplete="off"
                    required
                >

                <div class="setup-error" id="ipAddressError" role="alert"></div>

                <div class="setup-actions">
                    <button type="button" class="setup-button setup-button-primary" id="ipNextButton">
                        NEXT →
                    </button>
                </div>

            </section>

            <!-- STEP 2: EVENT OPTIONS -->

            <section class="setup-step" id="stepEvent">

                <h1>Choose Event</h1>

                <p>Select the event for this photo booth.</p>

                <div class="event-options" role="radiogroup" aria-label="Event options">
                    <button type="button" class="event-option" data-event="wedding" role="radio" aria-checked="false">
                        <span class="event-option-icon">💍</span>
                        WEDDING
                    </button>

                    <button type="button" class="event-option" data-event="corporate" role="radio" aria-checked="false">
                        <span class="event-option-icon">🏢</span>
                        CORPORATE
                    </button>

                    <button type="button" class="event-option" data-event="birthday" role="radio" aria-checked="false">
                        <span class="event-option-icon">🎂</span>
                        BIRTHDAY
                    </button>

                    <button type="button" class="event-option" data-event="exhibition" role="radio" aria-checked="false">
                        <span class="event-option-icon">🎪</span>
                        EXHIBITION
                    </button>
                </div>

                <div class="setup-actions">
                    <button type="button" class="setup-button setup-button-secondary" id="eventBackButton">
                        ← BACK
                    </button>

                    <button type="submit" class="setup-button setup-button-primary" id="eventContinueButton" disabled>
                        CONTINUE →
                    </button>
                </div>

            </section>

        </form>

    </main>

    <script>

        const stepIpAddress = document.getElementById('stepIpAddress');
        const stepEvent = document.getElementById('stepEvent');
        const stepDotTwo = document.getElementById('stepDotTwo');

        const ipAddressInput = document.getElementById('ipAddress');
        const ipAddressError = document.getElementById('ipAddressError');

        const eventOptions = document.querySelectorAll('.event-option');
        const eventContinueButton = document.getElementById('eventContinueButton');

        /*
         * Four numbers from 0 to 255 separated by dots.
         */
        function isValidIpAddress(value) {
            const parts = value.split('.');

            return parts.length === 4
                && parts.every(function (part) {
                    return /^\d{1,3}$/.test(part) && Number(part) <= 255;
                });
        }

        function showStep(step) {
            const isEventStep = step === stepEvent;

            stepIpAddress.classList.toggle('active', !isEventStep);
            stepEvent.classList.toggle('active', isEventStep);
            stepDotTwo.classList.toggle('active', isEventStep);
        }

        document.getElementById('ipNextButton').addEventListener('click', function () {
            const ipAddress = ipAddressInput.value.trim();

            if (!isValidIpAddress(ipAddress)) {
                ipAddressError.textContent = 'Please enter a valid IP address, e.g. 192.168.1.10';
                ipAddressInput.focus();

                return;
            }

            ipAddressError.textContent = '';

            showStep(stepEvent);
        });

        ipAddressInput.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();

                document.getElementById('ipNextButton').click();
            }
        });

        document.getElementById('eventBackButton').addEventListener('click', function () {
            showStep(stepIpAddress);
        });

        eventOptions.forEach(function (option) {
            option.addEventListener('click', function () {
                eventOptions.forEach(function (item) {
                    const isSelected = item === option;

                    item.classList.toggle('selected', isSelected);
                    item.setAttribute('aria-checked', isSelected ? 'true' : 'false');
                });

                eventContinueButton.disabled = false;
            });
        });

    </script>

</body>

</html>
