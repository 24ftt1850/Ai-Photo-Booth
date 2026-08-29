<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Choose Theme - RupaVue</title>

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
           MAIN CONTAINER
        ========================= */

        .theme-page {
            min-height: 100vh;
            width: 100%;

            background:
                linear-gradient(
                    rgba(0, 0, 0, 0.55),
                    rgba(0, 0, 0, 0.75)
                ),
                url('/images/demo-background.jpg');

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;

            padding: 35px 5% 45px;

            display: flex;
            flex-direction: column;
        }

        /* =========================
           HEADER
        ========================= */

        .header {
            width: 100%;

            display: flex;
            align-items: center;
            justify-content: space-between;

            margin-bottom: 40px;
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

            color: rgba(255, 255, 255, 0.7);
        }

        /* =========================
           TITLE
        ========================= */

        .title-section {
            text-align: center;

            margin-bottom: 45px;
        }

        .title-section h1 {
            font-size: clamp(30px, 4vw, 52px);

            font-weight: 700;

            letter-spacing: 1px;

            margin-bottom: 12px;
        }

        .title-section p {
            font-size: 16px;

            color: rgba(255, 255, 255, 0.72);

            line-height: 1.5;
        }

        /* =========================
           THEME GRID
        ========================= */

        .theme-container {
            width: 100%;
            max-width: 1200px;

            margin: 0 auto;

            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 25px;
        }

        /* =========================
           THEME CARD
        ========================= */

        .theme-card {
            position: relative;

            height: 390px;

            border-radius: 22px;

            overflow: hidden;

            cursor: pointer;

            border: 2px solid rgba(255, 255, 255, 0.2);

            background: rgba(255, 255, 255, 0.08);

            backdrop-filter: blur(5px);

            transition:
                transform 0.25s ease,
                border-color 0.25s ease,
                box-shadow 0.25s ease;
        }

        .theme-card:hover {
            transform: translateY(-8px);

            border-color: rgba(255, 255, 255, 0.7);

            box-shadow:
                0 15px 40px rgba(0, 0, 0, 0.4);
        }

        /*
         * Selected card
         */

        .theme-card.selected {
            border-color: white;

            box-shadow:
                0 0 0 3px rgba(255, 255, 255, 0.25),
                0 15px 40px rgba(0, 0, 0, 0.45);

            transform: translateY(-8px);
        }

        /* =========================
           PLACEHOLDER IMAGE
        ========================= */

        .theme-image {
            position: absolute;

            inset: 0;

            width: 100%;
            height: 100%;

            object-fit: cover;

            z-index: 0;
        }

        /*
         * Temporary theme backgrounds
         */

        .graduation-background {
            background:
                linear-gradient(
                    135deg,
                    #172554,
                    #1e3a8a
                );
        }

        .mafia-background {
            background:
                linear-gradient(
                    135deg,
                    #090909,
                    #252525
                );
        }

        .kdrama-background {
            background:
                linear-gradient(
                    135deg,
                    #4c1d95,
                    #be185d
                );
        }

        /* =========================
           CARD OVERLAY
        ========================= */

        .theme-overlay {
            position: absolute;

            inset: 0;

            z-index: 1;

            background:
                linear-gradient(
                    transparent 25%,
                    rgba(0, 0, 0, 0.9) 100%
                );
        }

        /* =========================
           THEME CONTENT
        ========================= */

        .theme-content {
            position: absolute;

            left: 0;
            right: 0;
            bottom: 0;

            z-index: 2;

            padding: 30px;
        }

        .theme-icon {
            font-size: 42px;

            margin-bottom: 15px;
        }

        .theme-name {
            font-size: 26px;

            font-weight: 700;

            letter-spacing: 1px;

            text-transform: uppercase;

            margin-bottom: 8px;
        }

        .theme-description {
            font-size: 14px;

            line-height: 1.5;

            color: rgba(255, 255, 255, 0.72);
        }

        /* =========================
           SELECTED CHECK
        ========================= */

        .check {
            position: absolute;

            top: 20px;
            right: 20px;

            width: 42px;
            height: 42px;

            border-radius: 50%;

            background: white;

            color: #111;

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 20px;
            font-weight: bold;

            opacity: 0;

            transform: scale(0.6);

            transition:
                opacity 0.2s ease,
                transform 0.2s ease;

            z-index: 3;
        }

        .theme-card.selected .check {
            opacity: 1;

            transform: scale(1);
        }

        /* =========================
           BOTTOM
        ========================= */

        .bottom-section {
            width: 100%;

            max-width: 1200px;

            margin: 45px auto 0;

            display: flex;

            align-items: center;

            justify-content: space-between;
        }

        .selected-theme {
            font-size: 14px;

            color: rgba(255, 255, 255, 0.65);
        }

        .selected-theme strong {
            color: white;
        }

        .next-button {
            min-width: 210px;

            padding: 16px 28px;

            border: 2px solid rgba(255, 255, 255, 0.25);

            border-radius: 50px;

            background: rgba(255, 255, 255, 0.1);

            color: white;

            font-size: 14px;

            font-weight: 700;

            letter-spacing: 1.5px;

            text-transform: uppercase;

            cursor: pointer;

            transition:
                background 0.25s ease,
                color 0.25s ease,
                transform 0.25s ease;
        }

        .next-button:hover:not(:disabled) {
            background: white;

            color: #111;

            transform: translateY(-2px);
        }

        .next-button:disabled {
            opacity: 0.35;

            cursor: not-allowed;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 900px) {

            .theme-container {
                grid-template-columns: 1fr;
                max-width: 500px;
            }

            .theme-card {
                height: 300px;
            }

            .bottom-section {
                flex-direction: column;

                gap: 20px;
            }

            .next-button {
                width: 100%;
            }
        }

        @media (max-width: 500px) {

            .theme-page {
                padding: 25px 20px 35px;
            }

            .header {
                margin-bottom: 30px;
            }

            .logo {
                font-size: 19px;
            }

            .step {
                font-size: 10px;
            }

            .title-section {
                margin-bottom: 30px;
            }

            .title-section h1 {
                font-size: 30px;
            }

            .title-section p {
                font-size: 14px;
            }

            .theme-card {
                height: 280px;

                border-radius: 18px;
            }

            .theme-content {
                padding: 22px;
            }

            .theme-name {
                font-size: 22px;
            }
        }
    </style>
