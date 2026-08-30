<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>RupaVue - AI Photo Experience</title>

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
            height: 100%;
        }

        body {
            font-family:
                Arial,
                Helvetica,
                sans-serif;

            overflow: hidden;

            background: #020b2d;
        }


        /* =====================================================
           MAIN BACKGROUND
        ===================================================== */

        .welcome-container {

            position: relative;

            width: 100%;

            height: 100vh;
            height: 100dvh;

            overflow: hidden;

            display: flex;

            align-items: center;

            justify-content: center;

            background:
                radial-gradient(
                    ellipse 62% 58% at 50% 48%,
                    #ffffff 0%,
                    #f5f9ff 16%,
                    #d9eaff 30%,
                    #9ac7fa 43%,
                    #438ff0 57%,
                    #0755c9 69%,
                    #052c78 80%,
                    #03194b 91%,
                    #010b25 100%
                );

        }


        /* =====================================================
           DEEP BLUE ATMOSPHERE
        ===================================================== */

        .ambient-light {

            position: absolute;

            inset: -20%;

            z-index: 0;

            pointer-events: none;

            background:

                /* Bright blue glow around the center */
                radial-gradient(
                    ellipse 55% 42% at 50% 48%,
                    rgba(255,255,255,0.55) 0%,
                    rgba(120,185,255,0.35) 35%,
                    rgba(25,105,235,0.25) 60%,
                    transparent 80%
                ),

                /* Deep blue top-left */
                radial-gradient(
                    ellipse 40% 35% at 0% 0%,
                    rgba(10,70,180,0.9) 0%,
                    rgba(4,35,105,0.65) 55%,
                    transparent 100%
                ),

                /* Blue top-right */
                radial-gradient(
                    ellipse 42% 38% at 100% 0%,
                    rgba(10,115,205,0.85) 0%,
                    rgba(3,55,130,0.65) 55%,
                    transparent 100%
                ),

                /* Purple-blue bottom-left */
                radial-gradient(
                    ellipse 42% 40% at 0% 100%,
                    rgba(65,50,190,0.9) 0%,
                    rgba(15,45,135,0.7) 55%,
                    transparent 100%
                ),

                /* Deep blue bottom-right */
                radial-gradient(
                    ellipse 43% 40% at 100% 100%,
                    rgba(10,90,195,0.9) 0%,
                    rgba(3,45,120,0.7) 55%,
                    transparent 100%
                );

            filter: blur(35px);

            animation:
                ambientMove
                18s
                ease-in-out
                infinite;

        }


        @keyframes ambientMove {

            0%,
            100% {
                transform:
                    translate(0, 0)
                    scale(1);
            }

            25% {
                transform:
                    translate(1.5%, -1%)
                    scale(1.04);
            }

            50% {
                transform:
                    translate(-1%, 1.5%)
                    scale(1.07);
            }

            75% {
                transform:
                    translate(1%, 1%)
                    scale(1.03);
            }

        }


        /* =====================================================
           LIQUID SHAPES
        ===================================================== */

        .liquid {
            position: absolute;
            z-index: 1;
            pointer-events: none;
            overflow: hidden;

            opacity: 1;

            filter:
                drop-shadow(0 0 18px rgba(30, 120, 255, 0.65))
                drop-shadow(0 10px 30px rgba(0, 20, 90, 0.35));
        }


        /* Dark transparent shading */

        .liquid::before {
            content: "";

            position: absolute;

            inset: 0;

            z-index: 1;

            border-radius: inherit;

            background:
                linear-gradient(
                    135deg,
                    rgba(255,255,255,0.22) 0%,
                    rgba(255,255,255,0.06) 18%,
                    transparent 38%,
                    rgba(0,20,80,0.15) 75%,
                    rgba(0,10,50,0.30) 100%
                );
        }


        /* =====================================================
        WHITE LIQUID REFLECTION
        ===================================================== */

        .liquid::after {
            content: "";

            position: absolute;

            z-index: 2;

            width: 70%;

            height: 32%;

            top: 3%;

            left: 12%;

            border-radius: 50%;

            background:
                radial-gradient(
                    ellipse,
                    rgba(255,255,255,0.95) 0%,
                    rgba(255,255,255,0.65) 18%,
                    rgba(180,225,255,0.35) 40%,
                    rgba(80,170,255,0.12) 60%,
                    transparent 78%
                );

            filter: blur(9px);

            transform:
                rotate(-12deg);

            opacity: 0.9;

            animation:
                liquidReflection
                5s
                ease-in-out
                infinite;
        }


        @keyframes liquidReflection {

            0%,
            100% {
                opacity: 0.55;

                transform:
                    rotate(-12deg)
                    translateX(0);
            }

            50% {
                opacity: 1;

                transform:
                    rotate(-8deg)
                    translateX(18px);
            }

        }


        /* =====================================================
           TOP LEFT LIQUID
        ===================================================== */

        .liquid-top-left {

            width: 470px;
            height: 410px;

            top: -190px;
            left: -110px;

            border-radius:
                70% 30% 62% 38%
                /
                45% 55% 45% 55%;

            background:

                radial-gradient(
                    ellipse at 68% 70%,
                    #65adff 0%,
                    #317bdc 35%,
                    #1052b5 65%,
                    #042b78 100%
                );

            transform:
                rotate(-10deg);

            animation:
                liquidTL
                12s
                ease-in-out
                infinite;

        }


        @keyframes liquidTL {

            0%,
            100% {

                border-radius:
                    70% 30% 62% 38%
                    /
                    45% 55% 45% 55%;

                transform:
                    rotate(-10deg)
                    translate(0,0);

            }

            50% {

                border-radius:
                    40% 60% 35% 65%
                    /
                    60% 40% 65% 35%;

                transform:
                    rotate(-3deg)
                    translate(35px,25px);

            }

        }


        /* =====================================================
           TOP RIGHT LIQUID
        ===================================================== */

        .liquid-top-right {

            width: 500px;
            height: 440px;

            top: -175px;
            right: -150px;

            border-radius:
                35% 65% 42% 58%
                /
                60% 40% 60% 40%;

            background:

                radial-gradient(
                    ellipse at 32% 72%,
                    #70d5ff 0%,
                    #319fe8 35%,
                    #0b68c9 65%,
                    #04347f 100%
                );

            transform:
                rotate(7deg);

            animation:
                liquidTR
                14s
                ease-in-out
                infinite;

        }


        @keyframes liquidTR {

            0%,
            100% {

                border-radius:
                    35% 65% 42% 58%
                    /
                    60% 40% 60% 40%;

                transform:
                    rotate(7deg)
                    translate(0,0);

            }

            50% {

                border-radius:
                    62% 38% 60% 40%
                    /
                    38% 62% 42% 58%;

                transform:
                    rotate(13deg)
                    translate(-30px,30px);

            }

        }


        /* =====================================================
           BOTTOM LEFT LIQUID
        ===================================================== */

        .liquid-bottom-left {

            width: 500px;
            height: 470px;

            bottom: -210px;
            left: -130px;

            border-radius:
                42% 58% 68% 32%
                /
                55% 45% 55% 45%;

            background:

                radial-gradient(
                    ellipse at 68% 25%,
                    #a99aff 0%,
                    #716be8 28%,
                    #464fc3 55%,
                    #172f8c 80%,
                    #051d5e 100%
                );

            transform:
                rotate(-6deg);

            animation:
                liquidBL
                13s
                ease-in-out
                infinite;

        }


        @keyframes liquidBL {

            0%,
            100% {

                border-radius:
                    42% 58% 68% 32%
                    /
                    55% 45% 55% 45%;

                transform:
                    rotate(-6deg)
                    translate(0,0);

            }

            50% {

                border-radius:
                    65% 35% 38% 62%
                    /
                    40% 60% 65% 35%;

                transform:
                    rotate(3deg)
                    translate(35px,-25px);

            }

        }


        /* =====================================================
           BOTTOM RIGHT LIQUID
        ===================================================== */

        .liquid-bottom-right {

            width: 510px;
            height: 470px;

            bottom: -215px;
            right: -135px;

            border-radius:
                62% 38% 40% 60%
                /
                45% 55% 60% 40%;

            background:

                radial-gradient(
                    ellipse at 28% 28%,
                    #70caff 0%,
                    #358ee1 35%,
                    #175abd 62%,
                    #07347f 85%,
                    #031c59 100%
                );

            transform:
                rotate(7deg);

            animation:
                liquidBR
                15s
                ease-in-out
                infinite;

        }


        @keyframes liquidBR {

            0%,
            100% {

                border-radius:
                    62% 38% 40% 60%
                    /
                    45% 55% 60% 40%;

                transform:
                    rotate(7deg)
                    translate(0,0);

            }

            50% {

                border-radius:
                    38% 62% 65% 35%
                    /
                    60% 40% 42% 58%;

                transform:
                    rotate(-3deg)
                    translate(-35px,-20px);

            }

        }


        /* =====================================================
           STARS
        ===================================================== */

        .stars {

            position: absolute;

            inset: 0;

            z-index: 4;

            pointer-events: none;

        }


        .star {

            position: absolute;

            width: 3px;

            height: 3px;

            border-radius: 50%;

            background: #ffffff;

            box-shadow:

                0 0 5px #ffffff,

                0 0 12px #66baff,

                0 0 20px
                rgba(30,130,255,0.8);

            opacity: 0.9;

            animation:
                twinkle
                3s
                ease-in-out
                infinite;

        }


        .star:nth-child(1) {
            top: 6%;
            left: 8%;
        }

        .star:nth-child(2) {
            top: 12%;
            left: 24%;
            animation-delay: .5s;
        }

        .star:nth-child(3) {
            top: 5%;
            left: 48%;
            animation-delay: 1s;
        }

        .star:nth-child(4) {
            top: 14%;
            left: 69%;
            animation-delay: 1.5s;
        }

        .star:nth-child(5) {
            top: 9%;
            right: 8%;
            animation-delay: 2s;
        }

        .star:nth-child(6) {
            top: 30%;
            left: 12%;
            animation-delay: .7s;
        }

        .star:nth-child(7) {
            top: 27%;
            right: 14%;
            animation-delay: 1.3s;
        }

        .star:nth-child(8) {
            top: 44%;
            left: 5%;
            animation-delay: 2.2s;
        }

        .star:nth-child(9) {
            top: 42%;
            right: 6%;
            animation-delay: .8s;
        }

        .star:nth-child(10) {
            top: 58%;
            left: 15%;
            animation-delay: 1.8s;
        }

        .star:nth-child(11) {
            top: 63%;
            right: 12%;
            animation-delay: 2.4s;
        }

        .star:nth-child(12) {
            top: 76%;
            left: 7%;
            animation-delay: 1s;
        }

        .star:nth-child(13) {
            top: 84%;
            left: 27%;
            animation-delay: 1.7s;
        }

        .star:nth-child(14) {
            top: 73%;
            right: 28%;
            animation-delay: .4s;
        }

        .star:nth-child(15) {
            top: 88%;
            left: 58%;
            animation-delay: 2.1s;
        }

        .star:nth-child(16) {
            top: 83%;
            right: 8%;
            animation-delay: .9s;
        }

        .star:nth-child(17) {
            top: 35%;
            right: 27%;
            animation-delay: 2.5s;
        }

        .star:nth-child(18) {
            top: 54%;
            left: 25%;
            animation-delay: 1.4s;
        }

        .star:nth-child(19) {
            top: 21%;
            left: 54%;
            animation-delay: .3s;
        }

        .star:nth-child(20) {
            top: 68%;
            left: 48%;
            animation-delay: 1.9s;
        }


        @keyframes twinkle {

            0%,
            100% {

                opacity: 0.35;

                transform:
                    scale(0.7);

            }

            50% {

                opacity: 1;

                transform:
                    scale(1.8);

            }

        }


        /* =====================================================
           LARGE STAR
        ===================================================== */

        .bright-star {

            position: absolute;

            width: 5px;

            height: 5px;

            z-index: 5;

            border-radius: 50%;

            background: #ffffff;

            box-shadow:

                0 0 8px #ffffff,

                0 0 20px #42aaff,

                0 0 35px #167dff;

            animation:
                brightTwinkle
                4s
                ease-in-out
                infinite;

        }


        .bright-star::before,
        .bright-star::after {

            content: "";

            position: absolute;

            left: 50%;

            top: 50%;

            transform:
                translate(-50%, -50%);

            background:
                rgba(255,255,255,0.95);

        }


        .bright-star::before {

            width: 34px;

            height: 1px;

        }


        .bright-star::after {

            width: 1px;

            height: 34px;

        }


        .bright-star-1 {

            top: 13%;

            left: 24%;

        }


        .bright-star-2 {

            top: 18%;

            right: 24%;

            animation-delay: 1.5s;

        }


        .bright-star-3 {

            bottom: 17%;

            left: 15%;

            animation-delay: 2.5s;

        }


        .bright-star-4 {

            bottom: 25%;

            right: 19%;

            animation-delay: 1s;

        }


        @keyframes brightTwinkle {

            0%,
            100% {

                opacity: .45;

                transform:
                    scale(.7);

            }

            50% {

                opacity: 1;

                transform:
                    scale(1.25);

            }

        }


        /* =====================================================
           MAIN CONTENT
        ===================================================== */

        .content {

            position: relative;

            z-index: 10;

            width: 90%;

            max-width: 900px;

            display: flex;

            flex-direction: column;

            align-items: center;

            justify-content: center;

            text-align: center;

            margin-top: -5px;

        }


        /* =====================================================
           RUPAVUE
        ===================================================== */

        .logo {

            color: #020817;

            font-size:
                clamp(
                    55px,
                    8vw,
                    96px
                );

            font-weight: 900;

            letter-spacing:
                clamp(
                    7px,
                    1.3vw,
                    16px
                );

            line-height: 1;

            margin-bottom: 15px;

            text-shadow:

                0 3px 10px
                rgba(255,255,255,.85);

        }


        /* =====================================================
           SUBTITLE
        ===================================================== */

        .subtitle {

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 15px;

            color: #147fff;

            font-size:
                clamp(
                    12px,
                    1.5vw,
                    20px
                );

            font-weight: 500;

            letter-spacing: 5px;

            margin-bottom: 42px;

            text-shadow:
                0 1px 8px
                rgba(255,255,255,.9);

        }


        .subtitle::before,
        .subtitle::after {

            content: "";

            width: 45px;

            height: 1px;

            background:
                #238cff;

            box-shadow:
                0 0 6px
                rgba(30,130,255,.5);

        }


        /* =====================================================
           WELCOME TITLE
        ===================================================== */

        .welcome-title {

            color: #050b19;

            font-size:
                clamp(
                    30px,
                    4vw,
                    53px
                );

            font-weight: 750;

            line-height: 1.2;

            margin-bottom: 22px;

            text-shadow:

                0 3px 10px
                rgba(255,255,255,.8);

        }


        /* =====================================================
           CAMERA DIVIDER
        ===================================================== */

        .camera-divider {

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 18px;

            margin-bottom: 25px;

        }


        .camera-line {

            width: 60px;

            height: 1px;

            background:

                linear-gradient(
                    to right,
                    transparent,
                    #1686ff
                );

            box-shadow:
                0 0 6px
                rgba(30,130,255,.4);

        }


        .camera-line.right {

            background:

                linear-gradient(
                    to left,
                    transparent,
                    #1686ff
                );

        }


        .camera-icon {

            color: #087fff;

            font-size: 29px;

            filter:

                drop-shadow(
                    0 0 7px
                    rgba(0,125,255,.7)
                );

            animation:
                cameraFloat
                3s
                ease-in-out
                infinite;

        }


        @keyframes cameraFloat {

            0%,
            100% {
                transform:
                    translateY(0);
            }

            50% {
                transform:
                    translateY(-5px);
            }

        }


        /* =====================================================
           DESCRIPTION
        ===================================================== */

        .description {

            max-width: 650px;

            color: #0c172b;

            font-size:
                clamp(
                    14px,
                    1.5vw,
                    18px
                );

            line-height: 1.8;

            margin-bottom: 40px;

            text-shadow:

                0 1px 5px
                rgba(255,255,255,.85);

        }


        /* =====================================================
           START BUTTON
        ===================================================== */

        .start-button {

            position: relative;

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 22px;

            width: 530px;

            max-width: 90vw;

            padding:
                20px
                30px;

            border:
                2px solid
                #087fff;

            border-radius: 60px;

            background:

                linear-gradient(
                    135deg,
                    #061c4e,
                    #020a24
                );

            color: white;

            font-size: 17px;

            font-weight: 700;

            letter-spacing: 4px;

            text-decoration: none;

            text-transform: uppercase;

            box-shadow:

                0 0 16px
                rgba(0,130,255,.9),

                0 0 40px
                rgba(0,100,255,.45),

                0 12px 35px
                rgba(0,30,100,.5);

            transition:

                transform .25s ease,

                box-shadow .25s ease,

                border-color .25s ease;

            overflow: hidden;

        }


        .start-button::before {

            content: "";

            position: absolute;

            top: 0;

            left: -120%;

            width: 70%;

            height: 100%;

            transform:
                skewX(-20deg);

            background:

                linear-gradient(
                    90deg,
                    transparent,
                    rgba(255,255,255,.2),
                    transparent
                );

            animation:
                buttonShine
                4s
                ease-in-out
                infinite;

        }


        @keyframes buttonShine {

            0% {
                left: -120%;
            }

            35% {
                left: 140%;
            }

            100% {
                left: 140%;
            }

        }


        .start-button:hover {

            transform:
                translateY(-4px)
                scale(1.015);

            border-color:
                #5bc1ff;

            box-shadow:

                0 0 25px
                rgba(0,145,255,1),

                0 0 55px
                rgba(0,110,255,.6),

                0 15px 45px
                rgba(0,30,100,.55);

        }


        .button-camera {

            color: #168cff;

            font-size: 26px;

            filter:

                drop-shadow(
                    0 0 8px
                    rgba(0,145,255,.9)
                );

        }


        .button-arrow {

            color: #168cff;

            font-size: 30px;

            transition:
                transform .2s ease;

        }


        .start-button:hover
        .button-arrow {

            transform:
                translateX(6px);

        }


        /* =====================================================
           FOOTER
        ===================================================== */

        .footer-line {

            position: absolute;

            z-index: 10;

            left: 50%;

            bottom: 55px;

            transform:
                translateX(-50%);

            width: 150px;

            height: 1px;

            background:

                linear-gradient(
                    to right,
                    transparent,
                    #218cff,
                    transparent
                );

            box-shadow:

                0 0 8px
                rgba(0,130,255,.7);

        }


        .bottom-text {

            position: absolute;

            z-index: 10;

            left: 50%;

            bottom: 26px;

            transform:
                translateX(-50%);

            color: #0c3a78;

            font-size: 10px;

            letter-spacing: 5px;

            text-transform: uppercase;

            white-space: nowrap;

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
                    #eaf5ff 22%,
                    #8fc6ff 50%,
                    #0758bd 100%
                );

            transform:
                scale(1);

            transition:

                opacity .45s ease,

                transform .6s ease,

                visibility .45s ease;

        }


        .page-transition.active {

            opacity: 1;

            visibility: visible;

            transform:
                scale(1.08);

        }


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
                    #ffffff 0%,
                    rgba(80,180,255,.85) 35%,
                    rgba(20,110,240,.35) 65%,
                    transparent 78%
                );

            filter:
                blur(8px);

            opacity: 0;

        }


        .page-transition.active::before {

            animation:
                transitionGlow
                .65s
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
           WELCOME EXIT
        ===================================================== */

        .welcome-container.page-exit {

            transform:
                scale(1.025);

            opacity: 0;

            transition:

                opacity .45s ease,

                transform .55s ease;

        }


        /* =====================================================
           TABLET
        ===================================================== */

        @media (max-width: 800px) {

            .logo {
                font-size: 60px;
            }

            .start-button {
                width: 440px;
            }

        }


        /* =====================================================
           MOBILE
        ===================================================== */

        @media (max-width: 500px) {

            .content {
                width: 88%;
            }

            .logo {

                font-size: 43px;

                letter-spacing: 5px;

            }

            .subtitle {

                font-size: 9px;

                letter-spacing: 2.5px;

                gap: 8px;

                margin-bottom: 30px;

            }

            .subtitle::before,
            .subtitle::after {

                width: 25px;

            }

            .welcome-title {
                font-size: 29px;
            }

            .camera-line {
                width: 40px;
            }

            .description {

                font-size: 13px;

                line-height: 1.7;

                margin-bottom: 30px;

            }

            .start-button {

                width: 100%;

                padding:
                    16px
                    15px;

                font-size: 12px;

                letter-spacing: 2px;

                gap: 12px;

            }

            .button-camera {
                font-size: 20px;
            }

            .button-arrow {
                font-size: 23px;
            }

            .bottom-text {

                font-size: 7px;

                letter-spacing: 3px;

                bottom: 15px;

            }

            .footer-line {

                bottom: 38px;

                width: 90px;

            }

            .liquid-top-left {

                width: 280px;
                height: 260px;

                top: -130px;
                left: -110px;

            }

            .liquid-top-right {

                width: 300px;
                height: 280px;

                top: -120px;
                right: -120px;

            }

            .liquid-bottom-left {

                width: 300px;
                height: 320px;

                bottom: -140px;
                left: -120px;

            }

            .liquid-bottom-right {

                width: 320px;
                height: 320px;

                bottom: -150px;
                right: -120px;

            }

        }


        /* =====================================================
           REDUCED MOTION
        ===================================================== */

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {

                animation: none !important;

                transition: none !important;

            }

        }

    </style>

