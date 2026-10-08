<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1">

    <title>RUPAVUE — AI Photo Experience</title>

    <meta name="description"
        content="RUPAVUE AI Photo Experience — Transform your photos into unforgettable AI art.">

    <style>
        /* =========================================================
           RUPAVUE — DARK BLUE AI PHOTO EXPERIENCE
           ========================================================= */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            min-height: 100vh;
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

            color: #ffffff;

            /*
             * No Gotham / Druk font file is required.
             * Arial Black gives a similar heavy display appearance.
             */
            font-family: "Arial Black", Arial, Helvetica, sans-serif;

            font-weight: 900;
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
        }

        body * {
            font-weight: 900;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button {
            font: inherit;
        }


        /* =========================================================
           BACKGROUND
           ========================================================= */

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


        /* =========================================================
           LIQUID GLASS BACKGROUND SHAPES
           ========================================================= */

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


        /* =========================================================
           STAR FIELD
           ========================================================= */

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


        /* =========================================================
           SHOOTING STARS
           ========================================================= */

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


        /* =========================================================
           MAIN CONTAINER
           ========================================================= */

        .rv-page {
            min-height: 100vh;

            display: flex;
            flex-direction: column;

            position: relative;
        }

        .rv-main {
            width: 100%;
            max-width: 1680px;

            margin: 0 auto;

            padding:
                48px 40px
                45px;

            display: flex;
            flex-direction: column;
            align-items: center;

            transform-origin: top center;
        }


        /* =========================================================
           BRAND
           ========================================================= */

        .rv-brand {
            display: flex;
            flex-direction: column;
            align-items: center;

            text-align: center;

            margin-bottom: 20px;

            animation: fadeDown 0.8s ease both;
        }

        .rv-logo {
            font-family: "Arial Black", Arial, sans-serif;

            font-size: clamp(42px, 6vw, 82px);

            line-height: 0.95;

            letter-spacing: 0.04em;

            color: #ffffff;

            text-shadow:
                0 0 5px rgba(255, 255, 255, 0.8),
                0 0 18px rgba(0, 123, 255, 0.65),
                0 0 45px rgba(0, 92, 255, 0.35);
        }

        .rv-brand-line {
            width: min(390px, 70vw);

            display: flex;
            align-items: center;
            gap: 18px;

            margin-top: 14px;
        }

        .rv-brand-line span {
            height: 2px;
            flex: 1;

            background:
                linear-gradient(
                    90deg,
                    transparent,
                    rgba(53, 158, 255, 0.9)
                );

            box-shadow:
                0 0 8px rgba(0, 119, 255, 0.7);
        }

        .rv-brand-line span:last-child {
            background:
                linear-gradient(
                    90deg,
                    rgba(53, 158, 255, 0.9),
                    transparent
                );
        }

        .rv-brand-subtitle {
            color: #3aa4ff;

            font-size: 14px;

            letter-spacing: 0.45em;

            white-space: nowrap;

            text-shadow:
                0 0 12px rgba(0, 130, 255, 0.55);
        }


        /* =========================================================
           HERO
           ========================================================= */

        .rv-hero {
            text-align: center;

            max-width: 1050px;

            margin-top: 14px;
            margin-bottom: 30px;

            animation: fadeUp 0.9s ease 0.1s both;
        }

        .rv-hero h1 {
            font-family: "Arial Black", Arial, sans-serif;

            font-size: clamp(28px, 3.6vw, 54px);

            line-height: 1.04;

            letter-spacing: 0.015em;

            text-transform: uppercase;

            color: #ffffff;

            text-shadow:
                0 0 10px rgba(255, 255, 255, 0.18),
                0 0 28px rgba(0, 102, 255, 0.24);
        }

        .rv-hero p {
            margin-top: 18px;

            font-size: clamp(12px, 1.3vw, 18px);

            letter-spacing: 0.22em;

            color: rgba(218, 237, 255, 0.95);

            text-transform: uppercase;
        }


        /* =========================================================
           SHOWCASE
           ========================================================= */

        .rv-showcase {
            width: 100%;

            display: grid;

            grid-template-columns:
                minmax(230px, 340px)
                minmax(520px, 880px)
                minmax(230px, 340px);

            justify-content: center;
            align-items: center;

            gap: 32px;

            position: relative;

            margin: 8px auto 30px;

            animation: fadeUp 1s ease 0.2s both;
        }

        /*
         * Large blue light behind the center
         */
        .rv-showcase::before {
            content: "";

            position: absolute;

            width: 980px;
            height: 540px;

            left: 50%;
            top: 50%;

            transform: translate(-50%, -50%);

            background:
                radial-gradient(
                    ellipse,
                    rgba(0, 105, 255, 0.30) 0%,
                    rgba(0, 80, 210, 0.15) 35%,
                    transparent 72%
                );

            filter: blur(38px);

            pointer-events: none;

            z-index: 0;
        }


        /* =========================================================
           THEME CARDS
           ========================================================= */

        .rv-theme-card {
            position: relative;

            width: 100%;

            border-radius: 24px;

            overflow: hidden;

            background:
                linear-gradient(
                    145deg,
                    rgba(9, 43, 92, 0.92),
                    rgba(1, 16, 40, 0.94)
                );

            border: 2px solid rgba(49, 145, 255, 0.72);

            box-shadow:
                0 0 15px rgba(0, 102, 255, 0.28),
                0 15px 40px rgba(0, 0, 0, 0.45),
                inset 0 0 25px rgba(0, 105, 255, 0.08);

            backdrop-filter: blur(15px);

            transition:
                transform 0.4s ease,
                box-shadow 0.4s ease;

            z-index: 2;
        }

        .rv-theme-card:hover {
            transform: translateY(-8px) scale(1.02);

            box-shadow:
                0 0 25px rgba(0, 126, 255, 0.55),
                0 20px 55px rgba(0, 0, 0, 0.55),
                inset 0 0 30px rgba(0, 110, 255, 0.12);
        }

        .rv-left-theme {
            animation:
                leftFloat 5s ease-in-out infinite;
        }

        .rv-right-theme {
            animation:
                rightFloat 5.5s ease-in-out infinite;
        }

        @keyframes leftFloat {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-9px);
            }
        }

        @keyframes rightFloat {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-11px);
            }
        }

        .rv-theme-image {
            width: 100%;

            aspect-ratio: 1 / 0.92;

            object-fit: cover;

            display: block;

            border-bottom: 1px solid rgba(68, 158, 255, 0.35);
        }

        .rv-theme-info {
            min-height: 65px;

            padding: 15px 17px;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 10px;

            text-align: center;
        }

        .rv-theme-icon {
            width: 28px;
            height: 28px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background:
                rgba(24, 133, 255, 0.14);

            border: 1px solid rgba(74, 163, 255, 0.5);

            color: #79c5ff;

            flex-shrink: 0;

            font-size: 13px;
        }

        .rv-theme-name {
            font-size: 13px;

            letter-spacing: 0.08em;

            text-transform: uppercase;

            color: #ffffff;

            line-height: 1.2;
        }


        /* =========================================================
           CENTER BEFORE / AFTER
           ========================================================= */

        .rv-center-showcase {
            position: relative;

            width: 100%;

            border-radius: 25px;

            overflow: hidden;

            background: #020c20;

            border: 2px solid #2b9aff;

            box-shadow:
                0 0 18px rgba(0, 119, 255, 0.65),
                0 0 50px rgba(0, 100, 255, 0.35),
                0 20px 60px rgba(0, 0, 0, 0.55);

            z-index: 2;
        }

        .rv-before-after {
            width: 100%;

            aspect-ratio: 16 / 7;

            display: grid;

            grid-template-columns: 1fr 1fr;

            position: relative;
        }

        .rv-before,
        .rv-after {
            position: relative;

            overflow: hidden;
        }

        .rv-before img,
        .rv-after img {
            width: 100%;
            height: 100%;

            object-fit: cover;

            display: block;
        }

        /*
         * Slight dark overlay on BEFORE
         */
        .rv-before::after {
            content: "";

            position: absolute;
            inset: 0;

            background:
                linear-gradient(
                    180deg,
                    rgba(0, 0, 0, 0.05),
                    rgba(0, 0, 0, 0.28)
                );

            pointer-events: none;
        }

        /*
         * Blue overlay on AFTER
         */
        .rv-after::after {
            content: "";

            position: absolute;
            inset: 0;

            background:
                linear-gradient(
                    180deg,
                    rgba(0, 40, 120, 0.02),
                    rgba(0, 70, 180, 0.12)
                );

            pointer-events: none;
        }

        /*
         * Divider
         */
        .rv-divider {
            position: absolute;

            top: 0;
            bottom: 0;

            left: 50%;

            width: 3px;

            transform: translateX(-50%);

            background: #ffffff;

            box-shadow:
                0 0 12px rgba(255, 255, 255, 0.75),
                0 0 30px rgba(0, 120, 255, 0.8);

            z-index: 5;
        }

        /*
         * Center icon
         */
        .rv-divider-icon {
            position: absolute;

            top: 50%;
            left: 50%;

            width: 58px;
            height: 58px;

            transform: translate(-50%, -50%);

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: rgba(237, 247, 255, 0.96);

            color: #064ca6;

            font-size: 25px;

            box-shadow:
                0 0 18px rgba(255, 255, 255, 0.7),
                0 0 35px rgba(0, 110, 255, 0.55);

            z-index: 10;
        }

        /*
         * BEFORE / AFTER labels
         */
        .rv-image-label {
            position: absolute;

            bottom: 15px;

            padding: 9px 16px;

            border-radius: 9px;

            font-size: 12px;

            letter-spacing: 0.1em;

            color: #ffffff;

            background:
                rgba(1, 10, 25, 0.88);

            border: 1px solid rgba(87, 169, 255, 0.35);

            z-index: 8;
        }

        .rv-before .rv-image-label {
            left: 15px;
        }

        .rv-after .rv-image-label {
            right: 15px;

            background:
                linear-gradient(
                    135deg,
                    #0d73ff,
                    #1355d4
                );

            border-color: rgba(135, 205, 255, 0.6);

            box-shadow:
                0 0 18px rgba(0, 115, 255, 0.5);
        }


        /* =========================================================
           START BUTTON
           ========================================================= */

        .rv-cta-area {
            display: flex;
            flex-direction: column;
            align-items: center;

            margin-top: 80px;

            animation:
                fadeUp 1s ease 0.45s both;
        }

        .rv-start-button {
            min-width: 620px;

            min-height: 124px;

            padding: 30px 64px;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 28px;

            position: relative;

            isolation: isolate;

            border-radius: 999px;

            border: 2px solid #ffffff;

            background:
                linear-gradient(
                    180deg,
                    #ffffff 0%,
                    #eaf4ff 100%
                );

            color: #06255e;

            font-size: 30px;

            letter-spacing: 0.08em;

            text-transform: uppercase;

            cursor: pointer;

            box-shadow:
                0 0 14px rgba(0, 120, 255, 0.45),
                inset 0 -4px 10px rgba(0, 110, 255, 0.12);

            transition:
                transform 0.3s ease,
                box-shadow 0.3s ease,
                background 0.3s ease;
        }

        /*
         * Blinking blue glow around the white button.
         * The glow sits on its own layers and only their
         * opacity is animated, so the blink stays smooth.
         */

        .rv-start-button::before,
        .rv-start-button::after {
            content: "";

            position: absolute;

            inset: -2px;

            z-index: -1;

            border-radius: inherit;

            pointer-events: none;

            will-change: opacity;
        }

        .rv-start-button::before {
            box-shadow:
                0 0 22px 4px rgba(0, 140, 255, 0.95),
                0 0 60px 14px rgba(0, 100, 255, 0.6),
                0 0 110px 30px rgba(0, 80, 255, 0.3);

            animation: rvStartGlowBlink 1.4s ease-in-out infinite;
        }

        /* Blue ring that flashes on the button edge */

        .rv-start-button::after {
            inset: -6px;

            border: 4px solid #1e90ff;

            animation: rvStartRingBlink 1.4s ease-in-out infinite;
        }

        @keyframes rvStartGlowBlink {
            0%,
            100% {
                opacity: 0.25;
            }

            50% {
                opacity: 1;
            }
        }

        @keyframes rvStartRingBlink {
            0%,
            100% {
                opacity: 0;
            }

            50% {
                opacity: 1;
            }
        }

        .rv-start-button:hover {
            transform: translateY(-4px);

            background:
                linear-gradient(
                    180deg,
                    #ffffff 0%,
                    #d6ebff 100%
                );

            box-shadow:
                0 0 22px rgba(0, 140, 255, 0.7),
                inset 0 -4px 12px rgba(0, 110, 255, 0.18);
        }

        .rv-start-button:active {
            transform: translateY(-1px) scale(0.98);
        }

        .rv-camera-icon {
            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 44px;

            line-height: 1;

            position: relative;
            top: -4px;
        }

        .rv-arrow {
            font-size: 44px;

            line-height: 1;

            margin-left: 3px;

            color: #0a6cff;
        }

        .rv-cta-note {
            margin-top: 14px;

            font-size: 11px;

            color: #5bb8ff;

            letter-spacing: 0.25em;

            text-transform: uppercase;
        }




        /* =========================================================
           RUPA CHARACTER VIDEO
           ========================================================= */

        .rupa-welcome {
            position: fixed;
            left: 70px;
            bottom: 40px;
            width: 290px;
            z-index: 100;
            pointer-events: none;
            line-height: 0;

            transform-origin: 50% 100%;

            /*
             * Walks in from the left once, then keeps
             * floating, swaying and "breathing" in place.
             *
             * Only transform/opacity are animated and each
             * layer is promoted with will-change, so the GPU
             * moves it without repainting every frame.
             */
            will-change: translate, rotate, opacity;

            animation:
                rupaEnter 1.4s cubic-bezier(0.22, 1, 0.36, 1) 0.4s both,
                rupaSway 6s cubic-bezier(0.45, 0, 0.55, 1) 1.8s infinite;
        }

        .rupa-welcome video,
        .rupa-welcome img {
            position: relative;

            display: block;
            width: 100%;
            height: auto;
            object-fit: contain;

            transform-origin: 50% 100%;

            will-change: translate, scale;

            backface-visibility: hidden;

            animation: rupaFloat 3.6s cubic-bezier(0.45, 0, 0.55, 1) 1.8s infinite;
        }

        /*
         * Static blue glow behind Rupa. Replaces a
         * drop-shadow filter, which had to be re-blurred
         * on every animation frame and caused the lag.
         */

        .rupa-welcome::before {
            content: "";

            position: absolute;

            left: 5%;
            right: 5%;
            top: 10%;
            bottom: 5%;

            border-radius: 50%;

            background:
                radial-gradient(
                    ellipse at center,
                    rgba(0, 120, 255, 0.35),
                    transparent 65%
                );
        }

        /* Soft glow on the floor that shrinks as Rupa rises */

        .rupa-welcome::after {
            content: "";

            position: absolute;

            left: 20%;
            right: 20%;
            bottom: 4px;

            height: 18px;

            border-radius: 50%;

            background:
                radial-gradient(
                    ellipse at center,
                    rgba(0, 140, 255, 0.55),
                    transparent 70%
                );

            will-change: scale, opacity;

            animation: rupaShadow 3.6s cubic-bezier(0.45, 0, 0.55, 1) 1.8s infinite;
        }

        /*
         * Speech bubble: Rupa "talks" from above-right of its
         * head, with the tail pointing down to it.
         *
         * Where it sits and how wide it can grow depends on
         * how close the page content is, which changes with
         * the screen size. fitRupaSpeech() in the script below
         * measures the free space and sets these variables;
         * the values here are only the fallback.
         */

        .rupa-speech {
            --rupa-speech-left: 42%;
            --rupa-speech-bottom: 101%;
            --rupa-speech-max: 260px;
            --rupa-tail-left: 22px;

            position: absolute;

            z-index: 2;

            bottom: var(--rupa-speech-bottom);
            left: var(--rupa-speech-left);

            width: max-content;
            max-width: var(--rupa-speech-max);
            min-height: 52px;

            padding: 12px 18px;

            border-radius: 22px;

            border: 1px solid rgba(90, 170, 255, 0.65);

            background:
                linear-gradient(
                    135deg,
                    rgba(10, 45, 115, 0.95),
                    rgba(4, 20, 58, 0.95)
                );

            box-shadow:
                0 0 22px rgba(0, 120, 255, 0.45),
                inset 0 0 12px rgba(80, 160, 255, 0.15);

            color: #ffffff;

            font-size: 24px;
            line-height: 1.3;
            letter-spacing: 0.03em;

            transform-origin: var(--rupa-tail-left) 100%;

            opacity: 0;
            scale: 0.6;
            translate: 0 10px;

            transition:
                opacity 0.7s ease,
                scale 0.4s cubic-bezier(0.34, 1.56, 0.64, 1),
                translate 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .rupa-speech.visible {
            opacity: 1;
            scale: 1;
            translate: 0 0;
        }

        /* Tail pointing down at Rupa's head */

        .rupa-speech::after {
            content: "";

            position: absolute;

            left: var(--rupa-tail-left);
            bottom: -9px;

            width: 16px;
            height: 16px;

            margin-left: -8px;

            background: rgba(6, 28, 75, 0.95);

            border-right: 1px solid rgba(90, 170, 255, 0.65);
            border-bottom: 1px solid rgba(90, 170, 255, 0.65);

            rotate: 45deg;
        }

        .rupa-speech-highlight {
            color: #5fb4ff;

            text-shadow: 0 0 10px rgba(40, 150, 255, 0.9);
        }

        .rupa-speech-caret {
            display: inline-block;

            width: 2px;
            height: 1em;

            margin-left: 3px;

            vertical-align: -2px;

            background: #8fd0ff;

            animation: rupaCaretBlink 0.8s steps(1) infinite;
        }

        @keyframes rupaCaretBlink {
            50% {
                opacity: 0;
            }
        }

        @media (max-width: 1449px) {
            .rupa-speech {
                min-height: 40px;

                padding: 9px 13px;

                border-radius: 18px;

                font-size: 18px;
            }
        }

        @media (max-width: 1200px) {
            .rupa-speech {
                padding: 9px 11px;

                font-size: 15px;
            }
        }

        @keyframes rupaEnter {
            from {
                opacity: 0;
                translate: -110% 0;
                rotate: -8deg;
            }

            40% {
                opacity: 1;
            }

            to {
                opacity: 1;
                translate: 0 0;
                rotate: 0deg;
            }
        }

        @keyframes rupaSway {
            0%,
            100% {
                rotate: 0deg;
            }

            25% {
                rotate: 1.5deg;
            }

            75% {
                rotate: -1.5deg;
            }
        }

        @keyframes rupaFloat {
            0%,
            100% {
                translate: 0 0;
                scale: 1 1;
            }

            50% {
                translate: 0 -12px;
                scale: 0.99 1.01;
            }
        }

        @keyframes rupaShadow {
            0%,
            100% {
                opacity: 1;
                scale: 1;
            }

            50% {
                opacity: 0.5;
                scale: 0.75;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .rupa-welcome,
            .rupa-welcome video,
            .rupa-welcome img,
            .rupa-welcome::after {
                animation: none;
            }
        }

        /* Smaller laptops: stay clear of the START button */

        @media (max-width: 1449px) {
            .rupa-welcome {
                left: 20px;
                bottom: 20px;
                width: 200px;
            }
        }

        @media (max-width: 1000px) {
            .rupa-welcome {
                left: 10px;
                width: 150px;
            }
        }

        @media (max-width: 800px) {
            .rupa-welcome {
                left: 24px;
                bottom: 20px;
                width: 185px;
            }
        }

        @media (max-width: 400px) {
            .rupa-welcome {
                left: 16px;
                bottom: 12px;
                width: 150px;
            }
        }


        /* =========================================================
           PAGE TRANSITION
           ========================================================= */

        /*
         * "Warp jump" out of the welcome page:
         * the page zooms towards the viewer while light
         * streaks and rings burst from the START button,
         * a dark iris spreads from the same point and the
         * RUPAVUE logo locks into place. The theme page
         * picks up from that exact frame (see scene page).
         *
         * --rv-x / --rv-y hold the button centre and are
         * set from JavaScript on click.
         */

        .rv-page-transition {
            --rv-x: 50%;
            --rv-y: 50%;

            position: fixed;

            inset: 0;

            z-index: 9999;

            pointer-events: none;

            overflow: hidden;

            visibility: hidden;
        }

        .rv-page-transition.active {
            visibility: visible;
            pointer-events: auto;
        }

        body.rv-leaving .rv-main,
        body.rv-leaving .rupa-welcome {
            animation: rvWarpZoom 0.9s cubic-bezier(0.6, 0, 0.9, 0.4) forwards;
        }

        /* Burst of light from the button */

        .rv-warp-flash {
            position: absolute;
            inset: 0;

            opacity: 0;

            background:
                radial-gradient(
                    circle at var(--rv-x) var(--rv-y),
                    rgba(255, 255, 255, 0.95) 0%,
                    rgba(80, 170, 255, 0.55) 12%,
                    transparent 40%
                );
        }

        .rv-page-transition.active .rv-warp-flash {
            animation: rvWarpFlash 0.55s ease-out forwards;
        }

        /* Hyperspace light streaks */

        .rv-warp-streaks {
            position: absolute;

            left: var(--rv-x);
            top: var(--rv-y);

            width: 0;
            height: 0;
        }

        .rv-warp-streaks span {
            position: absolute;

            left: 0;
            top: -1px;

            width: 38vmax;
            height: 2px;

            border-radius: 2px;

            transform-origin: 0 50%;

            background:
                linear-gradient(
                    90deg,
                    transparent,
                    rgba(90, 175, 255, 0.8) 55%,
                    #ffffff
                );

            box-shadow: 0 0 8px rgba(80, 170, 255, 0.9);

            opacity: 0;

            animation: rvWarpStreak 0.8s cubic-bezier(0.5, 0, 0.9, 0.5) var(--delay) forwards;
        }

        /* Expanding shock rings */

        .rv-warp-ring {
            position: absolute;

            left: var(--rv-x);
            top: var(--rv-y);

            width: 60px;
            height: 60px;

            margin: -30px 0 0 -30px;

            border-radius: 50%;

            border: 2px solid rgba(160, 215, 255, 0.9);

            box-shadow:
                0 0 20px rgba(40, 140, 255, 0.9),
                inset 0 0 20px rgba(40, 140, 255, 0.6);

            opacity: 0;
        }

        .rv-page-transition.active .rv-warp-ring {
            animation: rvWarpRing 0.8s cubic-bezier(0.2, 0.7, 0.3, 1) forwards;
        }

        .rv-page-transition.active .rv-warp-ring-two {
            animation-delay: 0.15s;
        }

        /* Dark iris spreading from the button */

        .rv-warp-iris {
            position: absolute;
            inset: 0;

            background:
                radial-gradient(
                    circle at 50% 50%,
                    rgba(0, 105, 255, 0.35),
                    #010611 72%
                );

            clip-path: circle(0% at var(--rv-x) var(--rv-y));
        }

        .rv-page-transition.active .rv-warp-iris {
            animation: rvWarpIris 0.65s cubic-bezier(0.7, 0, 0.3, 1) 0.35s forwards;
        }

        /* Logo that the theme page continues from */

        .rv-warp-logo {
            position: absolute;

            top: 50%;
            left: 50%;

            transform: translate(-50%, -50%);

            font-family:
                "Arial Black",
                Arial,
                sans-serif;

            font-size: clamp(35px, 7vw, 90px);

            letter-spacing: 0.05em;

            white-space: nowrap;

            color: #ffffff;

            text-shadow:
                0 0 10px #ffffff,
                0 0 30px #1688ff,
                0 0 60px #0066ff;

            opacity: 0;
        }

        .rv-page-transition.active .rv-warp-logo {
            animation: rvWarpLogo 0.5s cubic-bezier(0.2, 0.8, 0.2, 1) 0.6s forwards;
        }

        @keyframes rvWarpZoom {
            to {
                scale: 1.6;
                opacity: 0;
                filter: blur(10px);
            }
        }

        @keyframes rvWarpFlash {
            30% {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }

        @keyframes rvWarpStreak {
            from {
                opacity: 0;
                transform: rotate(var(--angle)) translateX(20px) scaleX(0.05);
            }

            35% {
                opacity: 1;
            }

            to {
                opacity: 0;
                transform: rotate(var(--angle)) translateX(110vmax) scaleX(1);
            }
        }

        @keyframes rvWarpRing {
            from {
                opacity: 1;
                transform: scale(0.2);
            }

            to {
                opacity: 0;
                transform: scale(40);
            }
        }

        @keyframes rvWarpIris {
            to {
                clip-path: circle(150% at var(--rv-x) var(--rv-y));
            }
        }

        @keyframes rvWarpLogo {
            from {
                opacity: 0;
                letter-spacing: 0.6em;
                filter: blur(12px);
            }

            to {
                opacity: 1;
                letter-spacing: 0.05em;
                filter: blur(0);
            }
        }

        @media (prefers-reduced-motion: reduce) {

            body.rv-leaving .rv-main,
            body.rv-leaving .rupa-welcome {
                animation: none;
            }

            .rv-warp-streaks,
            .rv-warp-ring {
                display: none;
            }
        }


        /* =========================================================
           ANIMATIONS
           ========================================================= */

        @keyframes fadeDown {

            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeUp {

            from {
                opacity: 0;
                transform: translateY(25px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }


        /* =========================================================
           DESKTOP — FIT TO ONE SCREEN, NO SCROLL

           The whole page is scaled down (see the fitPageToScreen
           script below) so every section — including the footer —
           is visible without scrolling on desktop/laptop windows.
           Mobile keeps its normal scrolling layout.
           ========================================================= */

        @media (min-width: 801px) {

            .rv-page {
                height: 100vh;
                height: 100dvh;

                overflow: hidden;
            }
        }


        /* =========================================================
           TABLET
           ========================================================= */

        @media (max-width: 1100px) {

            .rv-main {
                padding-left: 25px;
                padding-right: 25px;
            }

            .rv-showcase {
                grid-template-columns:
                    minmax(170px, 260px)
                    minmax(440px, 660px)
                    minmax(170px, 260px);

                gap: 18px;
            }
        }


        /* =========================================================
           MOBILE
           ========================================================= */

        @media (max-width: 800px) {

            body {
                overflow-x: hidden;
            }

            .rv-main {
                padding:
                    32px 18px
                    35px;
            }

            .rv-logo {
                font-size: 48px;
            }

            .rv-brand-subtitle {
                font-size: 10px;

                letter-spacing: 0.3em;
            }

            .rv-hero {
                margin-top: 10px;

                margin-bottom: 24px;
            }

            .rv-hero h1 {
                font-size: 25px;
            }

            .rv-hero p {
                font-size: 10px;

                line-height: 1.7;

                letter-spacing: 0.12em;
            }

            .rv-showcase {
                grid-template-columns: 1fr;

                max-width: 600px;

                gap: 18px;
            }

            .rv-showcase::before {
                width: 500px;
                height: 700px;
            }

            .rv-theme-card {
                max-width: 280px;

                margin: auto;
            }

            /*
             * On mobile, center showcase first.
             */
            .rv-center-showcase {
                order: 1;
            }

            .rv-left-theme {
                order: 2;
            }

            .rv-right-theme {
                order: 3;
            }

            .rv-before-after {
                aspect-ratio: 1 / 0.75;
            }

            .rv-divider-icon {
                width: 46px;
                height: 46px;

                font-size: 19px;
            }

            .rv-image-label {
                padding: 7px 11px;

                font-size: 9px;
            }

            .rv-start-button {
                min-width: 380px;

                min-height: 92px;

                padding: 22px 36px;

                font-size: 21px;
            }

            .rv-liquid-one {
                left: -280px;
            }

            .rv-liquid-two {
                right: -230px;
            }
        }


        /* =========================================================
           SMALL MOBILE
           ========================================================= */

        @media (max-width: 400px) {

            .rv-main {
                padding-left: 14px;
                padding-right: 14px;
            }

            .rv-logo {
                font-size: 40px;
            }

            .rv-hero h1 {
                font-size: 22px;
            }

            .rv-start-button {
                min-width: 300px;

                font-size: 17px;
            }

            .rv-cta-note {
                font-size: 8px;
            }
        }


        /* =========================================================
           REDUCED MOTION
           ========================================================= */

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

    <!-- =========================================================
         BACKGROUND
         ========================================================= -->

    <div class="rv-background">

        <div class="rv-glow rv-glow-one"></div>
        <div class="rv-glow rv-glow-two"></div>
        <div class="rv-glow rv-glow-three"></div>
        <div class="rv-glow rv-glow-four"></div>

        <div class="rv-liquid rv-liquid-one"></div>
        <div class="rv-liquid rv-liquid-two"></div>
        <div class="rv-liquid rv-liquid-three"></div>

        <div class="rv-stars">

            <span class="rv-star"></span>
            <span class="rv-star"></span>
            <span class="rv-star"></span>
            <span class="rv-star"></span>
            <span class="rv-star"></span>
            <span class="rv-star"></span>
            <span class="rv-star"></span>
            <span class="rv-star"></span>
            <span class="rv-star"></span>
            <span class="rv-star"></span>
            <span class="rv-star"></span>
            <span class="rv-star"></span>

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


    <!-- =========================================================
         RUPA WELCOME VIDEO
         ========================================================= -->

    <div class="rupa-welcome" aria-hidden="true">
        <div class="rupa-speech" id="rupaSpeech">
            <span id="rupaSpeechText"></span><span class="rupa-speech-caret"></span>
        </div>

        <img
            src="{{ asset('images/rupa-character.png') }}"
            alt="Rupa Character"
        >
    </div>


    <!-- =========================================================
         PAGE
         ========================================================= -->

    <div class="rv-page">

        <main class="rv-main">


            <!-- =================================================
                 BRAND
                 ================================================= -->

            <section class="rv-brand">

                <div class="rv-logo">
                    RUPAVUE
                </div>

                <div class="rv-brand-line">

                    <span></span>

                    <div class="rv-brand-subtitle">
                        AI PHOTO EXPERIENCE
                    </div>

                    <span></span>

                </div>

            </section>


            <!-- =================================================
                 HERO
                 ================================================= -->

            <section class="rv-hero">

                <h1>
                    TURN YOUR SELFIES INTO
                    <br>
                    UNFORGETTABLE AI ART
                </h1>

            </section>


            <!-- =================================================
                 SHOWCASE
                 ================================================= -->

            <section class="rv-showcase">


                <!-- =============================================
                     LEFT THEME
                     ============================================= -->

                <div class="rv-theme-card rv-left-theme">

                    <img
                        src="{{ asset('images/themes/left-theme.png') }}"
                        alt="High Council"
                        class="rv-theme-image"
                    >

                    <div class="rv-theme-info">


                        <div class="rv-theme-name">
                            High Council
                        </div>

                    </div>

                </div>


                <!-- =============================================
                     CENTER BEFORE / AFTER
                     ============================================= -->

                <div class="rv-center-showcase">

                    <div class="rv-before-after">


                        <!-- BEFORE -->

                        <div class="rv-before">

                            <img
                                src="{{ asset('images/showcase/before.png') }}"
                                alt="Original Photo"
                            >

                            <div class="rv-image-label">
                                BEFORE
                            </div>

                        </div>


                        <!-- AFTER -->

                        <div class="rv-after">

                            <img
                                src="{{ asset('images/showcase/after.png') }}"
                                alt="AI Generated Photo"
                            >

                            <div class="rv-image-label">
                                AFTER
                            </div>

                        </div>


                        <!-- DIVIDER -->

                        <div class="rv-divider">

                            <div class="rv-divider-icon">
                                ‹›
                            </div>

                        </div>

                    </div>

                </div>


                <!-- =============================================
                     RIGHT THEME
                     ============================================= -->

                <div class="rv-theme-card rv-right-theme">

                    <img
                        src="{{ asset('images/themes/right-theme.png') }}"
                        alt="Street Racer"
                        class="rv-theme-image"
                    >

                    <div class="rv-theme-info">

                        <div class="rv-theme-name">
                            Street Racer
                        </div>

                    </div>

                </div>

            </section>


            <!-- =================================================
                 CTA
                 ================================================= -->

            <section class="rv-cta-area">

                <a
                    href="{{ route('photobooth.scene') }}"
                    id="startSessionButton"
                    class="rv-start-button"
                >

                    <span class="rv-camera-icon">
                        📷
                    </span>

                    <span>
                        START SESSION
                    </span>

                    <span class="rv-arrow">
                        →
                    </span>

                </a>

            </section>


        </main>

    </div>


    <!-- =========================================================
         PAGE TRANSITION
         ========================================================= -->

    <div
        id="rvPageTransition"
        class="rv-page-transition"
        aria-hidden="true"
    >
        <div class="rv-warp-flash"></div>
        <div class="rv-warp-streaks" id="rvWarpStreaks"></div>
        <div class="rv-warp-ring"></div>
        <div class="rv-warp-ring rv-warp-ring-two"></div>
        <div class="rv-warp-iris"></div>
        <div class="rv-warp-logo">RUPAVUE</div>
    </div>


    <!-- =========================================================
         JAVASCRIPT
         ========================================================= -->

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const startButton =
                document.getElementById('startSessionButton');

            const transition =
                document.getElementById('rvPageTransition');

            const main =
                document.querySelector('.rv-main');


            /*
             * DESKTOP — FIT TO ONE SCREEN
             *
             * Scales the whole page content down (never up) so it
             * always fits within the viewport height, with no
             * vertical scrolling, on desktop/laptop windows. Mobile
             * (<=800px wide) keeps its normal scrolling layout.
             */
            function fitPageToScreen() {

                if (!main) {
                    return;
                }

                if (window.innerWidth <= 800) {
                    main.style.transform = '';
                    return;
                }

                main.style.transform = 'none';

                const availableHeight =
                    window.innerHeight;

                const naturalHeight =
                    main.scrollHeight;

                const scale =
                    Math.min(1, availableHeight / naturalHeight);

                main.style.transform =
                    'scale(' + scale + ')';

            }

            fitPageToScreen();

            window.addEventListener('resize', fitPageToScreen);
            window.addEventListener('load', fitPageToScreen);


            /*
             * Remembers exactly where START SESSION sits on this
             * screen (distance from the bottom and page scale) so
             * the CHOOSE FRAME and CAPTURE PHOTO buttons can sit
             * in the same spot at the same size. Hover/press
             * transforms are ignored while measuring.
             */
            function rememberStartButtonSpot() {

                if (!startButton || window.innerWidth <= 800) {
                    return;
                }

                const previousTransition =
                    startButton.style.transition;

                const previousTransform =
                    startButton.style.transform;

                startButton.style.transition = 'none';
                startButton.style.transform = 'none';

                const bounds =
                    startButton.getBoundingClientRect();

                startButton.style.transform = previousTransform;
                startButton.style.transition = previousTransition;

                try {
                    sessionStorage.setItem('rupavueStartButtonSpot', JSON.stringify({
                        viewportWidth: window.innerWidth,
                        viewportHeight: window.innerHeight,
                        bottom: window.innerHeight - bounds.bottom,
                        scale: bounds.height / startButton.offsetHeight,
                    }));
                } catch (error) {
                    // Storage unavailable; the next pages use their default spot.
                }
            }


            /*
             * RUPA SPEECH BUBBLE
             *
             * After Rupa walks in, it "types" a few lines in
             * its speech bubble, ending with a nudge to press
             * START SESSION, then repeats.
             */
            const rupaMessages = [
                [['Hi, I\'m Rupa!']],
                [['Ready to turn your photos into art?']],
                [['Bring your friends and family, and let\'s create magic!']],
                [['I\'m here to guide you through the process.']],
                [['What are you waiting for?']],
                [['Tap '], ['START SESSION', 'rupa-speech-highlight'], [' to begin!']],
            ];

            const rupaSpeech =
                document.getElementById('rupaSpeech');

            const rupaSpeechText =
                document.getElementById('rupaSpeechText');

            const prefersReducedMotion =
                window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            function rupaWait(milliseconds) {
                return new Promise(function (resolve) {
                    setTimeout(resolve, milliseconds);
                });
            }

            const rupaLongestMessage =
                rupaMessages
                    .map(function (segments) {
                        return segments.map(function (segment) {
                            return segment[0];
                        }).join('');
                    })
                    .reduce(function (longest, message) {
                        return message.length > longest.length ? message : longest;
                    }, '');

            /*
             * Places the bubble next to Rupa's head so it never
             * covers the page. Tries spots from "above-right of
             * the head" (preferred) towards "above-left", and
             * at each spot lets the bubble grow as wide as the
             * free space allows (up to 420px). Measured with the
             * longest message so the bubble never outgrows it.
             */
            function fitRupaSpeech() {

                const character =
                    document.querySelector('.rupa-welcome');

                if (!character || !rupaSpeech) {
                    return;
                }

                const safetyMargin = 18;

                /*
                 * The side theme cards are only preview photos, so
                 * the bubble may overlap them; everything else
                 * (heading, showcase, button) stays clear.
                 */
                const obstacles =
                    Array.from(document.querySelectorAll(
                        '.rv-center-showcase, .rv-hero h1, .rv-hero p, #startSessionButton'
                    ))
                        .map(function (element) {
                            return element.getBoundingClientRect();
                        })
                        .filter(function (bounds) {
                            return bounds.width > 0 && bounds.height > 0;
                        });

                /* In order of preference: furthest right first */
                const spots = [];

                for (const left of [0.55, 0.48, 0.42, 0.36, 0.3, 0.2, 0.1, -0.04]) {
                    for (const bottom of [1.01, 0.94, 1.06, 0.9]) {
                        spots.push({ left: left, bottom: bottom });
                    }
                }

                const savedText = rupaSpeechText.innerHTML;

                rupaSpeechText.textContent = rupaLongestMessage;

                rupaSpeech.style.width = 'min-content';

                const smallestWidth = rupaSpeech.offsetWidth;

                rupaSpeech.style.width = '';

                /*
                 * offsetLeft/Top ignore the float and sway
                 * transforms; the safety margin covers them.
                 */
                const characterLeft = character.offsetLeft;
                const characterTop = character.offsetTop;
                const characterWidth = character.offsetWidth;
                const characterHeight = character.offsetHeight;

                function applySpot(spot, maxWidth) {
                    rupaSpeech.style.setProperty('--rupa-speech-left', (spot.left * 100) + '%');
                    rupaSpeech.style.setProperty('--rupa-speech-bottom', (spot.bottom * 100) + '%');
                    rupaSpeech.style.setProperty('--rupa-speech-max', maxWidth + 'px');
                }

                function roomAtSpot(spot) {

                    const left =
                        characterLeft + characterWidth * spot.left;

                    const bottom =
                        characterTop + characterHeight * (1 - spot.bottom);

                    const top =
                        bottom - rupaSpeech.offsetHeight;

                    if (top < safetyMargin) {
                        return 0;
                    }

                    let room =
                        window.innerWidth - safetyMargin - left;

                    for (const bounds of obstacles) {

                        /*
                         * Rupa only floats upwards, so the bubble
                         * needs less room below it than above.
                         */
                        const sharesRow =
                            bounds.bottom + safetyMargin > top
                            && bounds.top - 8 < bottom;

                        if (!sharesRow || bounds.right + safetyMargin <= left) {
                            continue;
                        }

                        room = Math.min(room, bounds.left - safetyMargin - left);

                    }

                    return Math.floor(room);

                }

                /*
                 * Work out how wide the bubble can be at every
                 * spot, then use the furthest-right spot that
                 * gives a readable width (about 8 letters), or
                 * failing that the widest spot.
                 */
                const fittingSpots = [];

                for (const spot of spots) {

                    let maxWidth = 420;

                    for (let attempt = 0; attempt < 4; attempt++) {

                        applySpot(spot, maxWidth);

                        const room = roomAtSpot(spot);

                        if (rupaSpeech.offsetWidth <= room) {
                            fittingSpots.push({
                                spot: spot,
                                maxWidth: maxWidth,
                                width: rupaSpeech.offsetWidth,
                            });
                            break;
                        }

                        if (room < smallestWidth) {
                            break;
                        }

                        maxWidth = room;

                    }

                }

                const widest =
                    Math.max.apply(null, fittingSpots.map(function (fit) {
                        return fit.width;
                    }).concat([0]));

                const comfortableWidth =
                    parseFloat(window.getComputedStyle(rupaSpeech).fontSize) * 8;

                const chosen =
                    fittingSpots.find(function (fit) {
                        return fit.width >= Math.min(widest, comfortableWidth);
                    });

                if (chosen) {
                    applySpot(chosen.spot, chosen.maxWidth);
                } else {
                    applySpot(spots[spots.length - 1], smallestWidth);
                }

                /* Point the tail at the middle of Rupa's head */

                const bubbleLeft =
                    characterLeft + rupaSpeech.offsetLeft;

                const tailLeft =
                    Math.min(
                        Math.max(characterLeft + characterWidth / 2 - bubbleLeft, 22),
                        rupaSpeech.offsetWidth - 22
                    );

                rupaSpeech.style.setProperty('--rupa-tail-left', tailLeft + 'px');

                rupaSpeechText.innerHTML = savedText;

            }

            window.addEventListener('resize', fitRupaSpeech);

            async function typeRupaMessage(segments) {

                rupaSpeechText.innerHTML = '';

                for (const [text, className] of segments) {

                    const span =
                        document.createElement('span');

                    if (className) {
                        span.className = className;
                    }

                    rupaSpeechText.appendChild(span);

                    if (prefersReducedMotion) {
                        span.textContent = text;
                        continue;
                    }

                    for (const character of text) {
                        span.textContent += character;
                        await rupaWait(45);
                    }

                }

            }

            async function startRupaTalking() {

                await rupaWait(prefersReducedMotion ? 400 : 2000);

                for (let index = 0; ; index = (index + 1) % rupaMessages.length) {

                    const isStartPrompt =
                        index === rupaMessages.length - 1;

                    fitRupaSpeech();

                    rupaSpeechText.innerHTML = '';

                    rupaSpeech.classList.add('visible');

                    await rupaWait(300);

                    await typeRupaMessage(rupaMessages[index]);

                    await rupaWait(isStartPrompt ? 6000 : 3500);

                    rupaSpeech.classList.remove('visible');

                    await rupaWait(900);

                }

            }

            if (rupaSpeech && rupaSpeechText) {
                startRupaTalking();
            }


            /*
             * WARP TRANSITION
             *
             * Centres the burst on the START button and
             * spawns the light streaks at random angles.
             */
            function startWarpTransition(originElement) {

                const bounds =
                    originElement.getBoundingClientRect();

                transition.style.setProperty(
                    '--rv-x',
                    (bounds.left + bounds.width / 2) + 'px'
                );

                transition.style.setProperty(
                    '--rv-y',
                    (bounds.top + bounds.height / 2) + 'px'
                );

                const streaks =
                    document.getElementById('rvWarpStreaks');

                streaks.innerHTML = '';

                for (let i = 0; i < 48; i++) {

                    const streak =
                        document.createElement('span');

                    streak.style.setProperty(
                        '--angle',
                        (Math.random() * 360) + 'deg'
                    );

                    streak.style.setProperty(
                        '--delay',
                        (Math.random() * 0.35) + 's'
                    );

                    streaks.appendChild(streak);

                }

                document.body.classList.add('rv-leaving');

                transition.classList.add('active');

            }


            if (startButton && transition) {

                startButton.addEventListener('click', function (event) {

                    /*
                     * Allow modifier-clicks to behave normally.
                     */
                    if (
                        event.ctrlKey ||
                        event.metaKey ||
                        event.shiftKey ||
                        event.altKey
                    ) {
                        return;
                    }

                    event.preventDefault();

                    window.rupavueClickSound.play();

                    const destination =
                        this.href;

                    rememberStartButtonSpot();

                    startWarpTransition(this);

                    /*
                     * Tell the theme page to play the matching
                     * warp-in animation when it loads.
                     */
                    try {
                        sessionStorage.setItem('rupavueWarpIn', '1');
                    } catch (error) {
                        // Storage unavailable; the theme page just loads normally.
                    }

                    setTimeout(function () {

                        window.location.href =
                            destination;

                    }, 1150);

                });

            }

            /*
             * If the browser restores this page from bfcache after the
             * user navigates back (e.g. from the theme selection page),
             * the transition overlay can still have the "active" class
             * from the click that sent them away, leaving the RUPAVUE
             * text stuck on screen. Clear it whenever the page is shown.
             */
            window.addEventListener('pageshow', function (event) {

                if (transition) {
                    transition.classList.remove('active');

                    document
                        .getElementById('rvWarpStreaks')
                        .innerHTML = '';
                }

                document.body.classList.remove('rv-leaving');

            });

        });

    </script>

@include('partials.click-sound')

</body>

</html>