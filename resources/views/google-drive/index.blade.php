<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1">

    <title>RUPAVUE — Google Drive</title>

    <style>
        /* =========================================================
           RUPAVUE — GOOGLE DRIVE CONNECTION
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

            font-family: Arial, Helvetica, sans-serif;

            -webkit-font-smoothing: antialiased;
        }

        .drive-card {
            width: min(100%, 560px);

            padding: 40px 36px;

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

        .drive-brand {
            color: #5fb4ff;

            font-family: "Arial Black", Arial, Helvetica, sans-serif;
            font-size: 14px;
            letter-spacing: 4px;
        }

        .drive-title {
            margin-top: 10px;

            font-family: "Arial Black", Arial, Helvetica, sans-serif;
            font-size: 28px;
        }

        .drive-status {
            display: inline-block;

            margin-top: 20px;
            padding: 8px 18px;

            border-radius: 999px;

            font-weight: bold;
            font-size: 14px;
        }

        .drive-status.is-connected {
            background: rgba(40, 200, 120, 0.18);
            color: #6ff0a8;
        }

        .drive-status.is-disconnected {
            background: rgba(255, 90, 90, 0.18);
            color: #ff9a9a;
        }

        .drive-text {
            margin-top: 18px;

            color: rgba(255, 255, 255, 0.8);

            font-size: 15px;
            line-height: 1.5;
        }

        .drive-alert {
            margin-top: 20px;
            padding: 12px 16px;

            border-radius: 14px;

            font-size: 14px;
            line-height: 1.4;
        }

        .drive-alert.is-success {
            background: rgba(40, 200, 120, 0.15);
            color: #6ff0a8;
        }

        .drive-alert.is-error {
            background: rgba(255, 90, 90, 0.15);
            color: #ff9a9a;
        }

        .drive-button {
            display: inline-block;

            margin-top: 28px;
            padding: 16px 32px;

            border-radius: 999px;

            background: linear-gradient(135deg, #1f7bff, #0b4fd1);

            color: #ffffff;

            font-family: "Arial Black", Arial, Helvetica, sans-serif;
            font-size: 15px;
            letter-spacing: 1px;
            text-decoration: none;

            box-shadow: 0 0 24px rgba(0, 120, 255, 0.4);
        }

        .drive-back {
            display: block;

            margin-top: 20px;

            color: rgba(255, 255, 255, 0.6);

            font-size: 14px;
        }
    </style>
</head>

<body>
    <main class="drive-card">
        <p class="drive-brand">RUPAVUE</p>

        <h1 class="drive-title">Google Drive</h1>

        @if ($isConnected)
            <span class="drive-status is-connected">Connected</span>
        @else
            <span class="drive-status is-disconnected">Not connected</span>
        @endif

        @if ($result)
            <p class="drive-alert is-{{ $result['type'] }}">{{ $result['message'] }}</p>
        @endif

        @if ($folder)
            <p class="drive-text">Generated photos are saved to the <strong>{{ $folder['name'] }}</strong> folder.</p>
        @elseif ($folderError)
            <p class="drive-alert is-error">{{ $folderError }}</p>
        @endif

        @if ($usesSharedToken)
            <p class="drive-text">
                The photobooth is using the RupaVue admin site's Google connection
                (GOOGLE_DRIVE_TOKEN_PATH). Reconnect Google from the admin site, or
                remove GOOGLE_DRIVE_TOKEN_PATH from .env to connect here instead.
            </p>
        @else
            <p class="drive-text">
                Keep <strong>php artisan serve</strong> running while connecting, so
                Google can send you back to {{ config('services.google_drive.redirect_uri') }}.
            </p>

            <a class="drive-button" href="{{ route('google-drive.connect') }}">
                {{ $isConnected ? 'RECONNECT GOOGLE DRIVE' : 'CONNECT GOOGLE DRIVE' }}
            </a>
        @endif

        <a class="drive-back" href="{{ route('home') }}">Back to the photobooth</a>
    </main>
</body>

</html>
