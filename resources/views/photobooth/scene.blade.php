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
                Arial,
                Helvetica,
                sans-serif;

            color: #07142f;

            overflow-x: hidden;

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
           PAGE
        ===================================================== */

        .scene-page {

            position: relative;

            width: 100%;
            min-height: 100vh;
            min-height: 100dvh;

            overflow: hidden;

            padding:
                42px
                5vw
                35px;

            display: flex;
            flex-direction: column;
            align-items: center;

            background:

                radial-gradient(
                    ellipse 60% 65% at 50% 43%,
                    rgba(255,255,255,0.90) 0%,
                    rgba(231,243,255,0.72) 25%,
                    rgba(102,165,239,0.35) 50%,
                    rgba(8,69,160,0.25) 72%,
                    transparent 100%
                );

        }


        /* =====================================================
           BLUE ATMOSPHERE
        ===================================================== */

        .scene-page::before {

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
                atmosphereMove
                18s
                ease-in-out
                infinite;

        }


        @keyframes atmosphereMove {

            0%,
            100% {
                transform:
                    scale(1);
            }

            50% {
                transform:
                    scale(1.06);
            }

        }


        /* =====================================================
           LIQUID CORNER SHAPES
        ===================================================== */

        .liquid {

            position: absolute;

            z-index: 1;

            pointer-events: none;

            opacity: .9;

            filter:
                drop-shadow(
                    0 0 18px
                    rgba(40,140,255,.55)
                );

        }


        .liquid::before {

            content: "";

            position: absolute;

            width: 75%;
            height: 35%;

            top: 4%;
            left: 10%;

            border-radius: 50%;

            background:
                radial-gradient(
                    ellipse,
                    rgba(255,255,255,.8),
                    rgba(255,255,255,.25) 35%,
                    transparent 75%
                );

            filter: blur(10px);

        }


        .liquid-top-left {

            width: 390px;
            height: 330px;

            top: -190px;
            left: -130px;

            border-radius:
                65% 35% 58% 42%
                /
                45% 55% 45% 55%;

            background:
                radial-gradient(
                    ellipse at 65% 70%,
                    #5daaff,
                    #2874d5 45%,
                    #0b3d91 75%,
                    #031c56
                );

            transform: rotate(-8deg);

            animation:
                liquidOne
                12s
                ease-in-out
                infinite;

        }


        .liquid-top-right {

            width: 420px;
            height: 350px;

            top: -180px;
            right: -135px;

            border-radius:
                35% 65% 45% 55%
                /
                60% 40% 60% 40%;

            background:
                radial-gradient(
                    ellipse at 35% 70%,
                    #64d1ff,
                    #2695e5 42%,
                    #0862bd 70%,
                    #032d72
                );

            transform: rotate(8deg);

            animation:
                liquidTwo
                14s
                ease-in-out
                infinite;

        }


        .liquid-bottom-left {

            width: 400px;
            height: 360px;

            bottom: -210px;
            left: -125px;

            border-radius:
                45% 55% 65% 35%
                /
                55% 45% 60% 40%;

            background:
                radial-gradient(
                    ellipse at 65% 20%,
                    #a08fff,
                    #665fe0 38%,
                    #3549b1 65%,
                    #0a286d
                );

            transform: rotate(-5deg);

            animation:
                liquidThree
                13s
                ease-in-out
                infinite;

        }


        .liquid-bottom-right {

            width: 420px;
            height: 370px;

            bottom: -215px;
            right: -130px;

            border-radius:
                60% 40% 42% 58%
                /
                45% 55% 60% 40%;

            background:
                radial-gradient(
                    ellipse at 30% 20%,
                    #66c5ff,
                    #2b82dd 40%,
                    #1253ac 68%,
                    #032862
                );

            transform: rotate(6deg);

            animation:
                liquidFour
                15s
                ease-in-out
                infinite;

        }


        @keyframes liquidOne {

            0%,100% {
                transform:
                    rotate(-8deg)
                    translate(0,0);
            }

            50% {
                transform:
                    rotate(-2deg)
                    translate(20px,15px);
            }

        }


        @keyframes liquidTwo {

            0%,100% {
                transform:
                    rotate(8deg)
                    translate(0,0);
            }

            50% {
                transform:
                    rotate(13deg)
                    translate(-20px,15px);
            }

        }


        @keyframes liquidThree {

            0%,100% {
                transform:
                    rotate(-5deg)
                    translate(0,0);
            }

            50% {
                transform:
                    rotate(2deg)
                    translate(20px,-15px);
            }

        }


        @keyframes liquidFour {

            0%,100% {
                transform:
                    rotate(6deg)
                    translate(0,0);
            }

            50% {
                transform:
                    rotate(-2deg)
                    translate(-20px,-15px);
            }

        }


        /* =====================================================
           STARS
        ===================================================== */

        .stars {

            position: absolute;

            inset: 0;

            z-index: 2;

            pointer-events: none;

        }


        .star {

            position: absolute;

            width: 3px;
            height: 3px;

            border-radius: 50%;

            background: white;

            box-shadow:
                0 0 7px white,
                0 0 14px #62baff;

            animation:
                twinkle
                3s
                ease-in-out
                infinite;

        }


        .star:nth-child(1) {
            top: 8%;
            left: 8%;
        }

        .star:nth-child(2) {
            top: 15%;
            left: 23%;
            animation-delay: .8s;
        }

        .star:nth-child(3) {
            top: 7%;
            left: 48%;
            animation-delay: 1.2s;
        }

        .star:nth-child(4) {
            top: 12%;
            right: 27%;
            animation-delay: 1.8s;
        }

        .star:nth-child(5) {
            top: 9%;
            right: 8%;
            animation-delay: .5s;
        }

        .star:nth-child(6) {
            top: 28%;
            left: 13%;
            animation-delay: 1.5s;
        }

        .star:nth-child(7) {
            top: 25%;
            right: 12%;
            animation-delay: 2s;
        }

        .star:nth-child(8) {
            top: 43%;
            left: 5%;
            animation-delay: .3s;
        }

        .star:nth-child(9) {
            top: 40%;
            right: 7%;
            animation-delay: 1.4s;
        }

        .star:nth-child(10) {
            top: 55%;
            left: 18%;
            animation-delay: 2.3s;
        }

        .star:nth-child(11) {
            top: 60%;
            right: 17%;
            animation-delay: .9s;
        }

        .star:nth-child(12) {
            top: 76%;
            left: 9%;
            animation-delay: 1.6s;
        }

        .star:nth-child(13) {
            top: 82%;
            left: 32%;
            animation-delay: .6s;
        }

        .star:nth-child(14) {
            top: 72%;
            right: 30%;
            animation-delay: 1.9s;
        }

        .star:nth-child(15) {
            top: 85%;
            right: 9%;
            animation-delay: 2.4s;
        }


        @keyframes twinkle {

            0%,100% {
                opacity: .3;
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

            z-index: 3;

            width: 90px;

            height: 2px;

            border-radius: 999px;

            background:
                linear-gradient(
                    90deg,
                    transparent,
                    rgba(255,255,255,.25),
                    white
                );

            transform:
                rotate(-35deg);

            opacity: 0;

            filter:
                drop-shadow(
                    0 0 5px
                    #ffffff
                );

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

            transform:
                translateY(-50%);

            border-radius: 50%;

            background: white;

            box-shadow:
                0 0 8px white,
                0 0 15px #52aaff;

        }


        .shooting-star.one {

            top: 13%;
            left: 15%;

        }


        .shooting-star.two {

            top: 19%;
            right: 20%;

            animation-delay: 2.5s;

        }


        .shooting-star.three {

            top: 54%;
            right: 8%;

            animation-delay: 5s;

        }


        @keyframes shootingStar {

            0% {

                opacity: 0;

                transform:
                    translate(0,0)
                    rotate(-35deg);

            }

            5% {

                opacity: 1;

            }

            18% {

                opacity: 1;

                transform:
                    translate(-170px,110px)
                    rotate(-35deg);

            }

            20%,
            100% {

                opacity: 0;

                transform:
                    translate(-210px,140px)
                    rotate(-35deg);

            }

        }


        /* =====================================================
           MAIN CONTENT
        ===================================================== */

        .scene-content {

            position: relative;

            z-index: 10;

            width: min(1100px, 94vw);

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

            margin-bottom: 30px;

        }


        .scene-header h1 {

            color: #07142f;

            font-size:
                clamp(
                    32px,
                    4vw,
                    52px
                );

            font-weight: 800;

            margin-bottom: 8px;

            text-shadow:
                0 2px 8px
                rgba(255,255,255,.8);

        }


        .scene-header p {

            color: #345577;

            font-size: 15px;

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

            padding:
                8px
                5px
                20px;

            scrollbar-width: none;

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
            height: 315px;
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

            transition:
                transform .3s ease,
                box-shadow .3s ease,
                border-color .3s ease;

        }


        .theme-card:hover {

            transform:
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

                0 0 0 1px
                rgba(100,205,255,.5),

                0 0 30px
                rgba(15,140,255,.9),

                0 18px 45px
                rgba(0,50,150,.45);

            transform:
                translateY(-5px);

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

            opacity: .72;

            transition:
                transform .5s ease,
                opacity .3s ease;

        }


        .theme-card:hover
        .theme-image {

            transform:
                scale(1.06);

            opacity: .85;

        }


        .theme-overlay {

            position: absolute;

            inset: 0;

            background:

                linear-gradient(
                    to top,
                    rgba(2,14,43,.98) 0%,
                    rgba(2,20,60,.65) 45%,
                    rgba(0,40,100,.08) 75%,
                    transparent 100%
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
           CAMERA OPTION
        ===================================================== */

        .camera-option {

            width: 100%;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 20px;

            padding:
                18px
                24px;

            margin-bottom: 18px;

            border-radius: 20px;

            background:
                rgba(255,255,255,.82);

            border:
                1px solid
                rgba(255,255,255,.95);

            box-shadow:

                0 12px 30px
                rgba(0,45,110,.16),

                inset 0 1px 0
                rgba(255,255,255,.95);

            backdrop-filter:
                blur(10px);

        }


        .camera-info {

            display: flex;

            flex-direction: column;

            gap: 4px;

        }


        .camera-info strong {

            color:
                #071b43;

            font-size: 16px;

        }


        .camera-info span {

            color:
                #55718f;

            font-size: 12px;

        }


        /* =====================================================
           ON/OFF TOGGLE
        ===================================================== */

        .toggle-switch {

            position: relative;

            flex-shrink: 0;

            width: 82px;

            height: 38px;

            cursor: pointer;

        }


        .toggle-switch input {

            display: none;

        }


        .toggle-slider {

            position: absolute;

            inset: 0;

            border-radius: 999px;

            background:
                #14505a;

            overflow: hidden;

            transition:
                .25s ease;

            box-shadow:
                inset 0 1px 3px
                rgba(0,0,0,.2);

        }


        .toggle-knob {

            position: absolute;

            width: 30px;
            height: 30px;

            top: 4px;
            left: 4px;

            border-radius: 50%;

            background: white;

            box-shadow:
                0 2px 6px
                rgba(0,0,0,.25);

            transition:
                transform .25s ease;

        }


        .toggle-text {

            position: absolute;

            top: 50%;

            transform:
                translateY(-50%);

            color: white;

            font-size: 14px;

            font-weight: 700;

            pointer-events: none;

        }


        .off-text {

            right: 10px;

            opacity: 1;

        }


        .on-text {

            left: 12px;

            opacity: 0;

        }


        .toggle-switch input:checked
        + .toggle-slider {

            background:
                linear-gradient(
                    135deg,
                    #20c9a6,
                    #18aeca
                );

            box-shadow:

                0 0 12px
                rgba(25,190,220,.45);

        }


        .toggle-switch input:checked
        + .toggle-slider
        .toggle-knob {

            transform:
                translateX(44px);

        }


        .toggle-switch input:checked
        + .toggle-slider
        .on-text {

            opacity: 1;

        }


        .toggle-switch input:checked
        + .toggle-slider
        .off-text {

            opacity: 0;

        }


        /* =====================================================
           BOTTOM ACTION BAR
        ===================================================== */

        .selection-area {
            width: 100%;

            display: flex;

            flex-direction: column;

            align-items: center;

            gap: 14px;

            margin-top: 2px;
        }


        .action-bar {
            width: 100%;

            min-height: 64px;

            display: flex;

            align-items: center;

            justify-content: flex-start;

            padding:
                14px 24px;

            border-radius: 18px;

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
        }


        .selected-info {

            display: flex;

            align-items: center;

            gap: 10px;

            flex-wrap: wrap;

            color: #55718f;

            font-size: 14px;

        }


        .selected-info strong {

            color:
                #0871e9;

            font-size: 16px;

        }


        .selected-camera {

            display: none;

            align-items: center;

            gap: 7px;

            padding-left: 14px;

            margin-left: 5px;

            border-left:
                1px solid
                #c9d9ec;

            color:
                #0871e9;

            font-weight: 700;

        }


        .selected-camera.show {

            display: flex;

        }


        .next-button {

            min-width: 240px;

            border: none;

            border-radius: 30px;

            padding:
                15px 30px;

            background:
                linear-gradient(
                    135deg,
                    #064768,
                    #003347
                );

            color: white;

            font-size: 13px;

            font-weight: 800;

            letter-spacing: .8px;

            cursor: pointer;

            box-shadow:

                0 0 18px
                rgba(0,130,255,.45),

                0 8px 20px
                rgba(0,40,90,.3);

            transition:
                .25s ease;
        }


        .next-button:hover {

            transform:
                translateY(-3px);

            background:
                linear-gradient(
                    135deg,
                    #0872a0,
                    #00455e
                );

            box-shadow:

                0 0 28px
                rgba(0,150,255,.7);

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

                height: 310px;

            }


            .camera-option {

                padding:
                    16px;

            }


            .camera-info strong {

                font-size: 14px;

            }


            .camera-info span {

                font-size: 11px;

            }


            .action-bar {

                flex-direction: column;

                align-items: stretch;

                padding:
                    16px;

            }


            .selected-info {

                justify-content: center;

            }


            .next-button {

                width: 100%;

            }


            .liquid-top-left,
            .liquid-top-right {

                transform:
                    scale(.65);

            }


            .liquid-bottom-left,
            .liquid-bottom-right {

                transform:
                    scale(.65);

            }

        }

    </style>
</head>


<body>

<div class="scene-page">


    <!-- =====================================================
         BACKGROUND
    ===================================================== -->

    <div class="liquid liquid-top-left"></div>

    <div class="liquid liquid-top-right"></div>

    <div class="liquid liquid-bottom-left"></div>

    <div class="liquid liquid-bottom-right"></div>


    <!-- =====================================================
         STARS
    ===================================================== -->

    <div class="stars">

        @for ($i = 0; $i < 15; $i++)
            <span class="star"></span>
        @endfor

    </div>


    <!-- Shooting stars -->

    <span class="shooting-star one"></span>

    <span class="shooting-star two"></span>

    <span class="shooting-star three"></span>


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
                        $themeImage = $theme->thumbnail_path ?? null;

                        $themePrompt = trim(
                            ($theme->prompt_prefix ?? '') . ' ' .
                            ($theme->prompt_suffix ?? '')
                        );
                    @endphp


                    <div
                        class="theme-card {{ $loop->first ? 'selected' : '' }}"
                        data-theme-id="{{ $theme->id }}"
                        data-theme-name="{{ $theme->theme_name }}"
                        data-theme-prompt="{{ $themePrompt }}"
                    >


                        @if ($themeImage)

                            <img
                                src="{{ $themeImage }}"
                                alt="{{ $theme->theme_name }}"
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
                            color:#173a68;
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
             CAMERA OPTION
        ================================================== -->

        <div class="camera-option">


            <div class="camera-info">

                <strong>
                    0.5 High Angle Camera
                </strong>

                <span>
                    Capture from a slightly elevated angle for a more dynamic and cinematic look.
                </span>

            </div>


            <!-- ON / OFF -->

            <label
                class="toggle-switch"
                aria-label="Toggle 0.5 High Angle Camera"
            >

                <input
                    type="checkbox"
                    id="highAngleToggle"
                >

                <span class="toggle-slider">

                    <span class="toggle-text on-text">
                        ON
                    </span>

                    <span class="toggle-text off-text">
                        OFF
                    </span>

                    <span class="toggle-knob"></span>

                </span>

            </label>

        </div>


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
                        {{ $themes->first()->theme_name ?? 'None' }}
                    </strong>

                    <span
                        class="selected-camera"
                        id="selectedCamera"
                    >
                        📷 0.5 High Angle Camera
                    </span>

                </div>

            </div>


            <button
                type="button"
                class="next-button"
                id="nextButton"
            >
                NEXT: CAPTURE PHOTO →
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

    const highAngleToggle =
        document.getElementById('highAngleToggle');

    const selectedThemeName =
        document.getElementById('selectedThemeName');

    const selectedCamera =
        document.getElementById('selectedCamera');

    const nextButton =
        document.getElementById('nextButton');


    let selectedIndex = 0;


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


        selectedThemeName.textContent =
            themeName;


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
         * Keep selected card visible
         */

        themeTrack.scrollTo({
            left: selectedCard.offsetLeft - themeTrack.offsetLeft - 10,
            behavior: 'smooth'
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
       LEFT BUTTON
    ===================================================== */

    previousTheme.addEventListener(
        'click',
        function () {

            selectTheme(
                selectedIndex - 1
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
                selectedIndex + 1
            );

        }
    );


    /* =====================================================
       0.5 CAMERA TOGGLE
    ===================================================== */

    function updateCameraSetting() {

        const enabled =
            highAngleToggle.checked;


        if (enabled) {

            /*
             * Show 0.5 option in selected area
             */

            selectedCamera.classList.add(
                'show'
            );


            /*
             * Save setting
             */

            sessionStorage.setItem(
                'rupavueHighAngle',
                'true'
            );


            /*
             * Prompt that will later be
             * combined with the theme prompt
             */

            sessionStorage.setItem(
                'rupavueCameraPrompt',

                'Capture the subject from a 0.5x high-angle perspective, with the camera positioned slightly above the subject and angled slightly downward. Maintain natural proportions and keep the subject clearly visible.'
            );

        } else {

            /*
             * Normal camera automatically
             */

            selectedCamera.classList.remove(
                'show'
            );


            sessionStorage.setItem(
                'rupavueHighAngle',
                'false'
            );


            sessionStorage.setItem(
                'rupavueCameraPrompt',
                ''
            );

        }

    }


    highAngleToggle.addEventListener(
        'change',
        updateCameraSetting
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


    const savedHighAngle =
        sessionStorage.getItem(
            'rupavueHighAngle'
        );


    if (savedHighAngle === 'true') {

        highAngleToggle.checked = true;

        updateCameraSetting();

    }


    /* =====================================================
       NEXT BUTTON
    ===================================================== */

    nextButton.addEventListener(
        'click',
        function () {

            if (!themeCards.length) {

                alert(
                    'Please select a theme first.'
                );

                return;

            }


            /*
             * Make sure current theme is saved
             */

            selectTheme(selectedIndex);


            /*
             * Save camera setting one more time
             */

            updateCameraSetting();


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