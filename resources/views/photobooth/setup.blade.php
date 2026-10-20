<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

        .setup-empty-message {

            grid-column: 1 / -1;

            color: rgba(218, 237, 255, 0.75);

            font-family: Arial, Helvetica, sans-serif;

            font-size: 14px;

            line-height: 1.6;

            padding: 20px 0;

        }

        .setup-actions {

            display: flex;

            gap: 12px;

            width: 100%;

        }

        .setup-actions .setup-button {

            min-width: 0;

        }

        @media (max-width: 480px) {

            .setup-actions {

                flex-direction: column;

            }

            .setup-actions .setup-button {

                width: 100%;

            }

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

        .drive-panel {

            margin-top: 32px;

            padding-top: 24px;

            border-top: 1px solid rgba(90, 170, 255, 0.25);

            font-family: Arial, Helvetica, sans-serif;

        }

        .drive-panel-header {

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 12px;

        }

        .drive-panel h2 {

            color: #8fd0ff;

            font-family: "Arial Black", Arial, Helvetica, sans-serif;

            font-size: 13px;

            letter-spacing: 0.12em;

        }

        .drive-status {

            padding: 4px 12px;

            border-radius: 999px;

            font-weight: bold;

            font-size: 13px;

        }

        .drive-status.is-connected {

            background: rgba(40, 200, 120, 0.18);

            color: #6ff0a8;

        }

        .drive-status.is-disconnected {

            background: rgba(255, 90, 90, 0.18);

            color: #ff9a9a;

        }

        .drive-alert {

            margin-top: 14px;

            padding: 10px 14px;

            border-radius: 14px;

            font-size: 14px;

        }

        .drive-alert.is-success {

            background: rgba(40, 200, 120, 0.15);

            color: #6ff0a8;

        }

        .drive-alert.is-error {

            background: rgba(255, 90, 90, 0.15);

            color: #ff9a9a;

        }

        .drive-text,

        .drive-timer {

            margin-top: 14px;

            color: rgba(218, 237, 255, 0.75);

            font-size: 14px;

            line-height: 1.5;

        }

        .drive-timer-remaining {

            color: #6ff0a8;

            font-variant-numeric: tabular-nums;

        }

        .drive-timer.is-soon .drive-timer-remaining {

            color: #ffd27a;

        }

        .drive-timer.is-expired {

            color: #ff9a9a;

        }

        .drive-timer-date {

            display: block;

            color: rgba(218, 237, 255, 0.5);

            font-size: 13px;

        }

        .drive-button {

            display: inline-block;

            margin-top: 16px;

            padding: 12px 24px;

            border-radius: 999px;

            border: 1px solid rgba(90, 170, 255, 0.6);

            background: rgba(58, 168, 255, 0.12);

            color: #ffffff;

            font-family: "Arial Black", Arial, Helvetica, sans-serif;

            font-size: 13px;

            letter-spacing: 0.08em;

            text-decoration: none;

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

        {{-- Setup supports a tested remote database or the existing local database. --}}

        <form method="POST" action="{{ route('setup.complete') }}" id="setupForm">

            @csrf

            <!-- STEP 1: IP ADDRESS -->

            <section

                class="setup-step {{ $errors->has('occasion_id') ? '' : 'active' }}"

                id="stepIpAddress"

            >

                <h1>Connect Device</h1>

                <p>Enter the IP address to get started.</p>

                <label class="setup-label" for="ipAddress">IP ADDRESS</label>

                <input

                    type="text"

                    id="ipAddress"

                    name="ip_address"

                    class="setup-input"

                    placeholder="e.g. 192.168.1.10"

                    inputmode="decimal"

                    autocomplete="off"

                    value="{{ old('ip_address', session('setup.ip_address')) }}"

                    required>

                <label class="setup-label" for="remotePort" style="margin-top: 18px;">MYSQL PORT</label>
                <input type="number" id="remotePort" name="remote_port" class="setup-input" value="3306" min="1" max="65535" required>

                <label class="setup-label" for="remoteDatabase" style="margin-top: 18px;">REMOTE DATABASE NAME</label>
                <input type="text" id="remoteDatabase" name="remote_database" class="setup-input" value="rupavue_db_10" maxlength="64" autocomplete="off" required>

                <label class="setup-label" for="remoteUsername" style="margin-top: 18px;">REMOTE MYSQL USERNAME</label>
                <input type="text" id="remoteUsername" name="remote_username" class="setup-input" placeholder="Enter remote MySQL username" maxlength="128" autocomplete="username" required>

                <label class="setup-label" for="remotePassword" style="margin-top: 18px;">REMOTE MYSQL PASSWORD</label>
                <input type="password" id="remotePassword" name="remote_password" class="setup-input" placeholder="Enter remote MySQL password" maxlength="255" autocomplete="new-password" required>

                <input type="hidden" name="connection_mode" id="connectionMode" value="remote">

                <div class="setup-error" id="ipAddressError" role="alert"></div>
                <div class="setup-error" id="remoteConnectionMessage" role="status" aria-live="polite"></div>

                <div class="setup-actions">

                    <button type="button" class="setup-button setup-button-primary" id="ipNextButton">
                        TEST &amp; CONNECT →
                    </button>
                    <button type="button" class="setup-button setup-button-secondary" id="useLocalDatabaseButton">
                        USE LOCAL DATABASE
                    </button>

                </div>

            </section>

            <!-- STEP 2: EVENT OPTIONS -->

            <section

                class="setup-step {{ $errors->has('occasion_id') ? 'active' : '' }}"

                id="stepEvent"

            >

                <h1>Choose Event</h1>

                <p>Select the event for this photo booth.</p>

            <div class="event-options" role="radiogroup" aria-label="Event options">

                @forelse ($occasions as $occasion)

                    <button

                        type="button"

                        class="event-option"

                        data-event="{{ $occasion->id }}"

                        role="radio"

                        aria-checked="false"

                    >

                        <span class="event-option-icon">✨</span>

                        {{ strtoupper($occasion->occasion_name) }}

                    </button>

                @empty

                    <p class="setup-empty-message">

                        No active occasions are available.

                        Please activate an occasion in the admin website.

                    </p>

                @endforelse

            </div>

            <input

                type="hidden"

                name="occasion_id"

                id="selectedOccasionId"

                value="{{ old('occasion_id', session('setup.occasion_id')) }}"

            >

            @if ($errors->any())

                <div class="setup-error" role="alert">

                    {{ $errors->first() }}

                </div>

            @endif

        <div class="setup-actions">

            <button

                type="button"

                class="setup-button setup-button-secondary"

                id="eventBackButton"

            >

                ← BACK

            </button>

            <button

                type="submit"

                class="setup-button setup-button-primary"

                id="eventContinueButton"

                disabled

            >

                CONTINUE →

            </button>

        </div>

            </section>

        </form>

        <!-- GOOGLE DRIVE CONNECTION -->

        <section class="drive-panel" aria-labelledby="drivePanelTitle">

            <div class="drive-panel-header">

                <h2 id="drivePanelTitle">GOOGLE DRIVE</h2>

                @if ($isDriveConnected)

                    <span class="drive-status is-connected">Connected</span>

                @else

                    <span class="drive-status is-disconnected">Not connected</span>

                @endif

            </div>

            @if ($driveResult)

                <p class="drive-alert is-{{ $driveResult['type'] }}">{{ $driveResult['message'] }}</p>

            @endif

            @if ($driveReconnectDeadline)

                @include('google-drive.partials.reconnect-timer', ['deadline' => $driveReconnectDeadline])

            @endif

            @if ($usesSharedDriveToken)

                <p class="drive-text">Using the RupaVue admin site's Google connection. Reconnect Google from the admin site.</p>

            @else

                <a class="drive-button" href="{{ route('google-drive.connect', ['from' => 'setup']) }}">

                    {{ $isDriveConnected ? 'RECONNECT GOOGLE DRIVE' : 'CONNECT GOOGLE DRIVE' }}

                </a>

            @endif

        </section>

    </main>

    <script>

        const stepIpAddress = document.getElementById('stepIpAddress');
        const stepEvent = document.getElementById('stepEvent');
        const stepDotOne = document.getElementById('stepDotOne');
        const stepDotTwo = document.getElementById('stepDotTwo');
        const ipAddressInput = document.getElementById('ipAddress');
        const ipAddressError = document.getElementById('ipAddressError');
        const remoteConnectionMessage = document.getElementById('remoteConnectionMessage');
        const eventOptionsContainer = document.querySelector('.event-options');
        const localOccasionsHtml = eventOptionsContainer.innerHTML;
        const eventContinueButton = document.getElementById('eventContinueButton');
        const selectedOccasionId = document.getElementById('selectedOccasionId');
        const setupForm = document.getElementById('setupForm');
        const connectionMode = document.getElementById('connectionMode');
        const ipNextButton = document.getElementById('ipNextButton');
        const localButton = document.getElementById('useLocalDatabaseButton');

        function isValidIpAddress(value) {
            const parts = value.trim().split('.');
            if (parts.length !== 4) return false;
            if (!parts.every(function (part) {
                return /^\d{1,3}$/.test(part) && Number(part) >= 0 && Number(part) <= 255;
            })) return false;
            return parts.some(function (part) { return Number(part) !== 0; });
        }

        function showStep(step) {
            const isEventStep = step === stepEvent;
            stepIpAddress.classList.toggle('active', !isEventStep);
            stepEvent.classList.toggle('active', isEventStep);
            stepDotOne.classList.toggle('active', !isEventStep);
            stepDotTwo.classList.toggle('active', isEventStep);
        }

        function selectOccasion(occasionId) {
            let found = false;
            eventOptionsContainer.querySelectorAll('.event-option').forEach(function (option) {
                const selected = option.dataset.event === String(occasionId);
                option.classList.toggle('selected', selected);
                option.setAttribute('aria-checked', selected ? 'true' : 'false');
                if (selected) found = true;
            });
            selectedOccasionId.value = found ? String(occasionId) : '';
            eventContinueButton.disabled = !found;
        }

        eventOptionsContainer.addEventListener('click', function (event) {
            const option = event.target.closest('.event-option');
            if (!option) return;
            selectOccasion(option.dataset.event);
        });

        async function testRemoteConnection() {
            const ip = ipAddressInput.value.trim();
            if (!isValidIpAddress(ip)) {
                ipAddressError.textContent = 'Enter a valid IPv4 address, e.g. 192.168.1.10.';
                ipAddressInput.focus();
                return;
            }
            ipAddressError.textContent = '';
            remoteConnectionMessage.textContent = 'Testing remote MySQL connection...';
            ipNextButton.disabled = true;
            selectedOccasionId.value = '';
            eventContinueButton.disabled = true;

            const payload = {
                ip_address: ip,
                remote_port: document.getElementById('remotePort').value,
                remote_database: document.getElementById('remoteDatabase').value.trim(),
                remote_username: document.getElementById('remoteUsername').value.trim(),
                remote_password: document.getElementById('remotePassword').value
            };

            try {
                const response = await fetch(@json(route('setup.testRemote')), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(payload)
                });
                const result = await response.json();
                if (!response.ok || !result.success) throw new Error(result.message || 'Connection failed.');

                eventOptionsContainer.replaceChildren();
                result.occasions.forEach(function (occasion) {
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.className = 'event-option';
                    button.dataset.event = occasion.id;
                    button.setAttribute('role', 'radio');
                    button.setAttribute('aria-checked', 'false');
                    const icon = document.createElement('span');
                    icon.className = 'event-option-icon';
                    icon.textContent = '✨';
                    button.appendChild(icon);
                    button.appendChild(document.createTextNode(String(occasion.occasion_name).toUpperCase()));
                    eventOptionsContainer.appendChild(button);
                });
                connectionMode.value = 'remote';
                remoteConnectionMessage.textContent = result.message + ' Select an occasion to continue.';
                showStep(stepEvent);
            } catch (error) {
                remoteConnectionMessage.textContent = error.message || 'Unable to connect to the remote database.';
            } finally {
                ipNextButton.disabled = false;
            }
        }

        ipNextButton.addEventListener('click', testRemoteConnection);
        ipAddressInput.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                testRemoteConnection();
            }
        });

        localButton.addEventListener('click', function () {
            connectionMode.value = 'local';
            eventOptionsContainer.innerHTML = localOccasionsHtml;
            selectedOccasionId.value = '';
            eventContinueButton.disabled = true;
            remoteConnectionMessage.textContent = 'Using the local database configured in your .env file.';
            ipAddressInput.required = false;
            document.getElementById('remotePort').required = false;
            document.getElementById('remoteDatabase').required = false;
            document.getElementById('remoteUsername').required = false;
            document.getElementById('remotePassword').required = false;
            // The occasions initially rendered by Blade are from the local database.
            showStep(stepEvent);
        });

        document.getElementById('eventBackButton').addEventListener('click', function () {
            showStep(stepIpAddress);
        });

        if (selectedOccasionId.value) selectOccasion(selectedOccasionId.value);

        setupForm.addEventListener('submit', function (event) {
            if (!selectedOccasionId.value) {
                event.preventDefault();
                eventContinueButton.disabled = true;
                remoteConnectionMessage.textContent = 'Please select an occasion before continuing.';
            }
        });
    </script>

</body>

</html>