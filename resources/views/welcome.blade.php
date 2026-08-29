<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>RupaVue - AI Photo Booth</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            height: 100%;
            overflow: hidden;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background: #111;
        }

        .welcome-container {
            position: relative;
            width: 100%;
            height: 100vh;

            /*
             * TEMPORARY BACKGROUND
             * Replace this later with your actual background image.
             */
            background:
                linear-gradient(
                    rgba(0, 0, 0, 0.35),
                    rgba(0, 0, 0, 0.55)
                ),
                url('/images/demo-background.jpg');

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        /*
         * Dark overlay
         */
        .overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.15);
            z-index: 1;
        }

        /*
         * Main content
         */
        .content {
            position: relative;
            z-index: 2;

            width: 90%;
            max-width: 1100px;

            text-align: center;
            color: white;

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        /*
         * Logo / Brand
         */
        .logo {
            font-size: clamp(40px, 7vw, 90px);
            font-weight: 800;
            letter-spacing: 8px;
            text-transform: uppercase;

            margin-bottom: 18px;

            text-shadow:
                0 4px 20px rgba(0, 0, 0, 0.5);
        }

        /*
         * Subtitle
         */
        .subtitle {
            font-size: clamp(16px, 2vw, 26px);
            font-weight: 400;
            letter-spacing: 4px;
            text-transform: uppercase;

            margin-bottom: 55px;

            text-shadow:
                0 2px 10px rgba(0, 0, 0, 0.6);
        }

        /*
         * Main title
         */
        .welcome-title {
            font-size: clamp(25px, 4vw, 50px);
            font-weight: 700;

            margin-bottom: 15px;

            text-shadow:
                0 3px 15px rgba(0, 0, 0, 0.6);
        }

        /*
         * Description
         */
        .description {
            max-width: 650px;

            font-size: clamp(14px, 1.5vw, 19px);
            line-height: 1.6;

            color: rgba(255, 255, 255, 0.9);

            margin-bottom: 40px;
        }

        /*
         * Start button
         */
        .start-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            min-width: 230px;
            padding: 17px 35px;

            border: 2px solid rgba(255, 255, 255, 0.9);
            border-radius: 50px;

            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);

            color: white;

            font-size: 16px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;

            text-decoration: none;

            cursor: pointer;

            transition:
                background 0.25s ease,
                transform 0.25s ease,
                box-shadow 0.25s ease;
        }

        .start-button:hover {
            background: white;
            color: #111;

            transform: translateY(-3px);

            box-shadow:
                0 12px 35px rgba(0, 0, 0, 0.35);
        }

        .start-button:active {
            transform: translateY(0);
        }

        /*
         * Small camera icon
         */
        .camera-icon {
            margin-left: 12px;
            font-size: 20px;
        }

        /*
         * Bottom branding
         */
        .bottom-text {
            position: absolute;
            bottom: 25px;
            left: 50%;

            transform: translateX(-50%);

            z-index: 2;

            color: rgba(255, 255, 255, 0.7);

            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;

            white-space: nowrap;
        }

        /*
         * Tablet
         */
        @media (max-width: 768px) {

            .logo {
                letter-spacing: 5px;
            }

            .subtitle {
                letter-spacing: 2px;
                margin-bottom: 40px;
            }

            .description {
                max-width: 500px;
            }

            .start-button {
                min-width: 200px;
                padding: 15px 28px;
            }
        }

        /*
         * Mobile
         */
        @media (max-width: 480px) {

            .content {
                width: 88%;
            }

            .logo {
                letter-spacing: 3px;
                margin-bottom: 10px;
            }

            .subtitle {
                font-size: 13px;
                margin-bottom: 35px;
            }

            .welcome-title {
                font-size: 25px;
            }

            .description {
                font-size: 14px;
                margin-bottom: 30px;
            }

            .start-button {
                width: 100%;
                max-width: 280px;
            }

            .bottom-text {
                font-size: 9px;
                letter-spacing: 1px;
            }
        }
    </style>
</head>

<body>

    <div class="welcome-container">

        <div class="overlay"></div>

        <main class="content">

            <div class="logo">
                RUPAVUE
            </div>

            <div class="subtitle">
                AI PHOTO EXPERIENCE
            </div>

            <h1 class="welcome-title">
                Welcome to RupaVue
            </h1>

            <p class="description">
                Transform your photo into a unique AI-powered experience.
                Choose your theme, strike a pose, and let RupaVue create
                your perfect photo.
            </p>

            <a href="{{ route('photobooth.scene') }}" class="start-button">
                Start Session

                <span class="camera-icon">
                    📷
                </span>
            </a>

        </main>

        <div class="bottom-text">
            AI Powered Photo Booth
        </div>

    </div>

</body>
</html>