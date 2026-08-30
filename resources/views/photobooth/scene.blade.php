<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Choose Theme - RupaVue</title>


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
                Arial,
                Helvetica,
                sans-serif;

            background: #f6e8df;

            color: #003f42;

            overflow-x: hidden;

        }


        /* =====================================================
           PAGE ENTRANCE ANIMATION
        ===================================================== */

        body {

            animation:
                pageEnter
                0.7s
                ease-out
                both;

        }


        @keyframes pageEnter {

            0% {

                opacity: 0;

                transform:
                    scale(1.035);

                filter:
                    blur(6px);

            }

            55% {

                opacity: 0.85;

                transform:
                    scale(1.01);

                filter:
                    blur(2px);

            }

            100% {

                opacity: 1;

                transform:
                    scale(1);

                filter:
                    blur(0);

            }

        }


        /* =====================================================
           MAIN PAGE
        ===================================================== */

        .theme-page {

            position: relative;

            min-height: 100vh;

            width: 100%;

            overflow: hidden;

            background:

                radial-gradient(
                    circle at 50% 35%,
                    #fffdfb 0%,
                    #fdf3ed 35%,
                    #f8e9e1 70%,
                    #f1ddd3 100%
                );

            padding:
                28px
                4%
                35px;

            display: flex;

            flex-direction: column;

        }


        /* =====================================================
           SOFT BACKGROUND GLOWS
        ===================================================== */

        .theme-page::before {

            content: "";

            position: absolute;

            width: 420px;

            height: 420px;

            top: -220px;

            left: -150px;

            border-radius: 50%;

            background:

                radial-gradient(
                    circle,
                    rgba(255, 171, 177, 0.32),
                    transparent 70%
                );

            filter: blur(10px);

            pointer-events: none;

            animation:
                backgroundFloatOne
                12s
                ease-in-out
                infinite;

        }


        .theme-page::after {

            content: "";

            position: absolute;

            width: 450px;

            height: 450px;

            right: -180px;

            bottom: -230px;

            border-radius: 50%;

            background:

                radial-gradient(
                    circle,
                    rgba(175, 206, 255, 0.28),
                    transparent 70%
                );

            filter: blur(10px);

            pointer-events: none;

            animation:
                backgroundFloatTwo
                15s
                ease-in-out
                infinite;

        }


        @keyframes backgroundFloatOne {

            0%,
            100% {

                transform:
                    translate(0, 0)
                    scale(1);

            }

            50% {

                transform:
                    translate(60px, 45px)
                    scale(1.1);

            }

        }


        @keyframes backgroundFloatTwo {

            0%,
            100% {

                transform:
                    translate(0, 0)
                    scale(1);

            }

            50% {

                transform:
                    translate(-50px, -40px)
                    scale(1.08);

            }

        }


        /* =====================================================
           TOP NAV
        ===================================================== */

        .top-nav {

            position: relative;

            z-index: 5;

            margin-bottom: 15px;

        }


        .back-link {

            display: inline-flex;

            align-items: center;

            gap: 6px;

            color: #426466;

            text-decoration: none;

            font-size: 13px;

            font-weight: 600;

            letter-spacing: 0.5px;

            transition:
                color 0.2s ease,
                transform 0.2s ease;

        }


        .back-link:hover {

            color: #003f42;

            transform:
                translateX(-3px);

        }


        /* =====================================================
           HEADER
        ===================================================== */

        .header {

            position: relative;

            z-index: 5;

            width: 100%;

            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-bottom: 22px;

        }


        .logo {

            font-size: 25px;

            font-weight: 800;

            color: #003f42;

            letter-spacing: 2px;

        }


        .logo::before {

            content: "";

            display: inline-block;

            width: 10px;

            height: 10px;

            margin-right: 8px;

            border-radius: 50%;

            background: #ff9da5;

            box-shadow:
                0 0 10px
                rgba(255, 157, 165, 0.45);

        }


        .step {

            padding:
                7px
                13px;

            border-radius: 20px;

            background:
                rgba(0, 63, 66, 0.07);

            color: #426466;

            font-size: 11px;

            font-weight: 700;

            letter-spacing: 1px;

        }


        /* =====================================================
           TITLE
        ===================================================== */

        .title-section {

            position: relative;

            z-index: 5;

            text-align: center;

            margin-bottom: 28px;

        }


        .title-section h1 {

            color: #003f42;

            font-size:
                clamp(
                    30px,
                    4vw,
                    48px
                );

            font-weight: 800;

            letter-spacing: -1px;

            margin-bottom: 8px;

        }


        .title-section h1 span {

            color: #ff8e98;

        }


        .title-section p {

            color: #718384;

            font-size: 14px;

            line-height: 1.5;

        }


        /* =====================================================
           THEME GRID
        ===================================================== */

        .theme-container {

            position: relative;

            z-index: 5;

            width: 100%;

            max-width: 1200px;

            margin: 0 auto;

            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 22px;

        }


        /* =====================================================
           THEME CARD
        ===================================================== */

        .theme-card {

            position: relative;

            height: 350px;

            border-radius: 20px;

            overflow: hidden;

            cursor: pointer;

            border:
                2px solid
                rgba(255, 255, 255, 0.9);

            background: white;

            box-shadow:
                0 8px 25px
                rgba(0, 50, 60, 0.08);

            transition:
                transform 0.3s ease,
                border-color 0.3s ease,
                box-shadow 0.3s ease;

            animation:
                cardEnter
                0.65s
                ease-out
                both;

        }


        .theme-card:nth-child(1) {

            animation-delay:
                0.15s;

        }


        .theme-card:nth-child(2) {

            animation-delay:
                0.25s;

        }


        .theme-card:nth-child(3) {

            animation-delay:
                0.35s;

        }


        @keyframes cardEnter {

            from {

                opacity: 0;

                transform:
                    translateY(25px);

            }

            to {

                opacity: 1;

                transform:
                    translateY(0);

            }

        }


        .theme-card:hover {

            transform:
                translateY(-7px);

            border-color:
                #5b9ca0;

            box-shadow:

                0 18px 35px
                rgba(0, 50, 60, 0.15);

        }


        /* =====================================================
           SELECTED CARD
        ===================================================== */

        .theme-card.selected {

            border-color:
                #003f42;

            box-shadow:

                0 0 0 3px
                rgba(0, 63, 66, 0.12),

                0 18px 40px
                rgba(0, 63, 66, 0.18);

            transform:
                translateY(-7px);

        }


        /* =====================================================
           THEME IMAGE / BACKGROUND
        ===================================================== */

        .theme-image {

            position: absolute;

            inset: 0;

            width: 100%;

            height: 100%;

            z-index: 0;

            transition:
                transform 0.5s ease;

        }


        .theme-card:hover
        .theme-image {

            transform:
                scale(1.06);

        }


        /* =====================================================
           GRADUATION
        ===================================================== */

        .graduation-background {

            background:

                radial-gradient(
                    circle at 70% 25%,
                    rgba(255,255,255,0.35),
                    transparent 20%
                ),

                linear-gradient(
                    135deg,
                    #172554,
                    #2563a8 55%,
                    #60a5fa
                );

        }


        /* =====================================================
           MAFIA
        ===================================================== */

        .mafia-background {

            background:

                radial-gradient(
                    circle at 70% 30%,
                    rgba(130, 130, 130, 0.18),
                    transparent 25%
                ),

                linear-gradient(
                    135deg,
                    #070707,
                    #161616 50%,
                    #363636
                );

        }


        /* =====================================================
           K-DRAMA
        ===================================================== */

        .kdrama-background {

            background:

                radial-gradient(
                    circle at 25% 25%,
                    rgba(255,255,255,0.3),
                    transparent 22%
                ),

                linear-gradient(
                    135deg,
                    #4c1d95,
                    #9d174d 50%,
                    #ec4899
                );

        }


        /* =====================================================
           CARD OVERLAY
        ===================================================== */

        .theme-overlay {

            position: absolute;

            inset: 0;

            z-index: 1;

            background:

                linear-gradient(
                    to bottom,
                    rgba(0,0,0,0.02) 15%,
                    rgba(0,0,0,0.12) 45%,
                    rgba(0,0,0,0.82) 100%
                );

        }


        /* =====================================================
           THEME CONTENT
        ===================================================== */

        .theme-content {

            position: absolute;

            left: 0;

            right: 0;

            bottom: 0;

            z-index: 2;

            padding: 25px;

            color: white;

        }


        .theme-icon {

            width: 52px;

            height: 52px;

            display: flex;

            align-items: center;

            justify-content: center;

            margin-bottom: 12px;

            border-radius: 15px;

            background:
                rgba(255,255,255,0.16);

            border:
                1px solid
                rgba(255,255,255,0.25);

            backdrop-filter:
                blur(8px);

            font-size: 27px;

            transition:
                transform 0.25s ease;

        }


        .theme-card:hover
        .theme-icon {

            transform:
                scale(1.08)
                rotate(-3deg);

        }


        .theme-name {

            font-size: 24px;

            font-weight: 800;

            letter-spacing: 0.5px;

            text-transform: uppercase;

            margin-bottom: 7px;

        }


        .theme-description {

            font-size: 13px;

            line-height: 1.5;

            color:
                rgba(255,255,255,0.78);

            max-width: 310px;

        }


        /* =====================================================
           SELECTED CHECK
        ===================================================== */

        .check {

            position: absolute;

            top: 18px;

            right: 18px;

            width: 44px;

            height: 44px;

            border-radius: 50%;

            background:
                #ffffff;

            color:
                #003f42;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 21px;

            font-weight: 900;

            opacity: 0;

            transform:
                scale(0.5);

            box-shadow:
                0 8px 20px
                rgba(0,0,0,0.2);

            transition:
                opacity 0.25s ease,
                transform 0.25s ease;

            z-index: 3;

        }


        .theme-card.selected .check {

            opacity: 1;

            transform:
                scale(1);

        }


        /* =====================================================
           BOTTOM SECTION
        ===================================================== */

        .bottom-section {

            position: relative;

            z-index: 5;

            width: 100%;

            max-width: 1200px;

            margin: 25px auto 0;

            padding:
                15px
                18px;

            border-radius: 16px;

            background:
                rgba(255,255,255,0.72);

            border:
                1px solid
                rgba(255,255,255,0.9);

            box-shadow:
                0 8px 25px
                rgba(0, 50, 60, 0.06);

            backdrop-filter:
                blur(10px);

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

        }


        .selected-theme {

            font-size: 14px;

            color: #718384;

        }


        .selected-theme strong {

            color: #003f42;

            margin-left: 5px;

        }


        /* =====================================================
           NEXT BUTTON
        ===================================================== */

        .next-button {

            min-width: 220px;

            padding:
                15px
                25px;

            border:
                2px solid
                #003f42;

            border-radius: 50px;

            background:
                #003f42;

            color: white;

            font-size: 13px;

            font-weight: 700;

            letter-spacing: 1.2px;

            text-transform: uppercase;

            cursor: pointer;

            box-shadow:
                0 8px 20px
                rgba(0, 63, 66, 0.18);

            transition:
                background 0.25s ease,
                transform 0.25s ease,
                box-shadow 0.25s ease;

        }


        .next-button:hover:not(:disabled) {

            background:
                #00575a;

            transform:
                translateY(-2px);

            box-shadow:
                0 12px 25px
                rgba(0, 63, 66, 0.25);

        }


        .next-button:active:not(:disabled) {

            transform:
                translateY(0);

        }


        .next-button:disabled {

            opacity: 0.35;

            cursor: not-allowed;

            box-shadow: none;

        }


        /* =====================================================
           PAGE TRANSITION
        ===================================================== */

        .page-transition {

            position: fixed;

            inset: 0;

            z-index: 9999;

            pointer-events: none;

            opacity: 0;

            visibility: hidden;

            background:

                radial-gradient(
                    circle at center,
                    #ffffff 0%,
                    #eef7ff 24%,
                    #c8e0ff 52%,
                    #5791e5 100%
                );

            transform:
                scale(1);

            transition:
                opacity 0.45s ease,
                transform 0.6s ease,
                visibility 0.45s ease;

        }


        .page-transition.active {

            opacity: 1;

            visibility: visible;

            transform:
                scale(1.08);

        }


        /* =====================================================
           EXPANDING GLOW
        ===================================================== */

        .page-transition::before {

            content: "";

            position: absolute;

            width: 100px;

            height: 100px;

            left: 50%;

            top: 50%;

            transform:
                translate(-50%, -50%)
                scale(0);

            border-radius: 50%;

            background:

                radial-gradient(
                    circle,
                    rgba(255,255,255,0.98) 0%,
                    rgba(90,170,255,0.7) 35%,
                    rgba(30,110,220,0.3) 65%,
                    transparent 76%
                );

            filter:
                blur(10px);

            opacity: 0;

        }


        .page-transition.active::before {

            animation:
                transitionGlow
                0.65s
                ease-out
                forwards;

        }


        @keyframes transitionGlow {

            0% {

                transform:
                    translate(-50%, -50%)
                    scale(0);

                opacity: 0;

            }

            25% {

                opacity: 1;

            }

            100% {

                transform:
                    translate(-50%, -50%)
                    scale(25);

                opacity: 1;

            }

        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 950px) {

            .theme-container {

                grid-template-columns:
                    repeat(2, 1fr);

                max-width: 800px;

            }


            .theme-card {

                height: 330px;

            }

        }


        @media (max-width: 700px) {

            .theme-page {

                padding:
                    22px
                    20px
                    30px;

            }


            .header {

                margin-bottom: 20px;

            }


            .logo {

                font-size: 20px;

            }


            .step {

                font-size: 9px;

                padding:
                    6px
                    10px;

            }


            .theme-container {

                grid-template-columns: 1fr;

                max-width: 500px;

            }


            .theme-card {

                height: 280px;

            }


            .bottom-section {

                flex-direction: column;

                align-items: stretch;

            }


            .selected-theme {

                text-align: center;

            }


            .next-button {

                width: 100%;

            }

        }


        @media (max-width: 480px) {

            .title-section {

                margin-bottom: 20px;

            }


            .title-section h1 {

                font-size: 28px;

            }


            .title-section p {

                font-size: 13px;

            }


            .theme-card {

                height: 260px;

                border-radius: 18px;

            }


            .theme-content {

                padding: 20px;

            }


            .theme-name {

                font-size: 20px;

            }


            .theme-description {

                font-size: 12px;

            }

        }


        /* =====================================================
           REDUCED MOTION
        ===================================================== */

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {

                animation-duration: 0.01ms !important;

                animation-iteration-count: 1 !important;

                transition-duration: 0.01ms !important;

            }

        }

    </style>

