<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Choose Your Frame - RupaVue</title>

    <style>

        /* =====================================================
           RESET
        ===================================================== */

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
            font-family:
                "Arial Black",
                Arial,
                Helvetica,
                sans-serif;

            color: #ffffff;

            font-weight: 700;

            overflow-x: hidden;

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
        }


        /* =====================================================
           BACKGROUND (selected theme, dimmed)
        ===================================================== */

        .rv-background {
            position: fixed;
            inset: 0;
            z-index: -10;
            pointer-events: none;

            background-size: cover;
            background-position: center;
        }

        .rv-background::after {
            content: "";
            position: absolute;
            inset: 0;

            background:
                radial-gradient(
                    circle at 50% 45%,
                    rgba(1, 8, 23, 0.55),
                    rgba(1, 6, 17, 0.92) 70%
                );
        }


        /* =====================================================
           PAGE
        ===================================================== */

        .frame-page {
            width: 100%;
            min-height: 100vh;
            min-height: 100dvh;

            padding: 28px 5vw 140px;

            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .frame-header {
            text-align: center;
            margin: 24px 0 36px;
        }

        .frame-header h1 {
            font-size: clamp(38px, 5vw, 64px);
            font-weight: 800;
            margin-bottom: 10px;

            text-shadow:
                0 0 10px rgba(255,255,255,.18),
                0 0 28px rgba(0,102,255,.28);
        }

        .frame-header p {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 18px;
            color: rgba(255,255,255,.7);
        }


        /* =====================================================
           FRAME GRID
        ===================================================== */

        .frame-grid {
            width: min(1400px, 100%);

            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 340px));
            justify-content: center;
            gap: 32px;
        }

        .frame-card {
            position: relative;

            display: flex;
            flex-direction: column;

            border: 2px solid rgba(255,255,255,.18);
            border-radius: 28px;

            padding: 18px;

            background:
                linear-gradient(
                    135deg,
                    rgba(255,255,255,.12),
                    rgba(80,170,255,.06)
                );

            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);

            color: inherit;
            font: inherit;
            text-align: left;

            cursor: pointer;

            transition:
                transform .25s ease,
                border-color .25s ease,
                box-shadow .25s ease;
        }

        .frame-card:hover {
            transform: translateY(-4px);
        }

        .frame-card.is-selected {
            border-color: #7cc4ff;

            box-shadow:
                0 0 30px rgba(40,165,255,.75),
                0 0 70px rgba(0,140,255,.35);

            transform: scale(1.03);
        }

        .frame-preview {
            aspect-ratio: 1 / 1;

            border-radius: 18px;

            overflow: hidden;

            display: flex;
            align-items: center;
            justify-content: center;

            /* Checkerboard so transparent frame areas are visible */
            background:
                repeating-conic-gradient(
                    rgba(255,255,255,.10) 0% 25%,
                    rgba(255,255,255,.03) 0% 50%
                ) 50% / 28px 28px;
        }

        .frame-preview img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .frame-name {
            margin-top: 16px;
            font-size: 22px;
        }

        .frame-description {
            margin-top: 6px;

            font-family: Arial, Helvetica, sans-serif;
            font-size: 15px;
            font-weight: 400;
            color: rgba(255,255,255,.65);
        }

        .frame-check {
            position: absolute;
            top: 28px;
            right: 28px;

            width: 44px;
            height: 44px;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #ffffff;
            color: #0a2a5c;
            font-size: 22px;

            opacity: 0;
            transform: scale(.6);

            transition: .25s ease;
        }

        .frame-card.is-selected .frame-check {
            opacity: 1;
            transform: scale(1);
        }


        /* =====================================================
           ACTIONS
        ===================================================== */

        .action-bar {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 28px;

            display: flex;
            justify-content: center;

            pointer-events: none;
        }

        .next-button {
            pointer-events: auto;

            min-width: 440px;

            border: none;
            border-radius: 999px;

            padding: 30px 64px;

            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;

            background: linear-gradient(135deg, #ffffff, #dfe7f2);

            color: #0a2a5c;

            font-family: inherit;
            font-size: 23px;
            font-weight: 800;
            letter-spacing: 1.5px;

            cursor: pointer;

            box-shadow:
                0 0 35px rgba(40,165,255,.95),
                0 0 80px rgba(0,140,255,.55),
                0 14px 35px rgba(0,30,90,.35),
                inset 0 1px 0 rgba(255,255,255,.9);

            transition: .25s ease;
        }

        .next-button:disabled {
            opacity: .45;
            cursor: not-allowed;
            box-shadow: none;
        }

        .top-nav {
            position: fixed;
            left: 35px;
            bottom: 28px;
            z-index: 999;
        }

        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 150px;
            height: 62px;

            border-radius: 999px;

            color: #ffffff;

            background:
                linear-gradient(
                    135deg,
                    rgba(255,255,255,0.24),
                    rgba(80,170,255,0.12)
                );

            border: 1px solid rgba(255,255,255,0.65);

            backdrop-filter: blur(16px) saturate(140%);
            -webkit-backdrop-filter: blur(16px) saturate(140%);

            box-shadow:
                0 10px 30px rgba(0,25,80,0.45),
                inset 0 1px 0 rgba(255,255,255,0.75);

            font-size: 17px;
            letter-spacing: 0.5px;

            text-decoration: none;
        }

        @media (max-width: 700px) {

            .frame-page {
                padding-bottom: 200px;
            }

            .next-button {
                min-width: 0;
                width: calc(100vw - 32px);
                padding: 22px 32px;
                font-size: 18px;
            }

            .action-bar {
                bottom: 100px;
            }

            .top-nav {
                left: 16px;
            }
        }

    </style>