</head>

<body>

<div class="theme-page">

    <!-- =========================
         HEADER
    ========================== -->

    <header class="header">

        <div class="logo">
            RUPAVUE
        </div>

        <div class="step">
            STEP 1 OF 3
        </div>

    </header>


    <!-- =========================
         TITLE
    ========================== -->

    <section class="title-section">

        <h1>
            Choose Your Theme
        </h1>

        <p>
            Select a theme for your AI photo transformation.
        </p>

    </section>


    <!-- =========================
         THEME CARDS
    ========================== -->

    <form
        id="themeForm"
        method="GET"
        action="{{ route('photobooth.create') }}"
    >

        <div class="theme-container">

            <!-- =====================
                 GRADUATION
            ====================== -->

            <div
                class="theme-card"
                data-theme="Graduation"
                data-theme-id="{{ $themes->firstWhere('name', 'Graduation')->id ?? '' }}"
            >

                <div class="theme-image graduation-background"></div>

                <div class="theme-overlay"></div>

                <div class="check">
                    ✓
                </div>

                <div class="theme-content">

                    <div class="theme-icon">
                        🎓
                    </div>

                    <div class="theme-name">
                        Graduation
                    </div>

                    <div class="theme-description">
                        Celebrate your special achievement with
                        a memorable graduation photo.
                    </div>

                </div>

            </div>


            <!-- =====================
                 MAFIA
            ====================== -->

            <div
                class="theme-card"
                data-theme="Mafia"
                data-theme-id="{{ $themes->firstWhere('name', 'Mafia')->id ?? '' }}"
            >

                <div class="theme-image mafia-background"></div>

                <div class="theme-overlay"></div>

                <div class="check">
                    ✓
                </div>

                <div class="theme-content">

                    <div class="theme-icon">
                        🕴️
                    </div>

                    <div class="theme-name">
                        Mafia
                    </div>

                    <div class="theme-description">
                        Step into a powerful cinematic
                        underworld-inspired atmosphere.
                    </div>

                </div>

            </div>


            <!-- =====================
                 K-DRAMA
            ====================== -->

            <div
                class="theme-card"
                data-theme="K-Drama"
                data-theme-id="{{ $themes->firstWhere('name', 'K-Drama')->id ?? '' }}"
            >

                <div class="theme-image kdrama-background"></div>

                <div class="theme-overlay"></div>

                <div class="check">
                    ✓
                </div>

                <div class="theme-content">

                    <div class="theme-icon">
                        🎬
                    </div>

                    <div class="theme-name">
                        K-Drama
                    </div>

                    <div class="theme-description">
                        Create a dramatic and stylish
                        K-Drama-inspired portrait.
                    </div>

                </div>

            </div>

        </div>


        <!-- Hidden theme input -->

        <input
            type="hidden"
            name="theme"
            id="selectedTheme"
            value=""
        >

        <input
            type="hidden"
            name="theme_id"
            id="selectedThemeId"
            value=""
        >


        <!-- =========================
             BOTTOM
        ========================== -->

        <div class="bottom-section">

            <div class="selected-theme">
                Selected:
                <strong id="selectedThemeText">
                    None
                </strong>
            </div>

            <button
                type="submit"
                class="next-button"
                id="nextButton"
                disabled
            >
                Next: Capture Photo →
            </button>

        </div>

    </form>

</div>


<script>

    const themeCards =
        document.querySelectorAll('.theme-card');

    const selectedTheme =
        document.getElementById('selectedTheme');

    const selectedThemeId =
        document.getElementById('selectedThemeId');

    const selectedThemeText =
        document.getElementById('selectedThemeText');

    const nextButton =
        document.getElementById('nextButton');


    themeCards.forEach(card => {

        card.addEventListener('click', function () {

            /*
             * Remove previous selection
             */

            themeCards.forEach(item => {
                item.classList.remove('selected');
            });


            /*
             * Select current card
             */

            this.classList.add('selected');


            /*
             * Get theme information
             */

            const themeName =
                this.dataset.theme;

            const themeId =
                this.dataset.themeId;


            /*
             * Store selected theme
             */

            selectedTheme.value =
                themeName;

            selectedThemeId.value =
                themeId;


            /*
             * Update text
             */

            selectedThemeText.textContent =
                themeName;


            /*
             * Enable button
             */

            nextButton.disabled = false;

        });

    });

</script>

</body>
</html>