</head>


<body>


    <!-- =====================================================
         PAGE TRANSITION
    ====================================================== -->

    <div class="page-transition"></div>


    <!-- =====================================================
         MAIN PAGE
    ====================================================== -->

    <div class="theme-page">


        <!-- =================================================
             BACK
        ================================================== -->

        <div class="top-nav">

            <a
                href="{{ route('home') }}"
                class="back-link"
            >
                ← Back
            </a>

        </div>


        <!-- =================================================
             HEADER
        ================================================== -->

        <header class="header">

            <div class="logo">
                RupaVue
            </div>

            <div class="step">
                STEP 1 OF 3
            </div>

        </header>


        <!-- =================================================
             TITLE
        ================================================== -->

        <section class="title-section">

            <h1>
                Choose Your Theme
            </h1>

            <p>
                Select a theme for your AI photo transformation.
            </p>

        </section>


        <!-- =================================================
             FORM
        ================================================== -->

        <form
            id="themeForm"
            method="GET"
            action="{{ route('photobooth.create') }}"
        >


            <!-- =============================================
                 THEME CARDS
            ============================================== -->

            <div class="theme-container">


                <!-- =========================================
                     GRADUATION
                ========================================== -->

                <div
                    class="theme-card"
                    data-theme="Graduation"
                    data-theme-id="{{ $themes->firstWhere('name', 'Graduation')->id ?? '' }}"
                >

                    <div
                        class="theme-image graduation-background"
                    ></div>


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


                <!-- =========================================
                     MAFIA
                ========================================== -->

                <div
                    class="theme-card"
                    data-theme="Mafia"
                    data-theme-id="{{ $themes->firstWhere('name', 'Mafia')->id ?? '' }}"
                >

                    <div
                        class="theme-image mafia-background"
                    ></div>


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


                <!-- =========================================
                     K-DRAMA
                ========================================== -->

                <div
                    class="theme-card"
                    data-theme="K-Drama"
                    data-theme-id="{{ $themes->firstWhere('name', 'K-Drama')->id ?? '' }}"
                >

                    <div
                        class="theme-image kdrama-background"
                    ></div>


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


            <!-- =============================================
                 HIDDEN VALUES
            ============================================== -->

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


            <!-- =============================================
                 BOTTOM
            ============================================== -->

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


    <!-- =====================================================
         JAVASCRIPT
    ====================================================== -->

    <script>


        /* =================================================
           ELEMENTS
        ================================================= */

        const themeCards =
            document.querySelectorAll(
                '.theme-card'
            );


        const selectedTheme =
            document.getElementById(
                'selectedTheme'
            );


        const selectedThemeId =
            document.getElementById(
                'selectedThemeId'
            );


        const selectedThemeText =
            document.getElementById(
                'selectedThemeText'
            );


        const nextButton =
            document.getElementById(
                'nextButton'
            );


        const themeForm =
            document.getElementById(
                'themeForm'
            );


        const pageTransition =
            document.querySelector(
                '.page-transition'
            );


        /* =================================================
           THEME SELECTION
        ================================================= */

        themeCards.forEach(
            function (card) {

                card.addEventListener(
                    'click',
                    function () {


                        /* -----------------------------
                           Remove previous selection
                        ----------------------------- */

                        themeCards.forEach(
                            function (item) {

                                item.classList.remove(
                                    'selected'
                                );

                            }
                        );


                        /* -----------------------------
                           Select current card
                        ----------------------------- */

                        this.classList.add(
                            'selected'
                        );


                        /* -----------------------------
                           Get theme information
                        ----------------------------- */

                        const themeName =
                            this.dataset.theme;


                        const themeId =
                            this.dataset.themeId;


                        /* -----------------------------
                           Store theme
                        ----------------------------- */

                        selectedTheme.value =
                            themeName;


                        selectedThemeId.value =
                            themeId;


                        /* -----------------------------
                           Update selected text
                        ----------------------------- */

                        selectedThemeText.textContent =
                            themeName;


                        /* -----------------------------
                           Enable next button
                        ----------------------------- */

                        nextButton.disabled =
                            false;


                    }
                );

            }
        );


        /* =================================================
           NEXT BUTTON TRANSITION
        ================================================= */

        themeForm.addEventListener(
            'submit',
            function (event) {


                /* -----------------------------------------
                   Make sure a theme was selected
                ----------------------------------------- */

                if (
                    !selectedTheme.value
                ) {

                    event.preventDefault();

                    return;

                }


                /* -----------------------------------------
                   Start page transition
                ----------------------------------------- */

                if (pageTransition) {

                    event.preventDefault();


                    pageTransition.classList.add(
                        'active'
                    );


                    const destination =
                        this.action +
                        '?' +
                        new URLSearchParams(
                            new FormData(this)
                        ).toString();


                    setTimeout(
                        function () {

                            window.location.href =
                                destination;

                        },
                        500
                    );

                }

            }
        );


    </script>


</body>

</html>