<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Capture Photo - RupaVue</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            min-height: 100%;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
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
            color: white;
        }

        /* =========================
           MAIN PAGE
        ========================= */

        .camera-page {
            position: relative;

            width: 100%;
            height: 100vh;
            height: 100dvh;

            overflow: hidden;

            padding: 20px 5%;

            display: flex;
            flex-direction: column;
        }

        /* =====================================================
           BACKGROUND
        ===================================================== */

        .rv-background {
            position: fixed;
            inset: 0;
            z-index: -10;
            overflow: hidden;
            pointer-events: none;

            background:
                radial-gradient(
                    circle at 50% 50%,
                    rgba(0, 76, 190, 0.10),
                    transparent 55%
                );
        }


        /* Large blue corner glows */

        .rv-glow {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            filter: blur(2px);
        }

        .rv-glow-one {
            width: 430px;
            height: 430px;

            top: -240px;
            left: -170px;

            background:
                radial-gradient(
                    circle,
                    rgba(0, 92, 255, 0.58) 0%,
                    rgba(0, 55, 180, 0.25) 40%,
                    transparent 72%
                );
        }

        .rv-glow-two {
            width: 500px;
            height: 500px;

            top: -250px;
            right: -220px;

            background:
                radial-gradient(
                    circle,
                    rgba(0, 115, 255, 0.55) 0%,
                    rgba(0, 58, 180, 0.24) 40%,
                    transparent 72%
                );
        }

        .rv-glow-three {
            width: 480px;
            height: 480px;

            bottom: -270px;
            left: -180px;

            background:
                radial-gradient(
                    circle,
                    rgba(35, 50, 255, 0.45) 0%,
                    rgba(0, 75, 200, 0.22) 42%,
                    transparent 72%
                );
        }

        .rv-glow-four {
            width: 500px;
            height: 500px;

            bottom: -290px;
            right: -180px;

            background:
                radial-gradient(
                    circle,
                    rgba(0, 100, 255, 0.52) 0%,
                    rgba(0, 53, 175, 0.22) 42%,
                    transparent 72%
                );
        }


        /* =====================================================
           LIQUID GLASS BACKGROUND SHAPES
        ===================================================== */

        .rv-liquid {
            position: absolute;
            border-radius: 50%;

            border: 1px solid rgba(65, 151, 255, 0.25);

            background:
                radial-gradient(
                    circle at 35% 30%,
                    rgba(39, 125, 255, 0.18),
                    rgba(5, 36, 92, 0.08) 45%,
                    transparent 72%
                );

            box-shadow:
                inset 0 0 40px rgba(40, 130, 255, 0.08),
                0 0 50px rgba(0, 90, 255, 0.07);

            backdrop-filter: blur(5px);

            animation: liquidFloat 12s ease-in-out infinite;
        }

        .rv-liquid-one {
            width: 360px;
            height: 360px;

            top: 15%;
            left: -220px;
        }

        .rv-liquid-two {
            width: 300px;
            height: 300px;

            top: 55%;
            right: -180px;

            animation-delay: -4s;
        }

        .rv-liquid-three {
            width: 220px;
            height: 220px;

            top: 32%;
            right: 10%;

            opacity: 0.22;

            animation-delay: -8s;
        }

        @keyframes liquidFloat {

            0%,
            100% {
                transform: translate3d(0, 0, 0);
            }

            50% {
                transform: translate3d(0, -25px, 0);
            }
        }


        /* =====================================================
           STAR FIELD
        ===================================================== */

        .rv-stars {
            position: absolute;
            inset: 0;
        }

        .rv-star {
            position: absolute;

            width: 2px;
            height: 2px;

            border-radius: 50%;

            background: #ffffff;

            box-shadow:
                0 0 5px rgba(100, 180, 255, 0.9);

            opacity: 0.55;

            animation: starPulse 4s ease-in-out infinite;
        }

        .rv-star:nth-child(1) {
            top: 12%;
            left: 11%;
            animation-delay: -1s;
        }

        .rv-star:nth-child(2) {
            top: 18%;
            left: 82%;
            animation-delay: -2s;
        }

        .rv-star:nth-child(3) {
            top: 28%;
            left: 6%;
            animation-delay: -3s;
        }

        .rv-star:nth-child(4) {
            top: 37%;
            left: 91%;
            animation-delay: -1.5s;
        }

        .rv-star:nth-child(5) {
            top: 48%;
            left: 15%;
            animation-delay: -2.5s;
        }

        .rv-star:nth-child(6) {
            top: 59%;
            left: 86%;
            animation-delay: -0.5s;
        }

        .rv-star:nth-child(7) {
            top: 72%;
            left: 7%;
            animation-delay: -3.5s;
        }

        .rv-star:nth-child(8) {
            top: 78%;
            left: 94%;
            animation-delay: -2s;
        }

        .rv-star:nth-child(9) {
            top: 87%;
            left: 25%;
            animation-delay: -1s;
        }

        .rv-star:nth-child(10) {
            top: 92%;
            left: 72%;
            animation-delay: -3s;
        }

        .rv-star:nth-child(11) {
            top: 9%;
            left: 48%;
            animation-delay: -2s;
        }

        .rv-star:nth-child(12) {
            top: 42%;
            left: 97%;
            animation-delay: -1s;
        }

        @keyframes starPulse {

            0%,
            100% {
                opacity: 0.25;
                transform: scale(0.8);
            }

            50% {
                opacity: 0.9;
                transform: scale(1.5);
            }
        }


        /* =====================================================
           SHOOTING STARS
        ===================================================== */

        .rv-shooting-star {
            position: absolute;
            pointer-events: none;
        }

        .rv-shooting-star span {
            display: block;

            width: 130px;
            height: 2px;

            background:
                linear-gradient(
                    90deg,
                    rgba(255, 255, 255, 0.95),
                    rgba(255, 255, 255, 0)
                );

            border-radius: 999px;

            filter: drop-shadow(0 0 4px rgba(170, 210, 255, 0.9));

            opacity: 0;

            animation: shootingStar 7s linear infinite;
        }

        .rv-shooting-star-one {
            top: 12%;
            left: 62%;

            transform: rotate(35deg);
        }

        .rv-shooting-star-one span {
            animation-delay: 0.4s;
        }

        .rv-shooting-star-two {
            top: 32%;
            left: 12%;

            transform: rotate(28deg);
        }

        .rv-shooting-star-two span {
            width: 100px;

            animation-duration: 8.5s;
            animation-delay: 3.6s;
        }

        .rv-shooting-star-three {
            top: 68%;
            left: 78%;

            transform: rotate(40deg);
        }

        .rv-shooting-star-three span {
            width: 90px;

            animation-duration: 6s;
            animation-delay: 6.2s;
        }

        .rv-shooting-star-four {
            top: 6%;
            left: 22%;

            transform: rotate(30deg);
        }

        .rv-shooting-star-four span {
            width: 110px;

            animation-duration: 9s;
            animation-delay: 2s;
        }

        @keyframes shootingStar {

            0% {
                opacity: 0;
                transform: translateX(0);
            }

            4% {
                opacity: 1;
            }

            18% {
                opacity: 0;
                transform: translateX(-320px);
            }

            100% {
                opacity: 0;
                transform: translateX(-320px);
            }
        }
        /* =========================
           TITLE
        ========================= */

        .title-section {
            text-align: center;

            margin-bottom: 10px;

            flex-shrink: 0;
        }

        .title-section h1 {
            font-size: clamp(40px, 5.2vw, 64px);

            font-weight: 800;

            letter-spacing: 0.5px;

            margin-bottom: 8px;

            color: #ffffff;

            text-shadow:
                0 0 12px rgba(255, 255, 255, 0.35),
                0 0 30px rgba(30, 140, 255, 0.55),
                0 0 60px rgba(20, 110, 255, 0.35);

            animation: titleGlow 3s ease-in-out infinite;
        }

        @keyframes titleGlow {

            0%,
            100% {
                text-shadow:
                    0 0 12px rgba(255, 255, 255, 0.35),
                    0 0 30px rgba(30, 140, 255, 0.55),
                    0 0 60px rgba(20, 110, 255, 0.35);
            }

            50% {
                text-shadow:
                    0 0 18px rgba(255, 255, 255, 0.55),
                    0 0 45px rgba(30, 140, 255, 0.8),
                    0 0 85px rgba(20, 110, 255, 0.5);
            }
        }

        .title-section p {
            font-size: 22px;

            color: rgba(255, 255, 255, 0.75);
        }

        /* =========================
           SELECTED THEME
        ========================= */

        .selected-theme {
            text-align: center;

            margin-bottom: 10px;

            flex-shrink: 0;
        }

        .selected-theme span {
            display: inline-block;

            padding: 10px 24px;

            border: 1px solid rgba(255, 255, 255, 0.25);

            border-radius: 50px;

            background: rgba(255, 255, 255, 0.08);

            font-size: 17px;

            letter-spacing: 1px;
        }

        /* =========================
           CAMERA AREA
        ========================= */

        .camera-wrapper {
            width: 100%;
            max-width: 1100px;

            margin: 0 auto;

            display: flex;
            flex-direction: column;

            align-items: center;

            flex: 1;

            min-height: 0;
        }

        /*
         * 3:2 Camera frame (landscape)
         */

        .camera-frame {
            position: relative;

            /*
             * Single explicit dimension (width) so
             * aspect-ratio always derives the other
             * one cleanly, no matter which constraint
             * (viewport height or width, minus room
             * for the side controls) ends up binding.
             */
            width:
                min(
                    calc(min(70vh, 620px) * 1.5),
                    calc(100vw - 600px),
                    950px
                );

            aspect-ratio: 3 / 2;
            max-width: 100%;
            background: #050505;
            border-radius: 24px;
            overflow: hidden;

            border: 2px solid rgba(255, 255, 255, 0.2);

            box-shadow:
                0 20px 60px rgba(0, 0, 0, 0.5);
        }

        /*
         * Video
         */

        #cameraVideo {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;

            /*
             * Mirror camera preview
             */
            transform: scaleX(-1);

            background: #050505;
        }

        /*
         * Canvas is hidden.
         * It is used to capture the actual image.
         */

        #photoCanvas {
            display: none;
        }

        /* =========================
           CAMERA PLACEHOLDER
        ========================= */

        .camera-placeholder {
            position: absolute;

            inset: 0;

            display: flex;

            flex-direction: column;

            align-items: center;
            justify-content: center;

            text-align: center;

            background: #151515;

            z-index: 2;
        }

        .camera-placeholder.hidden {
            display: none;
        }

        .camera-icon {
            font-size: 55px;

            margin-bottom: 15px;
        }

        .camera-placeholder h2 {
            font-size: 22px;

            margin-bottom: 8px;
        }

        .camera-placeholder p {
            font-size: 14px;

            color: rgba(255, 255, 255, 0.6);
        }

        /* =========================
           COUNTDOWN
        ========================= */

        .countdown {
            position: absolute;

            inset: 0;

            z-index: 5;

            display: none;

            align-items: center;
            justify-content: center;

            background: rgba(0, 0, 0, 0.25);

            pointer-events: none;
        }

        .countdown.active {
            display: flex;
        }

        .countdown-number {
            font-size: clamp(100px, 18vw, 220px);

            font-weight: 800;

            line-height: 1;

            color: white;

            text-shadow:
                0 5px 30px rgba(0, 0, 0, 0.8);

            animation: countdownPop 0.9s ease;
        }

        @keyframes countdownPop {

            0% {
                transform: scale(1.4);
                opacity: 0;
            }

            30% {
                transform: scale(1);
                opacity: 1;
            }

            80% {
                transform: scale(1);
                opacity: 1;
            }

            100% {
                transform: scale(0.85);
                opacity: 0;
            }
        }

        /* =========================
           CAMERA STATUS
        ========================= */

        .camera-status {
            margin-top: 10px;

            font-size: 20px;

            color: rgba(255, 255, 255, 0.75);

            min-height: 28px;

            text-align: center;
        }

        /* =========================
           CAPTURE ROW
        ========================= */

        .capture-row {
            width: 100%;

            display: flex;

            align-items: center;
            justify-content: center;

            flex: 1;

            min-height: 0;
        }

        /*
         * Sized to the frame alone (side-controls
         * is absolutely positioned, out of flow) so
         * the frame stays perfectly centered in the
         * row no matter what sits beside it.
         */

        .frame-holder {
            position: relative;

            min-width: 0;
        }

        /*
         * Buttons stacked to the left
         * of the camera frame.
         */

        .side-controls {
            position: absolute;

            top: 50%;
            right: 100%;
            margin-right: 50px;

            transform: translateY(-50%);

            display: flex;
            flex-direction: column;

            gap: 12px;

            width: 200px;

            flex-shrink: 0;
        }

        /*
         * Upload option, stacked to the
         * right of the camera frame.
         */

        .side-controls-right {
            position: absolute;

            top: 50%;
            left: 100%;
            margin-left: 50px;

            transform: translateY(-50%);

            display: flex;
            flex-direction: column;

            gap: 12px;

            width: 200px;

            flex-shrink: 0;
        }

        .side-button {
            display: flex;

            align-items: center;
            justify-content: center;

            text-align: center;
            text-decoration: none;

            padding: 26px 22px;

            border-radius: 18px;

            font-size: 17px;

            font-weight: 700;

            letter-spacing: 1px;

            text-transform: uppercase;

            cursor: pointer;

            transition:
                transform 0.2s ease,
                background 0.2s ease,
                color 0.2s ease,
                opacity 0.2s ease;
        }

        /*
         * Shutter button, floating inside the
         * bottom of the camera frame, centered.
         */

        .capture-button {
            position: absolute;

            left: 50%;
            bottom: 22px;
            transform: translateX(-50%);

            z-index: 6;

            width: 68px;
            height: 68px;

            min-width: 0;
            padding: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 26px;

            border-radius: 50%;
            border: 4px solid rgba(255, 255, 255, 0.85);

            background: rgba(255, 255, 255, 0.55);
            backdrop-filter: blur(4px);

            color: #111;

            box-shadow:
                0 8px 24px rgba(0, 0, 0, 0.4);

            cursor: pointer;

            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease,
                opacity 0.2s ease;
        }

        .capture-button:hover:not(:disabled) {
            transform:
                translateX(-50%)
                translateY(-3px);

            box-shadow:
                0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .capture-button:disabled {
            opacity: 0.4;

            cursor: not-allowed;
        }

        .retake-button {
            border: 2px solid rgba(255, 255, 255, 0.3);

            background: rgba(255, 255, 255, 0.08);

            color: white;

            display: none;
        }

        .retake-button:hover {
            background: white;

            color: #111;
        }

        .continue-button {
            border: 2px solid white;

            background: white;

            color: #111;

            display: none;
        }

        .continue-button:hover {
            transform: translateY(-3px);
        }

        .back-button {
            border: 2px solid rgba(255, 255, 255, 0.3);

            background: rgba(255, 255, 255, 0.08);

            color: white;
        }

        .back-button:hover {
            background: white;

            color: #111;
        }

        .upload-button {
            border: 2px solid rgba(255, 255, 255, 0.3);

            background: rgba(255, 255, 255, 0.08);

            color: white;
        }

        .upload-button:hover {
            background: white;

            color: #111;
        }

        /* =========================
           CAPTURED PHOTO
        ========================= */

        .captured-photo {
            position: absolute;

            inset: 0;

            width: 100%;
            height: 100%;

            object-fit: cover;

            display: none;

            z-index: 3;
        }

        .captured-photo.visible {
            display: block;
        }

        /* =========================
           CAMERA ERROR
        ========================= */

        .camera-error {
            display: none;

            margin-top: 20px;

            padding: 14px 20px;

            max-width: 700px;

            margin-left: auto;
            margin-right: auto;

            border-radius: 12px;

            background: rgba(180, 30, 30, 0.2);

            border: 1px solid rgba(255, 100, 100, 0.35);

            color: rgba(255, 255, 255, 0.85);

            text-align: center;

            font-size: 17px;

            line-height: 1.5;
        }

        .camera-error.visible {
            display: block;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 768px) {

            .camera-page {
                padding: 25px 20px 35px;
            }

            .title-section h1 {
                font-size: 40px;
            }

            .camera-frame {
                /*
                 * Side controls stack below the frame
                 * on mobile, so no width needs to be
                 * reserved for them here.
                 */
                width:
                    min(
                        calc(min(70vh, 620px) * 1.5),
                        92vw,
                        950px
                    );

                max-width: 100%;

                border-radius: 18px;
            }

            .capture-row {
                flex-direction: column;
            }

            .side-controls,
            .side-controls-right {
                position: static;

                top: auto;
                right: auto;
                left: auto;
                margin-right: 0;
                margin-left: 0;

                transform: none;

                order: 2;

                flex-direction: row;

                width: 100%;

                margin-top: 14px;

                justify-content: center;

                flex-wrap: wrap;
            }

            .side-button {
                flex: 1 1 auto;

                min-width: 170px;
            }
        }

        @media (max-width: 480px) {

            .title-section p {
                font-size: 16px;
            }

            .camera-frame {
                border-radius: 14px;
            }
        }

        /* =========================
           STARFIELD
        ========================= */

        .title-section,
        .selected-theme,
        .camera-wrapper,
        .back-button {
            position: relative;
            z-index: 2;
        }

        /* =====================================================
           GLOBAL BACK BUTTON
        ===================================================== */

        .top-nav {
            position: fixed;

            left: 35px;
            bottom: 28px;

            z-index: 999;
        }

        .top-nav .back-link {
            position: relative;

            display: flex;
            align-items: center;
            justify-content: center;

            width: 150px;
            height: 62px;

            padding: 0;

            border-radius: 999px;

            color: #ffffff;

            background:
                linear-gradient(
                    135deg,
                    rgba(255,255,255,0.24),
                    rgba(80,170,255,0.12)
                );

            border:
                1px solid rgba(255,255,255,0.65);

            backdrop-filter: blur(16px) saturate(140%);
            -webkit-backdrop-filter: blur(16px) saturate(140%);

            box-shadow:
                0 10px 30px rgba(0,25,80,0.45),
                inset 0 1px 0 rgba(255,255,255,0.75),
                inset 0 -1px 0 rgba(0,50,130,0.25);

            font-size: 17px;
            font-weight: 700;
            letter-spacing: 0.5px;

            text-decoration: none;

            overflow: hidden;

            transition:
                transform 0.3s ease,
                box-shadow 0.3s ease,
                background 0.3s ease;
        }

        .top-nav .back-link::before {
            content: "";

            position: absolute;

            top: -80%;
            left: -50%;

            width: 70%;
            height: 250%;

            background:
                linear-gradient(
                    115deg,
                    transparent 25%,
                    rgba(255,255,255,0.45) 50%,
                    transparent 75%
                );

            transform: rotate(18deg);

            transition:
                left 0.6s ease;

            pointer-events: none;
        }

        .top-nav .back-link:hover {
            color: #ffffff;

            transform:
                translateY(-4px);

            background:
                linear-gradient(
                    135deg,
                    rgba(255,255,255,0.32),
                    rgba(50,155,255,0.25)
                );

            box-shadow:
                0 12px 35px rgba(0,80,220,0.5),
                0 0 25px rgba(80,190,255,0.35),
                inset 0 1px 0 rgba(255,255,255,0.85);
        }

        .top-nav .back-link:hover::before {
            left: 130%;
        }

        @media (max-width: 800px) {

            .top-nav {
                left: 18px;
                bottom: 18px;
            }

            .top-nav .back-link {
                width: 120px;
                height: 52px;

                font-size: 14px;
            }
        }
    </style>
</head>

<body>

    <!-- =====================================================
         BACKGROUND
    ===================================================== -->

    <div class="rv-background">

        <div class="rv-glow rv-glow-one"></div>
        <div class="rv-glow rv-glow-two"></div>
        <div class="rv-glow rv-glow-three"></div>
        <div class="rv-glow rv-glow-four"></div>

        <div class="rv-liquid rv-liquid-one"></div>
        <div class="rv-liquid rv-liquid-two"></div>
        <div class="rv-liquid rv-liquid-three"></div>

        <div class="rv-stars">

            @for ($i = 0; $i < 12; $i++)
                <span class="rv-star"></span>
            @endfor

        </div>

        <div class="rv-shooting-star rv-shooting-star-one">
            <span></span>
        </div>

        <div class="rv-shooting-star rv-shooting-star-two">
            <span></span>
        </div>

        <div class="rv-shooting-star rv-shooting-star-three">
            <span></span>
        </div>

        <div class="rv-shooting-star rv-shooting-star-four">
            <span></span>
        </div>

    </div>


    <!-- =====================================================
         BACK
    ===================================================== -->

    <div class="top-nav">

        <a
            href="{{ route('photobooth.scene') }}"
            class="back-link"
        >
            ← Back
        </a>

    </div>


        <div class="camera-page">



    <!-- =========================
         TITLE
    ========================== -->

    <section class="title-section">

        <h1>
            Strike a Pose
        </h1>

        <p>
            Get ready and capture your photo.
        </p>

    </section>


    <!-- =========================
         SELECTED THEME
    ========================== -->

    <div class="selected-theme">

        <span>
            Theme:
            <strong id="selectedThemeLabel">
                {{ $theme->theme_name ?? 'No Theme Selected' }}
            </strong>
        </span>

    </div>


    <!-- =========================
         CAMERA
    ========================== -->

    <div class="camera-wrapper">

        <div class="capture-row">

          <div class="frame-holder">

            <!-- Side controls -->

            <div class="side-controls">

                <a
                    href="{{ route('photobooth.scene') }}"
                    class="side-button back-button"
                    id="backButton"
                >
                    ← Change Theme
                </a>

            </div>


            <div class="camera-frame">

                <!-- Camera -->

                <video
                    id="cameraVideo"
                    autoplay
                    playsinline
                    muted
                ></video>


                <!-- Placeholder -->

                <div
                    class="camera-placeholder"
                    id="cameraPlaceholder"
                >

                    <div class="camera-icon">
                        📷
                    </div>

                    <h2>
                        Camera Ready
                    </h2>

                    <p>
                        Allow camera access to continue.
                    </p>

                </div>


                <!-- Captured photo -->

                <img
                    id="capturedPhoto"
                    class="captured-photo"
                    alt="Captured photo"
                >


                <!-- Countdown -->

                <div
                    class="countdown"
                    id="countdown"
                    aria-live="assertive"
                >

                    <div
                        class="countdown-number"
                        id="countdownNumber"
                    >
                        3
                    </div>

                </div>


                <!-- Shutter button -->

                <button
                    type="button"
                    class="capture-button"
                    id="captureButton"
                    aria-label="Capture Photo"
                    disabled
                >
                    📷
                </button>

            </div>


            <!-- Upload option -->

            <div class="side-controls-right">

                <button
                    type="button"
                    class="side-button upload-button"
                    id="uploadButton"
                >
                    📁 Upload Image
                </button>

                <input
                    type="file"
                    id="imageUpload"
                    accept="image/jpeg,image/png,image/webp"
                    hidden
                >

                <button
                    type="button"
                    class="side-button retake-button"
                    id="retakeButton"
                >
                    ↻ Retake
                </button>

                <button
                    type="button"
                    class="side-button continue-button"
                    id="continueButton"
                >
                    Continue →
                </button>

            </div>

          </div>

        </div>


        <!-- Status -->

        <div
            class="camera-status"
            id="cameraStatus"
        >
            Starting camera...
        </div>


        <!-- Error -->

        <div
            class="camera-error"
            id="cameraError"
        >
            Camera access could not be started.
            Please allow camera permission and try again.
        </div>

    </div>

</div>


<!-- =========================
     HIDDEN CANVAS
========================== -->

<canvas id="photoCanvas"></canvas>


<script>

    /*
     * =========================
     * ELEMENTS
     * =========================
     */

    const video =
        document.getElementById('cameraVideo');

    const canvas =
        document.getElementById('photoCanvas');

    const capturedPhoto =
        document.getElementById('capturedPhoto');

    const placeholder =
        document.getElementById('cameraPlaceholder');

    const countdown =
        document.getElementById('countdown');

    const countdownNumber =
        document.getElementById('countdownNumber');

    const captureButton =
        document.getElementById('captureButton');

    const backButton =
        document.getElementById('backButton');

    const uploadButton =
        document.getElementById('uploadButton');

    const imageUpload =
        document.getElementById('imageUpload');

    const retakeButton =
        document.getElementById('retakeButton');

    const continueButton =
        document.getElementById('continueButton');

    const cameraStatus =
        document.getElementById('cameraStatus');

    const cameraError =
        document.getElementById('cameraError');


    /*
     * =========================
     * VARIABLES
     * =========================
     */

    let cameraStream = null;

    let capturedImageData = null;

    let countdownRunning = false;


    /*
     * =========================
     * SELECTED THEME
     * =========================
     *
     * Prefer the theme_id from the URL. If it is
     * missing (page opened directly, or the theme
     * step navigated without a query string), fall
     * back to the id the theme page saved in
     * sessionStorage.
     */

    let currentThemeId =
        new URLSearchParams(window.location.search)
            .get('theme_id')
        || sessionStorage.getItem('rupavueThemeId')
        || '';

    (function restoreThemeLabel() {

        const serverTheme =
            @json($theme->theme_name ?? null);

        if (serverTheme) {

            document
                .getElementById('selectedThemeLabel')
                .textContent = serverTheme;

            sessionStorage.setItem(
                'rupavueThemeName',
                serverTheme
            );

            if (currentThemeId) {
                sessionStorage.setItem(
                    'rupavueThemeId',
                    currentThemeId
                );
            }

            return;
        }

        const savedName =
            sessionStorage.getItem('rupavueThemeName');

        if (savedName) {

            document
                .getElementById('selectedThemeLabel')
                .textContent = savedName;

        }

    })();


    /*
     * =========================
     * START CAMERA
     * =========================
     */

    async function startCamera() {

        try {

            cameraStatus.textContent =
                'Starting camera...';

            cameraError.classList.remove(
                'visible'
            );

            cameraStream =
                await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'user',

                        aspectRatio: {
                            ideal: 2 / 3
                        }
                    },

                    audio: false
                });


            video.srcObject =
                cameraStream;


            await video.play();


            placeholder.classList.add(
                'hidden'
            );


            captureButton.disabled =
                false;


            cameraStatus.textContent =
                'Camera ready. Strike a pose!';

        } catch (error) {

            console.error(
                'Camera error:',
                error
            );

            cameraStatus.textContent =
                'Camera unavailable.';

            cameraError.classList.add(
                'visible'
            );

            captureButton.disabled =
                true;

        }

    }


    /*
     * =========================
     * COUNTDOWN
     * =========================
     */

    async function startCountdown() {

        if (countdownRunning) {
            return;
        }

        countdownRunning = true;

        captureButton.disabled = true;


        const numbers = [
            '3',
            '2',
            '1'
        ];


        for (const number of numbers) {

            countdownNumber.textContent =
                number;

            countdown.classList.add(
                'active'
            );


            /*
             * Restart animation
             */

            countdownNumber.style.animation =
                'none';

            void countdownNumber.offsetWidth;

            countdownNumber.style.animation =
                'countdownPop 0.9s ease';


            await wait(1000);


            countdown.classList.remove(
                'active'
            );

            await wait(100);

        }


        /*
         * Capture after countdown
         */

        capturePhoto();


        countdownRunning = false;

    }


    /*
     * =========================
     * UPLOAD IMAGE
     * =========================
     */

    uploadButton.addEventListener(
        'click',
        function () {

            imageUpload.click();

        }
    );


    imageUpload.addEventListener(
        'change',
        function (event) {

            const file =
                event.target.files[0];

            if (!file) {
                return;
            }


            /*
            * Check file type
            */

            const allowedTypes = [
                'image/jpeg',
                'image/png',
                'image/webp'
            ];

            if (!allowedTypes.includes(file.type)) {

                cameraStatus.textContent =
                    'Please upload a JPG, PNG, or WebP image.';

                return;
            }


            /*
            * Check file size
            *
            * Maximum: 10 MB
            */

            if (file.size > 10 * 1024 * 1024) {

                cameraStatus.textContent =
                    'Image must be smaller than 10 MB.';

                return;
            }


            /*
            * Read image
            */

            const reader =
                new FileReader();


            reader.onload = function (e) {

                processUploadedImage(
                    e.target.result
                );

            };


            reader.readAsDataURL(file);

        }
    );

    /*
     * =========================
     * PROCESS UPLOADED IMAGE
     * =========================
     */

    function processUploadedImage(imageData) {

        const image =
            new Image();


        image.onload = function () {

            /*
            * Target ratio
            *
            * 3:2 landscape
            */

            const targetRatio =
                3 / 2;


            const sourceWidth =
                image.naturalWidth;

            const sourceHeight =
                image.naturalHeight;


            const sourceRatio =
                sourceWidth / sourceHeight;


            let cropWidth =
                sourceWidth;

            let cropHeight =
                sourceHeight;

            let cropX = 0;

            let cropY = 0;


            /*
            * Crop image to 3:2
            */

            if (sourceRatio > targetRatio) {

                /*
                * Image is too wide
                */

                cropWidth =
                    sourceHeight * targetRatio;

                cropX =
                    (sourceWidth - cropWidth) / 2;

            } else {

                /*
                * Image is too tall
                */

                cropHeight =
                    sourceWidth / targetRatio;

                cropY =
                    (sourceHeight - cropHeight) / 2;

            }


            /*
            * Output size
            */

            const outputWidth =
                1200;

            const outputHeight =
                800;


            canvas.width =
                outputWidth;

            canvas.height =
                outputHeight;


            const context =
                canvas.getContext('2d');


            /*
            * Draw cropped image
            */

            context.drawImage(

                image,

                cropX,
                cropY,

                cropWidth,
                cropHeight,

                0,
                0,

                outputWidth,
                outputHeight

            );


            /*
            * Convert to JPEG
            */

            capturedImageData =
                canvas.toDataURL(
                    'image/jpeg',
                    0.92
                );


            /*
            * Display uploaded image
            */

            capturedPhoto.src =
                capturedImageData;

            capturedPhoto.classList.add(
                'visible'
            );


            /*
            * Hide camera
            */

            video.style.display =
                'none';


            placeholder.classList.add(
                'hidden'
            );


            /*
            * Stop camera
            */

            stopCamera();


            /*
            * Update UI
            */

            cameraStatus.textContent =
                'Image uploaded successfully!';

            captureButton.style.display =
                'none';

            backButton.style.display =
                'none';

            uploadButton.style.display =
                'none';

            retakeButton.style.display =
                'inline-flex';

            continueButton.style.display =
                'inline-flex';

        };


        image.src =
            imageData;

    }


    /*
     * =========================
     * CAPTURE PHOTO
     * =========================
     */

    function capturePhoto() {

        if (!video.videoWidth ||
            !video.videoHeight) {

            cameraStatus.textContent =
                'Camera is not ready yet.';

            captureButton.disabled =
                false;

            return;
        }


       
        const targetRatio =
            3 / 2;

        let sourceWidth =
            video.videoWidth;

        let sourceHeight =
            video.videoHeight;


        const sourceRatio =
            sourceWidth / sourceHeight;


        let cropWidth =
            sourceWidth;

        let cropHeight =
            sourceHeight;

        let cropX = 0;

        let cropY = 0;


        /*
         * Crop the camera image
         * to exactly 3:2.
         */

        if (sourceRatio > targetRatio) {

            cropWidth =
                sourceHeight * targetRatio;

            cropX =
                (sourceWidth - cropWidth) / 2;

        } else {

            cropHeight =
                sourceWidth / targetRatio;

            cropY =
                (sourceHeight - cropHeight) / 2;
        }


        /*
         * Canvas output
         */

        const outputWidth =
            1200;

        const outputHeight =
            800;


        canvas.width =
            outputWidth;

        canvas.height =
            outputHeight;


        const context =
            canvas.getContext('2d');


        /*
         * Mirror the captured photo
         * so it matches the preview.
         */

        context.save();

        context.translate(
            outputWidth,
            0
        );

        context.scale(
            -1,
            1
        );


        context.drawImage(
            video,

            cropX,
            cropY,
            cropWidth,
            cropHeight,

            0,
            0,
            outputWidth,
            outputHeight
        );


        context.restore();


        /*
         * Convert to image
         */

        capturedImageData =
            canvas.toDataURL(
                'image/jpeg',
                0.92
            );


        /*
         * Display captured photo
         */

        capturedPhoto.src =
            capturedImageData;

        capturedPhoto.classList.add(
            'visible'
        );


        /*
         * Stop camera preview
         */

        stopCamera();


        /*
         * Update UI
         */

        cameraStatus.textContent =
            'Photo captured successfully!';

        captureButton.style.display =
            'none';

        backButton.style.display =
            'none';

        uploadButton.style.display =
            'none';

        retakeButton.style.display =
            'inline-flex';

        continueButton.style.display =
            'inline-flex';

    }


    /*
     * =========================
     * RETAKE
     * =========================
     */

    function retakePhoto() {

            capturedImageData =
                null;


            capturedPhoto.src =
                '';

            capturedPhoto.classList.remove(
                'visible'
            );


            /*
            * Show camera
            */

            video.style.display =
                'block';


            /*
            * Show capture button and back link
            */

            captureButton.style.display =
                'inline-flex';

            backButton.style.display =
                'inline-flex';

            uploadButton.style.display =
                'inline-flex';


            /*
            * Clear uploaded file
            */

            imageUpload.value =
                '';


            /*
            * Hide result buttons
            */

            retakeButton.style.display =
                'none';

            continueButton.style.display =
                'none';


            captureButton.disabled =
                true;


            cameraStatus.textContent =
                'Starting camera...';


            /*
            * Start camera again
            */

            startCamera();

        }


    /*
     * =========================
     * STOP CAMERA
     * =========================
     */

    function stopCamera() {

        if (!cameraStream) {
            return;
        }


        cameraStream
            .getTracks()
            .forEach(track => {
                track.stop();
            });


        cameraStream = null;

        video.srcObject = null;

    }


    /*
     * =========================
     * CONTINUE
     * =========================
     */

    function continueToGeneration() {

        if (!capturedImageData) {

            cameraStatus.textContent =
                'Please capture a photo first.';

            return;
        }


        /*
         * Store the captured image temporarily.
         *
         * Later we will replace this with
         * proper Laravel file uploading.
         */

        sessionStorage.setItem(
            'rupavueCapturedPhoto',
            capturedImageData
        );


        /*
         * Go to generation page.
         */

        window.location.href =
            "{{ route('photobooth.generate') }}"
            + "?theme_id="
            + encodeURIComponent(currentThemeId);

    }


    /*
     * =========================
     * WAIT HELPER
     * =========================
     */

    function wait(milliseconds) {

        return new Promise(
            resolve =>
                setTimeout(
                    resolve,
                    milliseconds
                )
        );

    }


    /*
     * =========================
     * EVENTS
     * =========================
     */

    captureButton.addEventListener(
        'click',
        startCountdown
    );


    retakeButton.addEventListener(
        'click',
        retakePhoto
    );


    continueButton.addEventListener(
        'click',
        continueToGeneration
    );


    /*
     * =========================
     * CENTER SIDE CONTROLS
     *
     * Keeps the left/right button
     * columns centered in the gap
     * between the frame and the
     * page edge, no matter which
     * constraint ends up sizing
     * the frame.
     * =========================
     */

    /*
     * The "sidewall" is the page itself, not
     * the (narrower, max-width capped) capture
     * row, so the gap is measured against that.
     */
    const cameraPageEl =
        document.querySelector('.camera-page');

    const side =
        document.querySelector('.side-controls');

    const sideRight =
        document.querySelector('.side-controls-right');

    function centerSideControls() {

        if (window.innerWidth <= 768) {

            side.style.left = '';
            side.style.marginRight = '';

            sideRight.style.left = '';
            sideRight.style.marginLeft = '';

            return;
        }


        const frameRect =
            video.parentElement
                .getBoundingClientRect();

        const rowRect =
            cameraPageEl.getBoundingClientRect();

        const leftGap =
            frameRect.left - rowRect.left;

        const rightGap =
            rowRect.right - frameRect.right;

        /*
         * The stylesheet's margin-right/margin-left
         * only serve as a before-JS fallback; zero
         * them out so they don't stack on top of the
         * computed "left" position below.
         */
        side.style.marginRight = '0';
        sideRight.style.marginLeft = '0';

        side.style.left =
            (-leftGap / 2 - side.offsetWidth / 2)
            + 'px';

        sideRight.style.left =
            (frameRect.width
                + rightGap / 2
                - sideRight.offsetWidth / 2)
            + 'px';

    }


    window.addEventListener(
        'load',
        centerSideControls
    );

    window.addEventListener(
        'resize',
        centerSideControls
    );

    centerSideControls();


    /*
     * =========================
     * CLEANUP
     * =========================
     */

    window.addEventListener(
        'beforeunload',
        stopCamera
    );


    /*
     * =========================
     * START
     * =========================
     */

    if (
        navigator.mediaDevices &&
        navigator.mediaDevices.getUserMedia
    ) {

        startCamera();

    } else {

        cameraStatus.textContent =
            'Your browser does not support camera access.';

        cameraError.textContent =
            'Please use a modern browser such as Chrome or Edge.';

        cameraError.classList.add(
            'visible'
        );

    }

</script>

</body>
</html>