</head>


<body>


    <!-- =====================================================
         PAGE TRANSITION
    ===================================================== -->

    <div class="page-transition"></div>


    <!-- =====================================================
         MAIN WELCOME PAGE
    ===================================================== -->

    <div class="welcome-container">


        <!-- Background atmosphere -->

        <div class="ambient-light"></div>


        <!-- Liquid shapes -->

        <div class="liquid liquid-top-left"></div>

        <div class="liquid liquid-top-right"></div>

        <div class="liquid liquid-bottom-left"></div>

        <div class="liquid liquid-bottom-right"></div>


        <!-- =================================================
             STARS
        ================================================== -->

        <div class="stars">

            @for ($i = 0; $i < 20; $i++)

                <span class="star"></span>

            @endfor

        </div>


        <!-- Bright stars -->

        <span class="bright-star bright-star-1"></span>

        <span class="bright-star bright-star-2"></span>

        <span class="bright-star bright-star-3"></span>

        <span class="bright-star bright-star-4"></span>


        <!-- =================================================
             CONTENT
        ================================================== -->

        <main class="content">


            <!-- Logo -->

            <div class="logo">
                RUPAVUE
            </div>


            <!-- Subtitle -->

            <div class="subtitle">
                AI PHOTO EXPERIENCE
            </div>


            <!-- Welcome title -->

            <h1 class="welcome-title">
                Welcome to RupaVue
            </h1>


            <!-- Camera divider -->

            <div class="camera-divider">

                <span class="camera-line"></span>

                <span class="camera-icon">
                    📷
                </span>

                <span class="camera-line right"></span>

            </div>


            <!-- Description -->

            <p class="description">

                Transform your photo into a unique
                <br>

                AI-powered experience.

                <br>

                Choose your theme, strike a pose,

                <br>

                and let RupaVue create your perfect photo.

            </p>


            <!-- Start Session -->

            <a
                href="{{ route('photobooth.scene') }}"
                class="start-button"
                id="startSessionButton"
            >

                <span class="button-camera">
                    📷
                </span>

                <span>
                    START SESSION
                </span>

                <span class="button-arrow">
                    →
                </span>

            </a>


        </main>


        <!-- =================================================
             FOOTER
        ================================================== -->

        <div class="footer-line"></div>

        <div class="bottom-text">
            AI POWERED PHOTO BOOTH
        </div>


    </div>


    <!-- =====================================================
         PAGE TRANSITION JAVASCRIPT
    ===================================================== -->

    <script>

        const startSessionButton =
            document.getElementById(
                'startSessionButton'
            );

        const pageTransition =
            document.querySelector(
                '.page-transition'
            );

        const welcomeContainer =
            document.querySelector(
                '.welcome-container'
            );


        if (
            startSessionButton &&
            pageTransition &&
            welcomeContainer
        ) {

            startSessionButton.addEventListener(
                'click',
                function (event) {

                    event.preventDefault();


                    const destination =
                        this.href;


                    /*
                     * Start page transition
                     */

                    pageTransition.classList.add(
                        'active'
                    );


                    welcomeContainer.classList.add(
                        'page-exit'
                    );


                    /*
                     * Navigate after animation
                     */

                    setTimeout(
                        function () {

                            window.location.href =
                                destination;

                        },
                        500
                    );

                }
            );

        }

    </script>


</body>

</html>