</head>

<body>

    <div
        class="rv-background"
        @if ($theme->thumbnail_url)
            style="background-image: url('{{ $theme->thumbnail_url }}');"
        @endif
    ></div>


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


<div class="frame-page">

    <header class="frame-header">

        <h1>
            Choose Your Frame
        </h1>

        <p>
            {{ $theme->theme_name }} · pick a frame for your photo
        </p>

    </header>


    <!-- =====================================================
         FRAMES (active frames stored in Google Drive)
    ====================================================== -->

    <div class="frame-grid">

        @foreach ($frames as $frame)

            <button
                type="button"
                class="frame-card"
                data-frame-id="{{ $frame->id }}"
                data-frame-name="{{ $frame->frame_name }}"
                aria-pressed="false"
            >

                <span class="frame-check">✓</span>

                <span class="frame-preview">
                    <img
                        src="{{ $frame->previewUrl() }}"
                        alt="{{ $frame->frame_name }}"
                        loading="lazy"
                    >
                </span>

                <span class="frame-name">
                    {{ $frame->frame_name }}
                </span>

                @if ($frame->description)
                    <span class="frame-description">
                        {{ $frame->description }}
                    </span>
                @endif

            </button>

        @endforeach

    </div>

</div>


<div class="action-bar">

    <button
        type="button"
        class="next-button"
        id="nextButton"
        disabled
    >
        <span>
            CAPTURE PHOTO
        </span>

        <span>
            →
        </span>
    </button>

</div>


<script>

    const frameCards =
        document.querySelectorAll('.frame-card');

    const nextButton =
        document.getElementById('nextButton');

    let selectedFrameId = null;


    function selectFrame(card) {

        frameCards.forEach(function (otherCard) {

            const isSelected = otherCard === card;

            otherCard.classList.toggle('is-selected', isSelected);

            otherCard.setAttribute('aria-pressed', isSelected ? 'true' : 'false');

        });

        selectedFrameId = card.dataset.frameId;

        nextButton.disabled = false;

        sessionStorage.setItem('rupavueFrameId', selectedFrameId);

        sessionStorage.setItem('rupavueFrameName', card.dataset.frameName);

    }


    frameCards.forEach(function (card) {

        card.addEventListener('click', function () {
            selectFrame(card);
        });

    });


    /*
     * Re-select the frame chosen earlier in this session,
     * or the only frame when there is just one.
     */
    const previousFrameCard =
        document.querySelector(
            '.frame-card[data-frame-id="' + sessionStorage.getItem('rupavueFrameId') + '"]'
        );

    if (previousFrameCard) {
        selectFrame(previousFrameCard);
    } else if (frameCards.length === 1) {
        selectFrame(frameCards[0]);
    }


    nextButton.addEventListener('click', function () {

        if (!selectedFrameId) {
            return;
        }

        window.rupavueClickSound.goTo(
            @json(route('photobooth.create', ['theme_id' => $theme->id]))
        );

    });

</script>

@include('partials.click-sound')

</body>
</html>
