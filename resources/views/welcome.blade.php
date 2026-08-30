<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

            background: #071b4a;

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
                    ellipse at center,
                    #ffffff 0%,
                    #f8fbff 18%,
                    #dceaff 36%,
                    #6f9fe0 60%,
                    #022050 100%,
                    #021742 100%
                );

        }


        /* =====================================================
           MOVING BLUE LIGHT
        ===================================================== */

        .ambient-light {

            position: absolute;

            inset: -20%;

            background:

                radial-gradient(
                    ellipse at 50% 45%,
                    rgba(255,255,255,0.65),
                    transparent 35%
                ),

                radial-gradient(
                    ellipse at 15% 10%,
                    rgba(0,90,255,0.65),
                    transparent 25%
                ),

                radial-gradient(
                    ellipse at 85% 15%,
                    rgba(0,180,255,0.55),
                    transparent 27%
                ),

                radial-gradient(
                    ellipse at 15% 90%,
                    rgba(75,50,255,0.60),
                    transparent 28%
                ),

                radial-gradient(
                    ellipse at 90% 90%,
                    rgba(0,100,255,0.60),
                    transparent 30%
                );

            filter: blur(45px);

            animation:
                ambientMove
                16s
                ease-in-out
                infinite;

            z-index: 0;

            pointer-events: none;

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
                    translate(2%, -2%)
                    scale(1.04);

            }

            50% {

                transform:
                    translate(-2%, 2%)
                    scale(1.08);

            }

            75% {

                transform:
                    translate(2%, 1%)
                    scale(1.04);

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

            filter:
                drop-shadow(
                    0 0 18px
                    rgba(30,130,255,0.45)
                );

            opacity: 0.95;

        }


        .liquid::after {

            content: "";

            position: absolute;

            inset: 0;

            border-radius: inherit;

            background:

                linear-gradient(
                    135deg,
                    rgba(255,255,255,0.28),
                    transparent 35%,
                    rgba(255,255,255,0.05)
                );

            mix-blend-mode: screen;

        }


        /* =====================================================
           TOP LEFT LIQUID
        ===================================================== */

        .liquid-top-left {

            width: 430px;

            height: 390px;

            top: -190px;

            left: -120px;

            border-radius:
                48% 52% 60% 40%
                /
                58% 42% 58% 42%;

            background:

                radial-gradient(
                    circle at 70% 75%,
                    #3f82d8,
                    #235faf,
                    #0d3f91,
                    #05245f
                );

            transform:
                rotate(-12deg);

            animation:
                liquidTopLeft
                11s
                ease-in-out
                infinite;

        }


        @keyframes liquidTopLeft {

            0%,
            100% {

                border-radius:
                    48% 52% 60% 40%
                    /
                    58% 42% 58% 42%;

                transform:
                    rotate(-12deg)
                    translate(0,0);

            }

            50% {

                border-radius:
                    65% 35% 42% 58%
                    /
                    40% 60% 55% 45%;

                transform:
                    rotate(-5deg)
                    translate(30px,25px);

            }

        }


        /* =====================================================
           TOP RIGHT LIQUID
        ===================================================== */

        .liquid-top-right {

            width: 470px;

            height: 430px;

            top: -190px;

            right: -160px;

            border-radius:
                55% 45% 35% 65%
                /
                48% 52% 48% 52%;

            background:

                radial-gradient(
                    circle at 30% 70%,
                    #3ba8e8
                    #247fc5
                    #0e55a8
                    #063477
                );

            transform:
                rotate(8deg);

            animation:
                liquidTopRight
                13s
                ease-in-out
                infinite;

        }


        @keyframes liquidTopRight {

            0%,
            100% {

                border-radius:
                    55% 45% 35% 65%
                    /
                    48% 52% 48% 52%;

                transform:
                    rotate(8deg)
                    translate(0,0);

            }

            50% {

                border-radius:
                    35% 65% 58% 42%
                    /
                    60% 40% 55% 45%;

                transform:
                    rotate(14deg)
                    translate(-25px,35px);

            }

        }


        /* =====================================================
           BOTTOM LEFT LIQUID
        ===================================================== */

        .liquid-bottom-left {

            width: 450px;

            height: 470px;

            bottom: -210px;

            left: -150px;

            border-radius:
                60% 40% 35% 65%
                /
                48% 52% 58% 42%;

            background:

                radial-gradient(
                    circle at 65% 30%,
                    #806ee8
                    #514fc5
                    #3048b2
                    #102f91
                    #061f68
                );

            transform:
                rotate(-8deg);

            animation:
                liquidBottomLeft
                12s
                ease-in-out
                infinite;

        }


        @keyframes liquidBottomLeft {

            0%,
            100% {

                border-radius:
                    60% 40% 35% 65%
                    /
                    48% 52% 58% 42%;

                transform:
                    rotate(-8deg)
                    translate(0,0);

            }

            50% {

                border-radius:
                    40% 60% 65% 35%
                    /
                    55% 45% 40% 60%;

                transform:
                    rotate(2deg)
                    translate(35px,-25px);

            }

        }


        /* =====================================================
           BOTTOM RIGHT LIQUID
        ===================================================== */

        .liquid-bottom-right {

            width: 470px;

            height: 450px;

            bottom: -220px;

            right: -140px;

            border-radius:
                38% 62% 60% 40%
                /
                50% 50% 45% 55%;

            background:

                radial-gradient(
                    circle at 30% 25%,
                    #459ce8
                    #2874c9
                    #124ca8
                    #062e78
                );

            transform:
                rotate(6deg);

            animation:
                liquidBottomRight
                14s
                ease-in-out
                infinite;

        }


        @keyframes liquidBottomRight {

            0%,
            100% {

                border-radius:
                    38% 62% 60% 40%
                    /
                    50% 50% 45% 55%;

                transform:
                    rotate(6deg)
                    translate(0,0);

            }

            50% {

                border-radius:
                    58% 42% 42% 58%
                    /
                    40% 60% 55% 45%;

                transform:
                    rotate(-3deg)
                    translate(-30px,-20px);

            }

        }


        /* =====================================================
           LIQUID HIGHLIGHT
        ===================================================== */

        .liquid-glow {

            position: absolute;

            z-index: 2;

            pointer-events: none;

            width: 100%;

            height: 100%;

            background:

                radial-gradient(
                    ellipse at center,
                    rgba(255,255,255,0.12),
                    transparent 55%
                );

            animation:
                glowPulse
                5s
                ease-in-out
                infinite;

        }


        @keyframes glowPulse {

            0%,
            100% {

                opacity: 0.5;

            }

            50% {

                opacity: 1;

            }

        }


        /* =====================================================
           STARS
        ===================================================== */

        .stars {

            position: absolute;

            inset: 0;

            z-index: 3;

            pointer-events: none;

        }


        .star {

            position: absolute;

            width: 3px;

            height: 3px;

            border-radius: 50%;

            background: #ffffff;

            box-shadow:

                0 0 5px
                #ffffff,

                0 0 12px
                rgba(80,170,255,0.95);

            opacity: 0.9;

            animation:
                starTwinkle
                3s
                ease-in-out
                infinite;

        }


        /* Star positions */

        .star:nth-child(1) {
            top: 7%;
            left: 8%;
            animation-delay: 0s;
        }

        .star:nth-child(2) {
            top: 12%;
            left: 22%;
            animation-delay: 0.7s;
        }

        .star:nth-child(3) {
            top: 5%;
            left: 45%;
            animation-delay: 1.2s;
        }

        .star:nth-child(4) {
            top: 10%;
            left: 67%;
            animation-delay: 0.3s;
        }

        .star:nth-child(5) {
            top: 16%;
            left: 88%;
            animation-delay: 1.8s;
        }

        .star:nth-child(6) {
            top: 31%;
            left: 12%;
            animation-delay: 2.1s;
        }

        .star:nth-child(7) {
            top: 28%;
            left: 82%;
            animation-delay: 0.8s;
        }

        .star:nth-child(8) {
            top: 43%;
            left: 5%;
            animation-delay: 1.4s;
        }

        .star:nth-child(9) {
            top: 45%;
            left: 94%;
            animation-delay: 2.3s;
        }

        .star:nth-child(10) {
            top: 61%;
            left: 15%;
            animation-delay: 0.5s;
        }

        .star:nth-child(11) {
            top: 66%;
            left: 85%;
            animation-delay: 1.6s;
        }

        .star:nth-child(12) {
            top: 77%;
            left: 8%;
            animation-delay: 2.4s;
        }

        .star:nth-child(13) {
            top: 82%;
            left: 28%;
            animation-delay: 0.9s;
        }

        .star:nth-child(14) {
            top: 73%;
            left: 72%;
            animation-delay: 1.3s;
        }

        .star:nth-child(15) {
            top: 90%;
            left: 58%;
            animation-delay: 2.1s;
        }

        .star:nth-child(16) {
            top: 87%;
            left: 92%;
            animation-delay: 0.4s;
        }

        .star:nth-child(17) {
            top: 36%;
            left: 74%;
            animation-delay: 2.6s;
        }

        .star:nth-child(18) {
            top: 54%;
            left: 25%;
            animation-delay: 1.9s;
        }

        .star:nth-child(19) {
            top: 20%;
            left: 54%;
            animation-delay: 0.6s;
        }

        .star:nth-child(20) {
            top: 69%;
            left: 48%;
            animation-delay: 1.1s;
        }


        @keyframes starTwinkle {

            0%,
            100% {

                opacity: 0.35;

                transform:
                    scale(0.7);

            }

            50% {

                opacity: 1;

                transform:
                    scale(1.7);

            }

        }


        /* =====================================================
           BRIGHT STAR
        ===================================================== */

        .bright-star {

            position: absolute;

            width: 5px;

            height: 5px;

            background: #ffffff;

            border-radius: 50%;

            box-shadow:

                0 0 8px
                #ffffff,

                0 0 20px
                #49a6ff,

                0 0 35px
                #248cff;

            z-index: 3;

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
                rgba(255,255,255,0.9);

        }


        .bright-star::before {

            width: 35px;

            height: 1px;

        }


        .bright-star::after {

            width: 1px;

            height: 35px;

        }


        .bright-star-1 {

            top: 13%;

            left: 23%;

        }


        .bright-star-2 {

            top: 18%;

            right: 25%;

            animation-delay: 1.5s;

        }


        .bright-star-3 {

            bottom: 15%;

            left: 14%;

            animation-delay: 2.5s;

        }


        @keyframes brightTwinkle {

            0%,
            100% {

                opacity: 0.5;

                transform:
                    scale(0.7);

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

            text-align: center;

            margin-top: -10px;

        }


        /* =====================================================
           LOGO
        ===================================================== */

        .logo {

            color: #050914;

            font-size:
                clamp(
                    52px,
                    8vw,
                    92px
                );

            font-weight: 800;

            letter-spacing:
                clamp(
                    7px,
                    1.3vw,
                    15px
                );

            line-height: 1;

            margin-bottom: 16px;

            text-shadow:

                0 4px 12px
                rgba(255,255,255,0.65);

        }


        /* =====================================================
           SUBTITLE
        ===================================================== */

        .subtitle {

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 14px;

            color: #1679ed;

            font-size:
                clamp(
                    12px,
                    1.5vw,
                    19px
                );

            font-weight: 500;

            letter-spacing: 5px;

            margin-bottom: 48px;

            text-shadow:

                0 1px 8px
                rgba(255,255,255,0.85);

        }


        .subtitle::before,
        .subtitle::after {

            content: "";

            width: 42px;

            height: 1px;

            background:

                linear-gradient(
                    to right,
                    transparent,
                    #2589ef
                );

        }


        .subtitle::after {

            background:

                linear-gradient(
                    to left,
                    transparent,
                    #2589ef
                );

        }


        /* =====================================================
           WELCOME TITLE
        ===================================================== */

        .welcome-title {

            color: #060b19;

            font-size:
                clamp(
                    30px,
                    4vw,
                    52px
                );

            font-weight: 700;

            line-height: 1.2;

            margin-bottom: 22px;

            text-shadow:

                0 3px 10px
                rgba(255,255,255,0.7);

        }


        /* =====================================================
           CAMERA DIVIDER
        ===================================================== */

        .camera-divider {

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 18px;

            margin-bottom: 24px;

        }


        .camera-line {

            width: 60px;

            height: 1px;

            background:

                linear-gradient(
                    to right,
                    transparent,
                    #1686f2
                );

        }


        .camera-line.right {

            background:

                linear-gradient(
                    to left,
                    transparent,
                    #1686f2
                );

        }


        .camera-icon {

            color: #087cff;

            font-size: 30px;

            filter:

                drop-shadow(
                    0 0 8px
                    rgba(0,120,255,0.65)
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

            color: #101827;

            font-size:
                clamp(
                    14px,
                    1.5vw,
                    18px
                );

            line-height: 1.8;

            margin-bottom: 42px;

            text-shadow:

                0 1px 5px
                rgba(255,255,255,0.8);

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

            width: 540px;

            max-width: 90vw;

            padding:
                20px
                28px;

            border:
                2px solid
                #087cff;

            border-radius: 60px;

            background:

                linear-gradient(
                    135deg,
                    #061b4d,
                    #020a25
                );

            color: #ffffff;

            font-size: 17px;

            font-weight: 700;

            letter-spacing: 4px;

            text-decoration: none;

            text-transform: uppercase;

            box-shadow:

                0 0 15px
                rgba(0,125,255,0.8),

                0 0 35px
                rgba(0,100,255,0.4),

                0 12px 35px
                rgba(0,50,130,0.35);

            transition:

                transform 0.25s ease,

                box-shadow 0.25s ease,

                border-color 0.25s ease;

            overflow: hidden;

        }


        .start-button::before {

            content: "";

            position: absolute;

            top: 0;

            left: -120%;

            width: 70%;

            height: 100%;

            background:

                linear-gradient(
                    90deg,
                    transparent,
                    rgba(255,255,255,0.18),
                    transparent
                );

            transform:
                skewX(-20deg);

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
                #55b7ff;

            box-shadow:

                0 0 20px
                rgba(0,135,255,0.95),

                0 0 50px
                rgba(0,100,255,0.5),

                0 15px 40px
                rgba(0,50,130,0.4);

        }


        .start-button:active {

            transform:
                translateY(0)
                scale(0.99);

        }


        .button-camera {

            color: #198cff;

            font-size: 25px;

            filter:

                drop-shadow(
                    0 0 8px
                    rgba(0,140,255,0.8)
                );

        }


        .button-arrow {

            color: #198cff;

            font-size: 29px;

            transition:
                transform 0.2s ease;

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
                    #2993ff,
                    transparent
                );

            box-shadow:

                0 0 8px
                rgba(0,130,255,0.6);

        }


        .bottom-text {

            position: absolute;

            z-index: 10;

            left: 50%;

            bottom: 27px;

            transform:
                translateX(-50%);

            color: #12315f;

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
                    #edf7ff 22%,
                    #b9dcff 50%,
                    #2779db 100%
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
                    rgba(90,180,255,0.8) 35%,
                    rgba(30,110,230,0.3) 65%,
                    transparent 76%
                );

            filter:
                blur(8px);

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
           WELCOME EXIT
        ===================================================== */

        .welcome-container.page-exit {

            transform:
                scale(1.025);

            opacity: 0;

            transition:

                opacity 0.45s ease,

                transform 0.55s ease;

        }


        /* =====================================================
           TABLET
        ===================================================== */

        @media (max-width: 800px) {

            .logo {

                font-size: 58px;

            }


            .subtitle {

                margin-bottom: 35px;

            }


            .description {

                max-width: 550px;

            }


            .start-button {

                width: 430px;

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

                font-size: 42px;

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

                width: 260px;

                height: 250px;

                top: -120px;

                left: -100px;

            }


            .liquid-top-right {

                width: 280px;

                height: 270px;

                top: -110px;

                right: -110px;

            }


            .liquid-bottom-left {

                width: 280px;

                height: 300px;

                bottom: -130px;

                left: -110px;

            }


            .liquid-bottom-right {

                width: 300px;

                height: 300px;

                bottom: -140px;

                right: -110px;

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
         WELCOME PAGE
    ===================================================== -->

    <div class="welcome-container">


        <!-- Background -->

        <div class="ambient-light"></div>


        <!-- Liquid shapes -->

        <div class="liquid liquid-top-left"></div>

        <div class="liquid liquid-top-right"></div>

        <div class="liquid liquid-bottom-left"></div>

        <div class="liquid liquid-bottom-right"></div>


        <!-- Stars -->

        <div class="stars">

            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>

        </div>


        <!-- Bright stars -->

        <span class="bright-star bright-star-1"></span>

        <span class="bright-star bright-star-2"></span>

        <span class="bright-star bright-star-3"></span>


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


            <!-- Welcome -->

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
         PAGE TRANSITION SCRIPT
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
                     * Start transition
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