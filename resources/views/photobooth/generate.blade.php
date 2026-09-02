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
            background: #031535;
            color: #07142f;
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

            background:
                radial-gradient(
                    ellipse 65% 68% at 50% 43%,
                    #ffffff 0%,
                    #eef6ff 18%,
                    #c8e1ff 34%,
                    #75adf2 52%,
                    #2167cf 67%,
                    #073577 82%,
                    #010d2c 100%
                );
        }

        /* Deep blue corner atmosphere */
        .generate-page::before {
            content: "";
            position: absolute;
            inset: -22%;
            z-index: 0;
            pointer-events: none;

            background:
                radial-gradient(
                    ellipse at 0% 0%,
                    rgba(4, 62, 160, .92),
                    transparent 34%
                ),
                radial-gradient(
                    ellipse at 100% 0%,
                    rgba(7, 130, 220, .80),
                    transparent 35%
                ),
                radial-gradient(
                    ellipse at 0% 100%,
                    rgba(55, 40, 190, .82),
                    transparent 34%
                ),
                radial-gradient(
                    ellipse at 100% 100%,
                    rgba(0, 91, 205, .82),
                    transparent 35%
                );

            filter: blur(42px);
            animation: generateAtmosphere 18s ease-in-out infinite;
        }

        @keyframes generateAtmosphere {
            0%, 100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.06);
            }
        }

        /* =====================================================
           STARS
        ===================================================== */

        .generation-stars {
            position: absolute;
            inset: 0;
            z-index: 1;
            pointer-events: none;
        }

        .generation-star {
            position: absolute;
            width: 3px;
            height: 3px;
            border-radius: 50%;
            background: #fff;
            box-shadow:
                0 0 7px #fff,
                0 0 14px #55aaff;
            animation: generationTwinkle 3s ease-in-out infinite;
        }

        .generation-star:nth-child(1) { top: 8%; left: 8%; }
        .generation-star:nth-child(2) { top: 15%; left: 23%; animation-delay: .8s; }
        .generation-star:nth-child(3) { top: 7%; left: 48%; animation-delay: 1.2s; }
        .generation-star:nth-child(4) { top: 12%; right: 27%; animation-delay: 1.8s; }
        .generation-star:nth-child(5) { top: 9%; right: 8%; animation-delay: .5s; }
        .generation-star:nth-child(6) { top: 28%; left: 13%; animation-delay: 1.5s; }
        .generation-star:nth-child(7) { top: 25%; right: 12%; animation-delay: 2s; }
        .generation-star:nth-child(8) { top: 43%; left: 5%; animation-delay: .3s; }
        .generation-star:nth-child(9) { top: 40%; right: 7%; animation-delay: 1.4s; }
        .generation-star:nth-child(10) { top: 55%; left: 18%; animation-delay: 2.3s; }
        .generation-star:nth-child(11) { top: 60%; right: 17%; animation-delay: .9s; }
        .generation-star:nth-child(12) { top: 76%; left: 9%; animation-delay: 1.6s; }
        .generation-star:nth-child(13) { top: 82%; left: 32%; animation-delay: .6s; }
        .generation-star:nth-child(14) { top: 72%; right: 30%; animation-delay: 1.9s; }
        .generation-star:nth-child(15) { top: 85%; right: 9%; animation-delay: 2.4s; }

        @keyframes generationTwinkle {
            0%, 100% {
                opacity: .35;
                transform: scale(.7);
            }

            50% {
                opacity: 1;
                transform: scale(1.7);
            }
        }

        /* =====================================================
           SHOOTING STARS
        ===================================================== */

        .shooting-star {
            position: absolute;
            z-index: 2;
            width: 95px;
            height: 2px;
            border-radius: 999px;

            background:
                linear-gradient(
                    90deg,
                    transparent,
                    rgba(255,255,255,.25),
                    #fff
                );

            transform: rotate(-35deg);
            opacity: 0;

            filter: drop-shadow(0 0 5px #fff);

            animation:
                generationShootingStar
                7s
                linear
                infinite;
        }

        .shooting-star::after {
            content: "";
            position: absolute;
            right: 0;
            top: 50%;
            width: 5px;
            height: 5px;
            transform: translateY(-50%);
            border-radius: 50%;
            background: #fff;

            box-shadow:
                0 0 8px #fff,
                0 0 15px #52aaff;
        }

        .shooting-one {
            top: 13%;
            left: 15%;
        }

        .shooting-two {
            top: 20%;
            right: 20%;
            animation-delay: 2.5s;
        }

        .shooting-three {
            top: 55%;
            right: 8%;
            animation-delay: 5s;
        }

        @keyframes generationShootingStar {
            0% {
                opacity: 0;
                transform: translate(0, 0) rotate(-35deg);
            }

            5% {
                opacity: 1;
            }

            18% {
                opacity: 1;
                transform: translate(-170px, 110px) rotate(-35deg);
            }

            20%, 100% {
                opacity: 0;
                transform: translate(-210px, 140px) rotate(-35deg);
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
           HEADER
        ===================================================== */

        .header {
            position: relative;
            z-index: 10;

            display: flex;
            align-items: center;
            justify-content: space-between;

            flex-shrink: 0;
            margin-bottom: 8px;
        }

        .logo {
            color: #07142f;
            font-size: 23px;
            font-weight: 800;
            letter-spacing: 3px;
        }

        .step {
            padding: 7px 13px;
            border-radius: 999px;

            color: #17385e;
            background: rgba(255,255,255,.58);
            border: 1px solid rgba(255,255,255,.8);

            box-shadow:
                0 5px 18px rgba(0,45,120,.10),
                inset 0 1px 0 rgba(255,255,255,.9);

            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.5px;
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
            color: #07142f;

            font-size: clamp(28px, 3.2vw, 44px);
            font-weight: 800;

            letter-spacing: .5px;
            margin-bottom: 5px;

            text-shadow:
                0 3px 18px rgba(255,255,255,.7);
        }

        .title-section p {
            color: rgba(7, 20, 47, .68);
            font-size: 14px;
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
            color: #17385e;

            font-size: 12px;
            font-weight: 700;

            letter-spacing: 1.8px;
            text-transform: uppercase;

            margin-bottom: 8px;

            text-shadow:
                0 1px 8px rgba(255,255,255,.8);
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
            width: 52px;
            height: 52px;

            margin: 0 auto 14px;

            border-radius: 50%;

            border:
                4px solid
                rgba(7,60,130,.15);

            border-top-color: #0877e8;
            border-right-color: #51b9ff;

            animation:
                spin
                1s
                linear
                infinite;

            box-shadow:
                0 0 16px rgba(0,120,255,.22);
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
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

            color: rgba(7,20,47,.62);
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

            .logo {
                font-size: 19px;
                letter-spacing: 2px;
            }

            .step {
                font-size: 9px;
                padding: 6px 10px;
            }

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

            width: 115px !important;
            height: 48px !important;

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

            font-size: 14px !important;
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


        /* =====================================================
        RUPAVUE LOGO
        ===================================================== */

        .logo {
            color: #ffffff !important;

            text-shadow:
                0 2px 8px rgba(0,20,70,0.7),
                0 0 18px rgba(255,255,255,0.2) !important;
        }
    </style>
</head>

<body>

<div class="generate-page">

    <!-- =========================
         BACKGROUND DECORATION
    ========================== -->

    <div class="generation-stars" aria-hidden="true">
        @for ($i = 0; $i < 15; $i++)
            <span class="generation-star"></span>
        @endfor
    </div>

    <span class="shooting-star shooting-one" aria-hidden="true"></span>
    <span class="shooting-star shooting-two" aria-hidden="true"></span>
    <span class="shooting-star shooting-three" aria-hidden="true"></span>


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
         HEADER
    ========================== -->

    <header class="header">

        <div class="logo">
            RUPAVUE
        </div>

        <div class="step">
            STEP 3 OF 3
        </div>

    </header>


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