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
            background: #111;
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

            background:
                radial-gradient(
                    ellipse 65% 70% at 50% 42%,
                    #ffffff 0%,
                    #f1f7ff 18%,
                    #c8e1ff 34%,
                    #78adf1 52%,
                    #286bd0 68%,
                    #073477 83%,
                    #010d2d 100%
                );
        }

        /* =====================================================
        BLUE ATMOSPHERE
        ===================================================== */

        .camera-page::before {

            content: "";

            position: absolute;

            inset: -20%;

            z-index: 0;

            pointer-events: none;

            background:

                radial-gradient(
                    ellipse at 0% 0%,
                    rgba(5,63,160,0.90),
                    transparent 34%
                ),

                radial-gradient(
                    ellipse at 100% 0%,
                    rgba(8,122,210,0.78),
                    transparent 35%
                ),

                radial-gradient(
                    ellipse at 0% 100%,
                    rgba(55,45,180,0.82),
                    transparent 34%
                ),

                radial-gradient(
                    ellipse at 100% 100%,
                    rgba(0,91,200,0.82),
                    transparent 35%
                );

            filter: blur(40px);

            animation:
                cameraAtmosphere
                18s
                ease-in-out
                infinite;
        }


        @keyframes cameraAtmosphere {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.06);
            }

        }
        /* =========================
           HEADER
        ========================= */

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;

            margin-bottom: 12px;

            flex-shrink: 0;
        }

        .logo {
            font-size: 25px;
            font-weight: 800;

            letter-spacing: 4px;
        }

        .step {
            font-size: 13px;
            font-weight: 600;

            letter-spacing: 2px;

            color: rgba(255, 255, 255, 0.65);
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
            font-size: clamp(24px, 3vw, 38px);

            font-weight: 700;

            margin-bottom: 4px;
        }

        .title-section p {
            font-size: 15px;

            color: rgba(255, 255, 255, 0.7);
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

            padding: 8px 18px;

            border: 1px solid rgba(255, 255, 255, 0.25);

            border-radius: 50px;

            background: rgba(255, 255, 255, 0.08);

            font-size: 13px;

            letter-spacing: 1px;
        }

        /* =========================
           CAMERA AREA
        ========================= */

        .camera-wrapper {
            width: 100%;
            max-width: 600px;

            margin: 0 auto;

            display: flex;
            flex-direction: column;

            align-items: center;

            flex: 1;

            min-height: 0;
        }

        /*
         * 2:3 Camera frame
         */

        .camera-frame {
            position: relative;
            width: min(55vh, 600px);
            aspect-ratio: 2 / 3;
            max-height: 55vh;
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
            margin-top: 8px;

            font-size: 14px;

            color: rgba(255, 255, 255, 0.65);

            min-height: 20px;

            text-align: center;
        }

        /* =========================
           BUTTONS
        ========================= */

        .actions {
            display: flex;

            align-items: center;
            justify-content: center;

            gap: 10px;

            margin-top: 10px;

            flex-wrap: wrap;

            flex-shrink: 0;
        }

        .or-text {
            font-size: 12px;
            font-weight: 600;

            letter-spacing: 1px;

            color: rgba(255, 255, 255, 0.45);
        }

        .upload-button {
            border: 2px solid rgba(255, 255, 255, 0.3);

            background: rgba(255, 255, 255, 0.08);

            color: white;
        }

        .upload-button:hover {
            background: white;

            color: #111;

            transform: translateY(-3px);
        }

        .button {
            min-width: 180px;

            padding: 12px 24px;

            border-radius: 50px;

            font-size: 14px;

            font-weight: 700;

            letter-spacing: 1.5px;

            text-transform: uppercase;

            cursor: pointer;

            transition:
                transform 0.2s ease,
                background 0.2s ease,
                color 0.2s ease,
                opacity 0.2s ease;
        }

        .capture-button {
            border: 2px solid white;

            background: white;

            color: #111;
        }

        .capture-button:hover:not(:disabled) {
            transform: translateY(-3px);

            box-shadow:
                0 10px 30px rgba(0, 0, 0, 0.35);
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

            font-size: 13px;

            line-height: 1.5;
        }

        .camera-error.visible {
            display: block;
        }

        /* =========================
           BACK BUTTON
        ========================= */

        .back-button {
            margin-top: 8px;

            text-align: center;

            flex-shrink: 0;
        }

        .back-button a {
            color: rgba(255, 255, 255, 0.55);

            text-decoration: none;

            font-size: 13px;

            letter-spacing: 1px;

            transition: color 0.2s ease;
        }

        .back-button a:hover {
            color: white;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 768px) {

            .camera-page {
                padding: 25px 20px 35px;
            }

            .logo {
                font-size: 20px;
            }

            .step {
                font-size: 10px;
            }

            .title-section h1 {
                font-size: 30px;
            }

            .camera-frame {
                width: 100%;

                border-radius: 18px;
            }

            .button {
                width: 100%;

                max-width: 320px;
            }
        }

        @media (max-width: 480px) {

            .title-section p {
                font-size: 13px;
            }

            .camera-frame {
                border-radius: 14px;
            }

            .actions {
                width: 100%;
            }
        }

        /* =========================
           STARFIELD
        ========================= */

        .header,
        .title-section,
        .selected-theme,
        .camera-wrapper,
        .back-button {
            position: relative;
            z-index: 2;
        }

        .capture-stars {
            position: absolute;
            inset: 0;
            z-index: 1;
            pointer-events: none;
        }

        .capture-star {
            position: absolute;
            width: 3px;
            height: 3px;
            border-radius: 50%;
            background: #ffffff;
            box-shadow:
                0 0 7px #ffffff,
                0 0 14px #62baff;
            animation:
                cameraTwinkle
                3s
                ease-in-out
                infinite;
        }

        .capture-star:nth-child(1)  { top: 8%;  left: 8%; }
        .capture-star:nth-child(2)  { top: 15%; left: 23%; animation-delay: .8s; }
        .capture-star:nth-child(3)  { top: 7%;  left: 48%; animation-delay: 1.2s; }
        .capture-star:nth-child(4)  { top: 12%; right: 27%; animation-delay: 1.8s; }
        .capture-star:nth-child(5)  { top: 9%;  right: 8%; animation-delay: .5s; }
        .capture-star:nth-child(6)  { top: 28%; left: 13%; animation-delay: 1.5s; }
        .capture-star:nth-child(7)  { top: 25%; right: 12%; animation-delay: 2s; }
        .capture-star:nth-child(8)  { top: 43%; left: 5%; animation-delay: .3s; }
        .capture-star:nth-child(9)  { top: 40%; right: 7%; animation-delay: 1.4s; }
        .capture-star:nth-child(10) { top: 55%; left: 18%; animation-delay: 2.3s; }
        .capture-star:nth-child(11) { top: 60%; right: 17%; animation-delay: .9s; }
        .capture-star:nth-child(12) { top: 76%; left: 9%; animation-delay: 1.6s; }
        .capture-star:nth-child(13) { top: 82%; left: 32%; animation-delay: .6s; }
        .capture-star:nth-child(14) { top: 72%; right: 30%; animation-delay: 1.9s; }
        .capture-star:nth-child(15) { top: 85%; right: 9%; animation-delay: 2.4s; }

        @keyframes cameraTwinkle {
            0%,
            100% {
                opacity: .3;
                transform: scale(.7);
            }
            50% {
                opacity: 1;
                transform: scale(1.7);
            }
        }

        /* =========================
           SHOOTING STARS
        ========================= */

        .shooting-star {
            position: absolute;
            z-index: 1;
            width: 90px;
            height: 2px;
            border-radius: 999px;
            background:
                linear-gradient(
                    90deg,
                    transparent,
                    rgba(255, 255, 255, .25),
                    white
                );
            transform: rotate(-35deg);
            opacity: 0;
            pointer-events: none;
            filter:
                drop-shadow(0 0 5px #ffffff);
            animation:
                shootingStar
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
            background: white;
            box-shadow:
                0 0 8px white,
                0 0 15px #52aaff;
        }

        .shooting-one   { top: 13%; left: 15%; }
        .shooting-two   { top: 19%; right: 20%; animation-delay: 2.5s; }
        .shooting-three { top: 54%; right: 8%; animation-delay: 5s; }

        @keyframes shootingStar {
            0% {
                opacity: 0;
                transform:
                    translate(0, 0)
                    rotate(-35deg);
            }
            5% {
                opacity: 1;
            }
            18% {
                opacity: 1;
                transform:
                    translate(-170px, 110px)
                    rotate(-35deg);
            }
            20%,
            100% {
                opacity: 0;
                transform:
                    translate(-210px, 140px)
                    rotate(-35deg);
            }
        }
    </style>
</head>

<body>

        <div class="camera-page">

        <div class="capture-stars">

            @for ($i = 0; $i < 15; $i++)
                <span class="capture-star"></span>
            @endfor

        </div>

        <span class="shooting-star shooting-one"></span>
        <span class="shooting-star shooting-two"></span>
        <span class="shooting-star shooting-three"></span>

    <!-- =========================
         HEADER
    ========================== -->

    <header class="header">

        <div class="logo">
            RUPAVUE
        </div>

        <div class="step">
            STEP 2 OF 3
        </div>

    </header>


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


        <!-- Buttons -->

        <div class="actions">

            <button
                type="button"
                class="button capture-button"
                id="captureButton"
                disabled
            >
                📷 Capture Photo
            </button>

            <span class="or-text">
                OR
            </span>

            <button
                type="button"
                class="button upload-button"
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
                class="button retake-button"
                id="retakeButton"
            >
                ↻ Retake
            </button>

            <button
                type="button"
                class="button continue-button"
                id="continueButton"
            >
                Continue →
            </button>

        </div>


        <!-- Back -->

        <div class="back-button">

            <a href="{{ route('photobooth.scene') }}">
                ← Change Theme
            </a>

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
                * 2:3 portrait
                */

                const targetRatio =
                    2 / 3;


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
                * Crop image to 2:3
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
                    800;

                const outputHeight =
                    1200;


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

                uploadButton.style.display =
                    'none';


                document
                    .querySelector('.or-text')
                    .style.display =
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
            2 / 3;

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
            800;

        const outputHeight =
            1200;


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
            * Clear uploaded file
            */

            imageUpload.value =
                '';


            /*
            * Show camera
            */

            video.style.display =
                'block';


            /*
            * Show capture/upload buttons
            */

            captureButton.style.display =
                'inline-flex';

            uploadButton.style.display =
                'inline-flex';


            document
                .querySelector('.or-text')
                .style.display =
                'inline';


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