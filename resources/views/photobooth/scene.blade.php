<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Choose Your Theme - RupaVue</title>

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
            margin: 0;
            padding: 0;

            overflow: hidden;
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
           PAGE
        ===================================================== */

        .scene-page {

            position: relative;

            width: 100%;
            min-height: 100vh;
            min-height: 100dvh;

            overflow: hidden;

            padding:
                4px
                5vw
                35px;

            display: flex;
            flex-direction: column;
            align-items: center;

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


        /* Selected theme image (two layers so it can crossfade) */

        .rv-theme-bg {
            position: absolute;
            inset: 0;

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;

            opacity: 0;
            transform: scale(1.04);

            transition:
                opacity .8s ease,
                transform 6s ease;
        }

        .rv-theme-bg.active {
            opacity: 1;
            transform: scale(1);
        }

        /* Keeps text readable over any theme image */

        .rv-theme-scrim {
            position: absolute;
            inset: 0;

            background:
                linear-gradient(
                    to bottom,
                    rgba(1, 6, 17, .55) 0%,
                    rgba(1, 6, 17, .25) 35%,
                    rgba(1, 6, 17, .70) 100%
                );

            opacity: 0;
            transition: opacity .8s ease;
        }

        .rv-theme-scrim.active {
            opacity: 1;
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
           MAIN CONTENT
        ===================================================== */

        .scene-content {

            position: relative;

            z-index: 10;

            width: min(1700px, 97vw);

            flex: 1;

            display: flex;

            flex-direction: column;

            align-items: center;

        }


        /* =====================================================
           HEADER
        ===================================================== */

        .scene-header {

            width: 100%;

            text-align: center;

            margin-bottom: 36px;

        }


        .scene-header h1 {

            color: #ffffff;

            font-size:
                clamp(
                    32px,
                    4vw,
                    52px
                );

            font-weight: 800;

            margin-bottom: 8px;

            text-shadow:
                0 0 10px rgba(255,255,255,.18),
                0 0 28px rgba(0,102,255,.28);

        }


        .scene-header p {

            color: rgba(218,237,255,.85);

            font-size: 18px;

        }


        /* =====================================================
           THEME CAROUSEL
        ===================================================== */

        .carousel-wrapper {

            width: 100%;
            display: flex;
            align-items: center;

            gap: 18px;
            min-width: 0;

        }


        .carousel-button {

            flex: 0 0 52px;

            width: 52px;
            height: 52px;

            border: 1px solid
                rgba(255,255,255,.8);

            border-radius: 50%;

            background:
                rgba(4,50,125,.88);

            color: white;

            font-size: 30px;

            display: flex;

            align-items: center;

            justify-content: center;

            cursor: pointer;

            box-shadow:

                0 0 18px
                rgba(20,130,255,.55),

                inset 0 1px 0
                rgba(255,255,255,.4);

            transition:
                .25s ease;

        }


        .carousel-button:hover {

            background:
                #0b63d8;

            transform:
                scale(1.08);

            box-shadow:

                0 0 28px
                rgba(20,150,255,.8);

        }


        .theme-track {

            flex: 1;
            min-width: 0;
            width: 0;

            display: flex;

            gap: 20px;

            overflow-x: hidden;
            overflow-y: visible;

            scroll-behavior: smooth;

            /*
             * Extra left/right padding gives the selected
             * card's scale(1.08) grow-effect room to breathe
             * so it doesn't get clipped by overflow-x: hidden
             * when it's the first or last card in the row.
             */
            padding:
                25px
                40px
                35px;

            scrollbar-width: none;

            /* Let our swipe handler own horizontal gestures */
            touch-action: pan-y;

            user-select: none;
            -webkit-user-select: none;

        }

        .theme-track::-webkit-scrollbar {
            display: none;
        }


        /* =====================================================
           THEME CARD
        ===================================================== */

        .theme-card {

            position: relative;

            flex:
                0 0
                calc(
                    (100% - 40px) / 3
                );

            min-width: 0;
            height: clamp(300px, 48vh, 560px);
            border-radius: 22px;
            overflow: hidden;
            cursor: pointer;

            border:
                2px solid
                rgba(255,255,255,.72);

            background:
                linear-gradient(
                    145deg,
                    rgba(17,80,160,.95),
                    rgba(4,31,80,.98)
                );

            box-shadow:

                0 15px 35px
                rgba(0,30,90,.28),

                inset 0 1px 0
                rgba(255,255,255,.35);

            transform: scale(.92);

            z-index: 1;

            transition:
                transform .35s ease,
                box-shadow .3s ease,
                border-color .3s ease;

        }


        .theme-card:hover {

            transform:
                scale(.92)
                translateY(-7px);

            box-shadow:

                0 20px 45px
                rgba(0,50,130,.4),

                0 0 20px
                rgba(30,145,255,.3);

        }


        .theme-card.selected {

            border-color:
                #35aaff;

            box-shadow:

                0 18px 45px
                rgba(0,50,150,.45);

            transform:
                scale(1.08)
                translateY(-5px);

            z-index: 4;

        }


        .theme-card.selected:hover {

            transform:
                scale(1.08)
                translateY(-8px);

        }


        /* =====================================================
           CARD IMAGE
        ===================================================== */

        .theme-image {

            position: absolute;

            inset: 0;

            width: 100%;
            height: 100%;

            object-fit: cover;

            opacity: 1;

            transition:
                transform .5s ease,
                opacity .3s ease;

        }


        .theme-card:hover
        .theme-image {

            transform:
                scale(1.06);

            opacity: 1;

        }


        .theme-overlay {

            position: absolute;

            inset: 0;

            background:

                linear-gradient(
                    to top,
                    rgba(2,14,43,.92) 0%,
                    rgba(2,20,60,.45) 32%,
                    transparent 60%
                );

        }


        /* =====================================================
           CARD CONTENT
        ===================================================== */

        .theme-content {

            position: absolute;

            left: 24px;
            right: 24px;
            bottom: 22px;

            z-index: 3;

            color: white;

        }


        .theme-icon {

            width: 48px;
            height: 48px;

            margin-bottom: 12px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 14px;

            background:
                rgba(255,255,255,.16);

            border:
                1px solid
                rgba(255,255,255,.4);

            backdrop-filter:
                blur(6px);

            font-size: 24px;

        }


        .theme-name {

            font-size: 24px;

            font-weight: 800;

            text-transform: uppercase;

            margin-bottom: 7px;

            letter-spacing: .5px;

        }


        .theme-description {

            font-size: 12px;

            line-height: 1.55;

            color:
                rgba(255,255,255,.88);

            max-width: 290px;

        }


        /* =====================================================
           SELECTED CHECK
        ===================================================== */

        .selected-check {

            position: absolute;

            z-index: 5;

            top: 16px;
            right: 16px;

            width: 42px;
            height: 42px;

            border-radius: 50%;

            display: flex;

            align-items: center;

            justify-content: center;

            background: white;

            color: #0865d5;

            font-size: 23px;

            font-weight: bold;

            opacity: 0;

            transform:
                scale(.6);

            transition:
                .25s ease;

            box-shadow:

                0 0 15px
                rgba(100,210,255,.9);

        }


        .theme-card.selected
        .selected-check {

            opacity: 1;

            transform:
                scale(1);

        }


        /* =====================================================
           NEW BADGE
        ===================================================== */

        .theme-new-badge {

            position: absolute;

            z-index: 5;

            top: 16px;
            right: 16px;

            padding: 7px 14px;

            border-radius: 999px;

            background:
                linear-gradient(
                    135deg,
                    #ffcf3f,
                    #ff8a1f
                );

            color: #3a1a00;

            font-size: 13px;
            font-weight: 800;
            letter-spacing: .12em;

            box-shadow:
                0 4px 14px
                rgba(255,140,30,.55);

            transition:
                right .25s ease;

        }


        /* Slide left so it doesn't sit under the ✓ */

        .theme-card.selected
        .theme-new-badge {

            right: 68px;

        }


        /* =====================================================
           CAROUSEL DOTS
        ===================================================== */

        .carousel-dots {

            display: flex;

            justify-content: center;

            gap: 8px;

            margin-top: 2px;

            margin-bottom: 22px;

        }


        .carousel-dot {

            width: 8px;
            height: 8px;

            border-radius: 50%;

            background:
                rgba(255,255,255,.6);

            border:
                1px solid
                rgba(40,100,180,.35);

            transition:
                .25s ease;

        }


        .carousel-dot.active {

            width: 24px;

            border-radius: 10px;

            background:
                #087eff;

            box-shadow:
                0 0 8px
                rgba(0,130,255,.7);

        }


        /* =====================================================
           BOTTOM ACTION BAR
        ===================================================== */

        .selection-area {
            width: 100%;

            display: flex;

            flex-direction: column;

            align-items: center;

            gap: 48px;

            margin-top: auto;
            padding-top: 0;
            padding-bottom: 88px;
        }


        .action-bar {
            width: 100%;

            min-height: 84px;

            display: flex;

            align-items: center;

            justify-content: flex-start;

            padding:
                20px 32px;

            border-radius: 22px;

            background:
                rgba(255,255,255,.90);

            border:
                1px solid
                rgba(255,255,255,.95);

            box-shadow:

                0 12px 35px
                rgba(0,45,120,.18),

                inset 0 1px 0
                white;

            backdrop-filter:
                blur(10px);

            /* Move only the selected white container upward */
            transform: translateY(10px);
        }


        .selected-info {

            width: 100%;

            display: flex;

            align-items: center;

            gap: 16px;

            min-width: 0;

            color: #55718f;

            font-size: 20px;

            white-space: nowrap;

        }


        .selected-info strong {

            color:
                #0871e9;

            font-size: 24px;

            flex-shrink: 0;

        }


        .selected-description {

            min-width: 0;

            flex: 1;

            overflow: hidden;

            text-overflow: ellipsis;

            white-space: nowrap;

            color: #55718f;

            font-size: 19px;

            padding-left: 14px;

            border-left: 1px solid
                rgba(85,113,143,.35);
        }


        .next-button {

            min-width: 340px;

            border: none;

            border-radius: 999px;

            padding:
                22px 48px;

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 12px;

            background:
                linear-gradient(
                    135deg,
                    #1a8fff,
                    #0052c7
                );

            color: white;

            font-size: 17px;

            font-weight: 800;

            letter-spacing: 1px;

            cursor: pointer;

            box-shadow:

                0 0 30px
                rgba(20,140,255,.55),

                0 14px 35px
                rgba(0,50,140,.4),

                inset 0 1px 0
                rgba(255,255,255,.4);

            transition:
                .25s ease;
        }


        .next-button .next-button-arrow {

            font-size: 20px;

            transition:
                transform .25s ease;

        }


        .next-button:hover
        .next-button-arrow {

            transform:
                translateX(6px);

        }


        .next-button:disabled {

            cursor: not-allowed;

            opacity: .45;

            background:
                linear-gradient(
                    135deg,
                    #345577,
                    #1c3350
                );

            box-shadow: none;

        }


        .next-button:disabled:hover {

            transform: none;

        }


        .next-button:not(:disabled):hover {

            transform:
                translateY(-4px)
                scale(1.02);

            background:
                linear-gradient(
                    135deg,
                    #3aa8ff,
                    #0060e0
                );

            box-shadow:

                0 0 40px
                rgba(30,150,255,.8),

                0 18px 40px
                rgba(0,50,140,.45);

        }


        /* =====================================================
           TABLET
        ===================================================== */

        @media (max-width: 900px) {

            .theme-card {

                flex-basis:
                    calc(
                        (100% - 20px) / 2
                    );

                transform: none;

            }

            .theme-card:hover {

                transform:
                    translateY(-7px);

            }

            .theme-card.selected {

                transform:
                    translateY(-5px);

            }

            .theme-card.selected:hover {

                transform:
                    translateY(-8px);

            }

        }


        /* =====================================================
           MOBILE
        ===================================================== */

        @media (max-width: 650px) {

            .scene-page {

                padding:
                    30px
                    15px;

            }


            .scene-header {

                margin-bottom: 20px;

            }


            .scene-header h1 {

                font-size: 32px;

            }


            .scene-header p {

                font-size: 12px;

            }


            .carousel-wrapper {

                gap: 8px;

            }


            .carousel-button {

                flex-basis: 42px;

                width: 42px;
                height: 42px;

                font-size: 24px;

            }


            .theme-track {

                gap: 12px;

            }


            .theme-card {

                flex-basis: 100%;

                height: clamp(320px, 54vh, 500px);

            }


            .action-bar {

                flex-direction: column;

                align-items: stretch;

                padding:
                    16px;

                transform: translateY(-10px);

            }


            .selected-info {

                justify-content: flex-start;

                white-space: normal;

            }


            .selected-description {

                white-space: nowrap;

                overflow: hidden;

                text-overflow: ellipsis;

            }


            .next-button {

                width: 100%;
                min-width: 0;

                padding:
                    18px 30px;

                font-size: 15px;

            }

        }


        /* =====================================================
           BACK BUTTON
        ===================================================== */

        .top-nav {
            position: fixed;

            left: 35px;
            bottom: 28px;

            z-index: 999;
        }

        .back-link {
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

            font-family: "Arial Black", Arial, sans-serif;
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

        .back-link:hover {
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

        .back-link:hover::before {
            left: 130%;
        }

        @media (max-width: 800px) {

            .top-nav {
                left: 18px;
                bottom: 18px;
            }

            .back-link {
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

        <div class="rv-theme-bg" id="themeBgA"></div>
        <div class="rv-theme-bg" id="themeBgB"></div>
        <div class="rv-theme-scrim" id="themeBgScrim"></div>

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
            href="{{ route('home') }}"
            class="back-link"
        >
            ← Back
        </a>

    </div>


<div class="scene-page">


    <!-- =====================================================
         CONTENT
    ===================================================== -->

    <div class="scene-content">


        <!-- Header -->

        <header class="scene-header">

            <h1>
                Choose Your Theme
            </h1>

            <p>
                Select a theme for your AI photo transformation.
            </p>

        </header>


        <!-- =================================================
             THEME CAROUSEL
        ================================================== -->

        <div class="carousel-wrapper">


            <!-- Left -->

            <button
                type="button"
                class="carousel-button"
                id="previousTheme"
                aria-label="Previous theme"
            >
                ‹
            </button>


            <!-- Theme track -->

            <div
                class="theme-track"
                id="themeTrack"
            >

                @forelse ($themes as $theme)

                    @php
                        $themeImage = $theme->thumbnail_url;

                        $themePrompt = trim(
                            ($theme->prompt_prefix ?? '') . ' ' .
                            ($theme->prompt_suffix ?? '')
                        );
                    @endphp


                    <div
                        class="theme-card"
                        data-theme-id="{{ $theme->id }}"
                        data-theme-name="{{ $theme->theme_name }}"
                        data-theme-description="{{ $theme->description ?? 'Create a unique AI-powered photo experience.' }}"
                        data-theme-prompt="{{ $themePrompt }}"
                        data-theme-image="{{ $themeImage }}"
                    >


                        @if ($themeImage)

                            <img
                                src="{{ $themeImage }}"
                                alt="{{ $theme->theme_name }}"
                                referrerpolicy="no-referrer"
                                class="theme-image"
                            >

                        @else

                            <div
                                class="theme-image"
                                style="
                                    background:
                                    linear-gradient(
                                        135deg,
                                        #0755c9,
                                        #031d59
                                    );
                                "
                            ></div>

                        @endif


                        <div class="theme-overlay"></div>


                        <!-- Selected -->

                        <div class="selected-check">
                            ✓
                        </div>


                        @if ($theme->isNew())

                            <!-- Recently added -->

                            <div class="theme-new-badge">
                                NEW
                            </div>

                        @endif


                        <!-- Card content -->

                        <div class="theme-content">

                            <div class="theme-icon">
                                📸
                            </div>

                            <div class="theme-name">
                                {{ $theme->theme_name }}
                            </div>

                            <div class="theme-description">

                                {{ $theme->description
                                    ?? 'Create a unique AI-powered photo experience.'
                                }}

                            </div>

                        </div>

                    </div>

                @empty

                    <div
                        style="
                            width:100%;
                            padding:60px;
                            text-align:center;
                            color:rgba(255,255,255,.75);
                        "
                    >

                        No themes are currently available.

                    </div>

                @endforelse

            </div>


            <!-- Right -->

            <button
                type="button"
                class="carousel-button"
                id="nextTheme"
                aria-label="Next theme"
            >
                ›
            </button>

        </div>


        <!-- Carousel dots -->

        <div
            class="carousel-dots"
            id="carouselDots"
        ></div>


        <!-- =================================================
             ACTION BAR
        ================================================== -->

        <div class="selection-area">

            <div class="action-bar">

                <div class="selected-info">

                    <span>
                        Selected:
                    </span>

                    <strong id="selectedThemeName">
                        No theme selected yet
                    </strong>

                    <span
                        class="selected-description"
                        id="selectedThemeDescription"
                    >
                        Select a theme to see its description.
                    </span>

                </div>

            </div>


            <button
                type="button"
                class="next-button"
                id="nextButton"
                disabled
            >
                <span>
                    CAPTURE PHOTO
                </span>

                <span class="next-button-arrow">
                    →
                </span>
            </button>

        </div>


    </div>

</div>


<script>

    /* =====================================================
       ELEMENTS
    ===================================================== */

    const themeTrack =
        document.getElementById('themeTrack');

    const themeCards =
        Array.from(
            document.querySelectorAll('.theme-card')
        );

    const previousTheme =
        document.getElementById('previousTheme');

    const nextTheme =
        document.getElementById('nextTheme');

    const carouselDots =
        document.getElementById('carouselDots');

    const selectedThemeName =
        document.getElementById('selectedThemeName');

    const selectedThemeDescription =
        document.getElementById('selectedThemeDescription');

    const nextButton =
        document.getElementById('nextButton');


    let selectedIndex = -1;


    /* =====================================================
       CREATE CAROUSEL DOTS
    ===================================================== */

    function createDots() {

        carouselDots.innerHTML = '';

        themeCards.forEach(
            function (card, index) {

                const dot =
                    document.createElement('span');

                dot.className =
                    'carousel-dot';

                if (index === selectedIndex) {

                    dot.classList.add('active');

                }

                carouselDots.appendChild(dot);

            }
        );

    }


    createDots();


    /* =====================================================
       PAGE BACKGROUND = SELECTED THEME IMAGE
    ===================================================== */

    const themeBgLayers = [
        document.getElementById('themeBgA'),
        document.getElementById('themeBgB')
    ];

    const themeBgScrim =
        document.getElementById('themeBgScrim');

    let themeBgActive = -1;
    let themeBgUrl = '';

    function setThemeBackground(url) {

        url = url || '';

        if (url === themeBgUrl) {
            return;
        }

        themeBgUrl = url;


        /*
         * No image for this theme: fade back to the
         * default background.
         */

        if (!url) {

            themeBgLayers.forEach(function (layer) {
                layer.classList.remove('active');
            });

            themeBgScrim.classList.remove('active');

            themeBgActive = -1;

            return;
        }


        /*
         * Load first, then crossfade, so the page never
         * flashes an empty background.
         */

        const loader = new Image();

        loader.referrerPolicy = 'no-referrer';

        loader.onload = function () {

            if (url !== themeBgUrl) {
                return;
            }

            const next =
                themeBgActive === 0 ? 1 : 0;

            themeBgLayers[next].style.backgroundImage =
                'url("' + url + '")';

            themeBgLayers[next].classList.add('active');

            if (themeBgActive !== -1) {
                themeBgLayers[themeBgActive]
                    .classList.remove('active');
            }

            themeBgActive = next;

            themeBgScrim.classList.add('active');

        };

        loader.src = url;

    }


    /* =====================================================
       SELECT THEME
    ===================================================== */

    function selectTheme(index) {

        if (!themeCards.length) {
            return;
        }


        if (index < 0) {

            index =
                themeCards.length - 1;

        }


        if (index >= themeCards.length) {

            index = 0;

        }


        selectedIndex = index;


        themeCards.forEach(
            function (card, cardIndex) {

                card.classList.toggle(
                    'selected',
                    cardIndex === selectedIndex
                );

            }
        );


        const selectedCard =
            themeCards[selectedIndex];


        const themeName =
            selectedCard.dataset.themeName
            || 'Theme';

        const themeDescription =
            selectedCard.dataset.themeDescription
            || 'Create a unique AI-powered photo experience.';


        selectedThemeName.textContent =
            themeName;

        selectedThemeDescription.textContent =
            themeDescription;


        setThemeBackground(
            selectedCard.dataset.themeImage
        );


        /*
         * A theme has now been picked, so the
         * capture button becomes available.
         */

        nextButton.disabled = false;


        /*
         * Save selected theme
         */

        sessionStorage.setItem(
            'rupavueThemeId',
            selectedCard.dataset.themeId
        );


        sessionStorage.setItem(
            'rupavueThemeName',
            themeName
        );


        sessionStorage.setItem(
            'rupavueThemePrompt',
            selectedCard.dataset.themePrompt
            || ''
        );


        /*
         * Center the selected card in the track so it
         * reads as the bigger, focused "middle" card.
         *
         * scrollIntoView lets the browser do the centering
         * and clamping math natively, so it stays correct
         * even at the very first/last card or when several
         * selections happen back-to-back.
         */

        selectedCard.scrollIntoView({
            behavior: 'smooth',
            block: 'nearest',
            inline: 'center'
        });


        createDots();

    }


    /* =====================================================
       CLICK THEME
    ===================================================== */

    themeCards.forEach(
        function (card, index) {

            card.addEventListener(
                'click',
                function () {

                    selectTheme(index);

                }
            );

        }
    );


    /* =====================================================
       SWIPE / DRAG
       Swipe left = next theme, swipe right = previous.
       Works with touch, pen and mouse drag.
    ===================================================== */

    const swipeThreshold = 40;

    let swipeStartX = null;
    let swipeStartY = 0;
    let lastSwipeAt = 0;


    themeTrack.addEventListener(
        'pointerdown',
        function (event) {

            if (event.pointerType === 'mouse' && event.button !== 0) {
                return;
            }

            swipeStartX = event.clientX;
            swipeStartY = event.clientY;

        }
    );


    themeTrack.addEventListener(
        'pointerup',
        function (event) {

            if (swipeStartX === null || !themeCards.length) {
                swipeStartX = null;
                return;
            }

            const deltaX = event.clientX - swipeStartX;
            const deltaY = event.clientY - swipeStartY;

            swipeStartX = null;


            if (
                Math.abs(deltaX) < swipeThreshold
                || Math.abs(deltaX) < Math.abs(deltaY)
            ) {
                return;
            }


            /*
             * Stop at the first/last theme instead of
             * wrapping around, which feels odd on a swipe.
             */

            const currentIndex =
                selectedIndex === -1 ? 0 : selectedIndex;

            const targetIndex = Math.min(
                themeCards.length - 1,
                Math.max(
                    0,
                    deltaX < 0
                        ? currentIndex + 1
                        : currentIndex - 1
                )
            );

            lastSwipeAt = Date.now();

            selectTheme(targetIndex);

        }
    );


    themeTrack.addEventListener(
        'pointercancel',
        function () {

            swipeStartX = null;

        }
    );


    /*
     * A drag ends with a click on whichever card the
     * pointer was released over; swallow it so the swipe
     * result isn't overridden.
     */

    themeTrack.addEventListener(
        'click',
        function (event) {

            if (Date.now() - lastSwipeAt < 400) {

                event.stopPropagation();
                event.preventDefault();

            }

        },
        true
    );


    /* Stop the browser dragging the card images */

    themeTrack.addEventListener(
        'dragstart',
        function (event) {

            event.preventDefault();

        }
    );


    /* =====================================================
       LEFT BUTTON
    ===================================================== */

    previousTheme.addEventListener(
        'click',
        function () {

            selectTheme(
                selectedIndex === -1
                    ? 0
                    : selectedIndex - 1
            );

        }
    );


    /* =====================================================
       RIGHT BUTTON
    ===================================================== */

    nextTheme.addEventListener(
        'click',
        function () {

            selectTheme(
                selectedIndex === -1
                    ? 0
                    : selectedIndex + 1
            );

        }
    );


    /* =====================================================
       LOAD PREVIOUS SELECTION
    ===================================================== */

    const savedThemeId =
        sessionStorage.getItem(
            'rupavueThemeId'
        );


    if (savedThemeId) {

        const savedIndex =
            themeCards.findIndex(
                function (card) {

                    return (
                        card.dataset.themeId
                        === savedThemeId
                    );

                }
            );


        if (savedIndex !== -1) {

            selectTheme(savedIndex);

        }

    }


    /* =====================================================
       NEXT BUTTON
    ===================================================== */

    nextButton.addEventListener(
        'click',
        function () {

            if (!themeCards.length || selectedIndex === -1) {

                return;

            }


            /*
             * Make sure current theme is saved
             */

            selectTheme(selectedIndex);


            /*
             * Go to capture page, carrying the
             * selected theme so that page can load it.
             */

            const themeId =
                themeCards[selectedIndex]
                    .dataset.themeId || '';

            window.location.href =
                '{{ route('photobooth.create') }}'
                + '?theme_id='
                + encodeURIComponent(themeId);

        }
    );


</script>

</body>
</html>
