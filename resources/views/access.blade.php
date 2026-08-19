<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>RUPAVUE — Choose Access</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #050505;
            color: white;

            font-family:
                Arial,
                Helvetica,
                sans-serif;
        }

        .access-page {
            width: min(900px, calc(100% - 40px));
            text-align: center;
        }

        .logo {
            font-size: 14px;
            letter-spacing: 0.18em;
            margin-bottom: 70px;
        }

        .label {
            color: #777;
            font-size: 9px;
            letter-spacing: 0.15em;
            margin-bottom: 15px;
        }

        h1 {
            margin: 0;
            font-size: clamp(32px, 6vw, 60px);
            font-weight: 300;
        }

        .options {
            margin-top: 60px;

            display: grid;
            grid-template-columns: 1fr 1fr;

            gap: 12px;
        }

        .option {
            min-height: 220px;

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

            background: #111;

            border: 1px solid #222;

            color: white;

            transition: 0.25s ease;
        }

        .option:hover {
            background: #181818;
            border-color: #555;
            transform: translateY(-4px);
        }

        .option-icon {
            font-size: 30px;
            margin-bottom: 25px;
        }

        .option-title {
            font-size: 18px;
            letter-spacing: 0.08em;
        }

        .option-description {
            margin-top: 10px;

            color: #666;

            font-size: 9px;
            letter-spacing: 0.05em;
        }

        .guest:hover .option-icon {
            color: #8b5cf6;
        }

        .admin:hover .option-icon {
            color: #8b5cf6;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 10px;

            margin-top: 45px;

            color: #777;

            font-size: 9px;
            letter-spacing: 0.1em;

            transition: 0.25s ease;
        }

        .back-button:hover {
            color: #fff;
            transform: translateX(-4px);
        }

        .back-arrow {
            width: 28px;
            height: 28px;

            display: flex;
            align-items: center;
            justify-content: center;

            border: 1px solid #333;
            border-radius: 50%;

            font-size: 12px;

            transition: 0.25s ease;
        }

        .back-button:hover .back-arrow {
            border-color: #666;
        }

        }
    </style>

</head>

<body>

<div class="access-page">

    <div class="logo">
        RUPAVUE
    </div>


    <div class="label">
        WELCOME
    </div>


    <h1>
        CHOOSE YOUR ACCESS
    </h1>


    <div class="options">

        <!-- GUEST -->

        <a
            href="{{ route('photobooth.create') }}"
            class="option guest"
        >

            <div class="option-icon">
                ◯
            </div>

            <div class="option-title">
                GUEST
            </div>

            <div class="option-description">
                START YOUR AI PHOTOBOOTH EXPERIENCE
            </div>

        </a>


        <!-- ADMIN -->

        <a
            href="#"
            class="option admin"
            onclick="alert('Admin login will be available soon.'); return false;"
        >

            <div class="option-icon">
                ◇
            </div>

            <div class="option-title">
                ADMIN
            </div>

            <div class="option-description">
                ADMINISTRATION & MANAGEMENT
            </div>

        </a>

    </div>


    <a
        href="{{ url('/') }}"
        class="back-button"
    >
        <span class="back-arrow">←</span>
        <span>BACK</span>
    </a>

</div>

</body>

</html>