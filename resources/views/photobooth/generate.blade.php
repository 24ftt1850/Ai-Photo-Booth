<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Applying AI Magic - RupaVue</title>

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
            color: #ffffff;
        }

        /* =====================================================
           MAIN PAGE — SAME BLUE/WHITE RUPAVUE STYLE
        ===================================================== */

        .generate-page {
            position: relative;
            width: 100%;
            height: 100vh;
            height: 100dvh;
            overflow: hidden;

            padding: 18px 5% 20px;

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

        /* =====================================================
           TOP NAV
        ===================================================== */

        .top-nav {
            position: relative;
            z-index: 10;
            flex-shrink: 0;
            margin-bottom: 6px;
        }

        .back-link {
            color: rgba(7, 20, 47, .70);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .5px;
            transition: color .2s ease;
        }

        .back-link:hover {
            color: #07142f;
        }

        /* =====================================================
           APPLYING AI MAGIC — MOVED TO TOP
        ===================================================== */

        .title-section {
            position: relative;
            z-index: 10;

            text-align: center;
            flex-shrink: 0;

            margin: 4px auto 8px;
        }

        .title-section h1 {
            color: #ffffff;

            font-size: clamp(34px, 4.4vw, 56px);
            font-weight: 800;

            letter-spacing: .5px;
            margin-bottom: 8px;

            text-shadow:
                0 0 12px rgba(255,255,255,.35),
                0 0 30px rgba(30,140,255,.55),
                0 0 60px rgba(20,110,255,.35);

            animation: titleGlow 3s ease-in-out infinite;
        }

        @keyframes titleGlow {

            0%,
            100% {
                text-shadow:
                    0 0 12px rgba(255,255,255,.35),
                    0 0 30px rgba(30,140,255,.55),
                    0 0 60px rgba(20,110,255,.35);
            }

            50% {
                text-shadow:
                    0 0 18px rgba(255,255,255,.55),
                    0 0 45px rgba(30,140,255,.8),
                    0 0 85px rgba(20,110,255,.5);
            }
        }

        .title-section p {
            color: rgba(218,237,255,.85);
            font-size: 16px;
        }

        /* =====================================================
           THEME BADGE
        ===================================================== */

        .theme-label {
            position: relative;
            z-index: 10;

            text-align: center;
            flex-shrink: 0;

            margin-bottom: 10px;
        }

        .theme-label span {
            display: inline-block;

            padding: 7px 17px;

            border: 1px solid rgba(255,255,255,.9);
            border-radius: 50px;

            background: rgba(255,255,255,.62);

            color: #17385e;

            box-shadow:
                0 7px 20px rgba(0,45,120,.10),
                inset 0 1px 0 rgba(255,255,255,.95);

            backdrop-filter: blur(10px);

            font-size: 12px;
            letter-spacing: .8px;
        }

        .theme-label strong {
            color: #075a91;
        }

        /* =====================================================
           GENERATION AREA
        ===================================================== */

        .generation-container {
            position: relative;
            z-index: 10;

            width: 100%;
            max-width: 1020px;

            margin: 0 auto;

            display: grid;
            grid-template-columns: minmax(0, 1fr) 90px minmax(0, 1fr);

            align-items: center;

            gap: 20px;

            flex: 1;
            min-height: 0;
        }

        /* =====================================================
           PHOTO
        ===================================================== */

        .photo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

            min-width: 0;
            min-height: 0;
        }

        .photo-title {
            color: rgba(218,237,255,.9);

            font-size: 12px;
            font-weight: 700;

            letter-spacing: 1.8px;
            text-transform: uppercase;

            margin-bottom: 8px;

            text-shadow:
                0 0 10px rgba(0,102,255,.35);
        }

        .photo-frame {
            width: min(100%, 310px);

            aspect-ratio: 2 / 3;

            border-radius: 20px;

            overflow: hidden;

            background: rgba(255,255,255,.38);

            border:
                2px solid
                rgba(255,255,255,.82);

            box-shadow:
                0 18px 45px rgba(0,30,90,.25),
                0 0 25px rgba(70,160,255,.15),
                inset 0 1px 0 rgba(255,255,255,.9);

            position: relative;

            backdrop-filter: blur(8px);
        }

        .photo-frame img {
            width: 100%;
            height: 100%;

            display: block;

            object-fit: cover;
        }

        .photo-placeholder {
            width: 100%;
            height: 100%;

            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;

            color: rgba(7,20,47,.58);

            text-align: center;

            background:
                linear-gradient(
                    145deg,
                    rgba(255,255,255,.62),
                    rgba(225,240,255,.35)
                );
        }

        .photo-placeholder-icon {
            font-size: 42px;
            margin-bottom: 10px;
        }

        .photo-placeholder p {
            font-size: 12px;
        }

        /* =====================================================
           ARROW
        ===================================================== */

        .arrow {
            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 38px;
            font-weight: 300;

            color: #086fd2;

            text-shadow:
                0 0 14px rgba(0,125,255,.45);
        }

        /* =====================================================
           AI RESULT LOADING
        ===================================================== */

        .loading-circle {
            position: relative;

            width: 84px;
            height: 84px;

            margin: 0 auto 18px;

            border-radius: 50%;

            border:
                5px solid
                rgba(80,160,255,.15);

            border-top-color: #3aa8ff;
            border-right-color: #8fd0ff;

            animation:
                spin
                1.1s
                linear
                infinite,
                loadingPulse
                2.2s
                ease-in-out
                infinite;

            box-shadow:
                0 0 26px rgba(50,150,255,.45),
                0 0 50px rgba(30,120,255,.25);
        }

        .loading-circle::after {
            content: "";

            position: absolute;
            inset: 12px;

            border-radius: 50%;

            border:
                3px solid
                transparent;

            border-bottom-color: #ffffff;
            border-left-color: rgba(255,255,255,.5);

            animation:
                spinReverse
                1.7s
                linear
                infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @keyframes spinReverse {
            from {
                transform: rotate(360deg);
            }

            to {
                transform: rotate(0deg);
            }
        }

        @keyframes loadingPulse {

            0%,
            100% {
                box-shadow:
                    0 0 26px rgba(50,150,255,.45),
                    0 0 50px rgba(30,120,255,.25);
            }

            50% {
                box-shadow:
                    0 0 38px rgba(70,170,255,.7),
                    0 0 75px rgba(40,140,255,.4);
            }
        }

        /* =====================================================
           PROGRESS
        ===================================================== */

        .progress-container {
            position: relative;
            z-index: 10;

            width: min(90%, 450px);

            flex-shrink: 0;

            margin: 7px auto 0;
        }

        .progress-bar {
            width: 100%;
            height: 5px;

            border-radius: 10px;
            overflow: hidden;

            background: rgba(255,255,255,.55);

            box-shadow:
                inset 0 1px 3px rgba(0,50,120,.12);
        }

        .progress-fill {
            width: 0%;
            height: 100%;

            background:
                linear-gradient(
                    90deg,
                    #0877e8,
                    #54c4ff
                );

            border-radius: 10px;

            transition: width .5s ease;

            box-shadow:
                0 0 12px rgba(0,130,255,.55);
        }

        .progress-text {
            text-align: center;

            margin-top: 6px;

            font-size: 11px;
            font-weight: 600;

            color: rgba(218,237,255,.75);
        }

        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 800px) {

            html,
            body {
                overflow-y: auto;
            }

            .generate-page {
                min-height: 100vh;
                height: auto;
                min-height: 100dvh;
                overflow-y: auto;
                padding: 18px 20px 25px;
            }

            .generation-container {
                flex: none;
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .arrow {
                transform: rotate(90deg);
                font-size: 30px;
            }

            .photo-frame {
                width: min(70vw, 300px);
            }

            .title-section h1 {
                font-size: 30px;
            }
        }

        @media (max-width: 480px) {

            .title-section h1 {
                font-size: 27px;
            }

            .title-section p {
                font-size: 12px;
            }

            .photo-frame {
                width: min(72vw, 270px);
            }
        }

        /* =====================================================
        FINAL HEADER / BACK BUTTON FIX
        ===================================================== */

        /* Move the whole Back container to bottom-left */
        .top-nav {
            position: fixed !important;

            left: 35px !important;
            bottom: 28px !important;

            top: auto !important;
            right: auto !important;

            margin: 0 !important;

            z-index: 999 !important;
        }


        /* Liquid glass Back button */
        .back-link {
            position: relative !important;

            display: flex !important;
            align-items: center !important;
            justify-content: center !important;

            width: 150px !important;
            height: 62px !important;

            padding: 0 !important;

            border-radius: 999px !important;

            color: #ffffff !important;

            background:
                linear-gradient(
                    135deg,
                    rgba(255,255,255,0.24),
                    rgba(80,170,255,0.12)
                ) !important;

            border:
                1px solid rgba(255,255,255,0.65) !important;

            backdrop-filter: blur(16px) saturate(140%) !important;
            -webkit-backdrop-filter: blur(16px) saturate(140%) !important;

            box-shadow:
                0 10px 30px rgba(0,25,80,0.45),
                inset 0 1px 0 rgba(255,255,255,0.75),
                inset 0 -1px 0 rgba(0,50,130,0.25) !important;

            font-size: 17px !important;
            font-weight: 700 !important;
            letter-spacing: 0.5px !important;

            text-decoration: none !important;

            overflow: hidden !important;

            transition:
                transform 0.3s ease,
                box-shadow 0.3s ease,
                background 0.3s ease !important;
        }


        /* Liquid reflection */
        .back-link::before {
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


        /* Hover effect */
        .back-link:hover {
            color: #ffffff !important;

            transform:
                translateY(-4px) !important;

            background:
                linear-gradient(
                    135deg,
                    rgba(255,255,255,0.32),
                    rgba(50,155,255,0.25)
                ) !important;

            box-shadow:
                0 12px 35px rgba(0,80,220,0.5),
                0 0 25px rgba(80,190,255,0.35),
                inset 0 1px 0 rgba(255,255,255,0.85) !important;
        }


        .back-link:hover::before {
            left: 130%;
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


<div class="generate-page">

    <!-- =========================
         BACK
    ========================== -->

    <div class="top-nav">

        <a
            href="{{ route('photobooth.create') }}?theme_id={{ $theme->id ?? '' }}"
            class="back-link"
        >
            ← Back
        </a>

    </div>




    <!-- =========================
         TITLE
    ========================== -->

    <section class="title-section">

        <h1>
            Applying AI Magic
        </h1>

        <p id="topStatusText">
            Your photo is being transformed...
        </p>

    </section>


    <!-- =========================
         THEME
    ========================== -->

    <p id="statusText" style="display:none;"></p>

    <div class="theme-label">

        <span>
            Theme:
            <strong id="themeName">
                {{ $theme->theme_name ?? 'Unknown Theme' }}
            </strong>
        </span>

    </div>


    <!-- =========================
         PHOTO COMPARISON
    ========================== -->

    <div class="generation-container">

        <!-- ORIGINAL -->

        <div class="photo-container">

            <div class="photo-title">
                Your Photo
            </div>

            <div class="photo-frame">

                <img
                    id="originalPhoto"
                    alt="Your captured photo"
                    style="display: none;"
                >

                <div
                    class="photo-placeholder"
                    id="photoPlaceholder"
                >

                    <div class="photo-placeholder-icon">
                        📷
                    </div>

                    <p>
                        Preparing your photo...
                    </p>

                </div>

            </div>

        </div>


        <!-- ARROW -->

        <div class="arrow">
            →
        </div>


        <!-- GENERATED -->

        <div class="photo-container">

            <div class="photo-title">
                AI Result
            </div>

            <div class="photo-frame">

                <div class="photo-placeholder">

                    <div class="loading-circle"></div>

                    <p>
                        AI is creating...
                    </p>

                </div>

            </div>

        </div>

    </div>


    <!-- Status is displayed at the top above the photo comparison. -->


    <!-- =========================
         PROGRESS
    ========================== -->

    <div class="progress-container">

        <div class="progress-bar">

            <div
                class="progress-fill"
                id="progressFill"
            ></div>

        </div>

        <div
            class="progress-text"
            id="progressText"
        >
            0%
        </div>

    </div>

</div>


<script>

    /*
     * =========================
     * ELEMENTS
     * =========================
     */

    const originalPhoto =
        document.getElementById('originalPhoto');

    const photoPlaceholder =
        document.getElementById('photoPlaceholder');

    const statusText =
        document.getElementById('statusText');

    const topStatusText =
        document.getElementById('topStatusText');

    const progressFill =
        document.getElementById('progressFill');

    const progressText =
        document.getElementById('progressText');


    /*
     * =========================
     * THEME (RESOLVED SERVER-SIDE)
     * =========================
     */

    const themeId =
        @json($theme->id ?? null);


    /*
     * =========================
     * LOAD CAPTURED PHOTO
     * =========================
     */

    const capturedPhoto =
        sessionStorage.getItem(
            'rupavueCapturedPhoto'
        );


    if (capturedPhoto) {

        originalPhoto.src =
            capturedPhoto;

        originalPhoto.style.display =
            'block';

        photoPlaceholder.style.display =
            'none';

    } else {

        statusText.textContent =
            'No captured photo found.';

    }


    /*
    |--------------------------------------------------------------------------
    | Progress
    |--------------------------------------------------------------------------
    */

    function updateProgress(
        value,
        message
    ) {

        progressFill.style.width =
            value + '%';

        progressText.textContent =
            value + '%';

        statusText.textContent =
            message;

        if (topStatusText) {
            topStatusText.textContent = message;
        }

    }


    /*
    |--------------------------------------------------------------------------
    | Wait Helper
    |--------------------------------------------------------------------------
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
    |--------------------------------------------------------------------------
    | Generate AI Image
    |--------------------------------------------------------------------------
    */

    async function generateAIImage() {

        if (!capturedPhoto) {

            statusText.textContent =
                'No photo was captured.';

            return;

        }


        if (!themeId) {

            statusText.textContent =
                'No theme was selected.';

            return;

        }


        try {

            updateProgress(
                10,
                'Preparing your photo...'
            );


            await wait(500);


            updateProgress(
                25,
                'Uploading your photo...'
            );


            /*
            * Send photo + theme to Laravel
            */

            const response =
                await fetch(
                    "{{ route('gemini.generate') }}",
                    {

                        method: 'POST',

                        headers: {

                            'Content-Type':
                                'application/json',

                            'X-CSRF-TOKEN':
                                '{{ csrf_token() }}',

                            'Accept':
                                'application/json'

                        },

                        body: JSON.stringify({

                            image:
                                capturedPhoto,

                            theme_id:
                                themeId

                        })

                    }
                );


            updateProgress(
                45,
                'AI is creating your photo...'
            );


            const data =
                await response.json();


            /*
            * Check response
            */

            if (!response.ok ||
                !data.success) {

                console.error(
                    'Generation error:',
                    data
                );

                throw new Error(
                    data.message ||
                    'AI generation failed.'
                );

            }


            updateProgress(
                90,
                'Finishing your photo...'
            );


            /*
            * Save generated image
            */

            sessionStorage.setItem(
                'rupavueGeneratedPhoto',
                data.generated_image
            );


            sessionStorage.setItem(
                'rupavueGeneratedImageId',
                data.generated_image_id
            );


            sessionStorage.setItem(
                'rupavueOriginalPhoto',
                data.original_image
            );


            sessionStorage.setItem(
                'rupavueThemeName',
                data.theme
            );


            await wait(700);


            updateProgress(
                100,
                'Your photo is ready!'
            );


            await wait(500);


            /*
            * Go to result
            */

            window.location.href =
                "{{ route('photobooth.result') }}";


        } catch (error) {

            console.error(
                error
            );


            statusText.textContent =
                error.message ||
                'Something went wrong while creating your photo.';


            progressText.textContent =
                'Error';


            progressFill.style.width =
                '0%';

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Start Generation
    |--------------------------------------------------------------------------
    */

    generateAIImage();

</script>

</body>
</html>
