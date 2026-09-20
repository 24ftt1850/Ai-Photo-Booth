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
            max-width: 1500px;

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
                minmax(190px, 260px)
                minmax(450px, 680px)
                minmax(190px, 260px);

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

            width: 760px;
            height: 430px;

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

            gap: 10px;
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
           FEATURES
           ========================================================= */

        .rv-features {
            width: min(850px, 100%);

            display: flex;
            justify-content: center;
            align-items: center;

            margin: 0 auto 28px;

            animation:
                fadeUp 1s ease 0.35s both;
        }

        .rv-feature {
            flex: 1;

            display: flex;
            justify-content: center;
            align-items: center;

            gap: 12px;

            padding: 5px 25px;

            color: #f0f7ff;

            font-size: 13px;

            letter-spacing: 0.06em;

            text-transform: uppercase;

            text-align: center;
        }

        .rv-feature + .rv-feature {
            border-left: 2px solid rgba(68, 151, 255, 0.45);
        }

        .rv-feature-icon {
            width: 34px;
            height: 34px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            color: #66b9ff;

            background:
                rgba(0, 110, 255, 0.10);

            border: 1px solid rgba(70, 163, 255, 0.35);

            box-shadow:
                0 0 14px rgba(0, 111, 255, 0.22);

            font-size: 15px;
        }


        /* =========================================================
           START BUTTON
           ========================================================= */

        .rv-cta-area {
            display: flex;
            flex-direction: column;
            align-items: center;

            animation:
                fadeUp 1s ease 0.45s both;
        }

        .rv-start-button {
            min-width: 380px;

            min-height: 76px;

            padding: 18px 36px;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 17px;

            border-radius: 999px;

            border: 2px solid #2d9cff;

            background:
                linear-gradient(
                    135deg,
                    rgba(0, 78, 190, 0.38),
                    rgba(0, 30, 82, 0.75)
                );

            color: #ffffff;

            font-size: 18px;

            letter-spacing: 0.08em;

            text-transform: uppercase;

            cursor: pointer;

            box-shadow:
                0 0 16px rgba(0, 120, 255, 0.65),
                0 0 45px rgba(0, 100, 255, 0.25),
                inset 0 0 18px rgba(0, 110, 255, 0.12);

            transition:
                transform 0.3s ease,
                box-shadow 0.3s ease,
                background 0.3s ease;
        }

        .rv-start-button:hover {
            transform: translateY(-4px);

            background:
                linear-gradient(
                    135deg,
                    rgba(0, 104, 235, 0.55),
                    rgba(0, 42, 110, 0.82)
                );

            box-shadow:
                0 0 22px rgba(0, 145, 255, 0.85),
                0 0 65px rgba(0, 105, 255, 0.40),
                inset 0 0 25px rgba(0, 130, 255, 0.16);
        }

        .rv-start-button:active {
            transform: translateY(-1px) scale(0.98);
        }

        .rv-camera-icon {
            width: 32px;
            height: 32px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 8px;

            background: rgba(255, 255, 255, 0.08);

            border: 1px solid rgba(145, 211, 255, 0.35);

            font-size: 17px;
        }

        .rv-arrow {
            font-size: 28px;

            line-height: 1;

            margin-left: 3px;
        }

        .rv-cta-note {
            margin-top: 14px;

            font-size: 11px;

            color: #5bb8ff;

            letter-spacing: 0.25em;

            text-transform: uppercase;
        }


        /* =========================================================
           FOOTER
           ========================================================= */

        .rv-footer {
            margin-top: 32px;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 20px;

            color: #ffffff;

            font-size: 11px;

            letter-spacing: 0.32em;

            text-transform: uppercase;

            opacity: 0.9;
        }

        .rv-footer-line {
            width: 75px;

            height: 2px;

            background:
                linear-gradient(
                    90deg,
                    transparent,
                    #238fff
                );

            box-shadow:
                0 0 8px rgba(0, 125, 255, 0.7);
        }

        .rv-footer-line:last-child {
            background:
                linear-gradient(
                    90deg,
                    #238fff,
                    transparent
                );
        }


        /* =========================================================
           PAGE TRANSITION
           ========================================================= */

        .rv-page-transition {
            position: fixed;

            inset: 0;

            z-index: 9999;

            pointer-events: none;

            opacity: 0;

            background:
                radial-gradient(
                    circle at center,
                    rgba(0, 105, 255, 0.35),
                    #010611 72%
                );

            transition:
                opacity 0.5s ease;
        }

        .rv-page-transition.active {
            opacity: 1;
        }

        .rv-page-transition::after {
            content: "RUPAVUE";

            position: absolute;

            top: 50%;
            left: 50%;

            transform:
                translate(-50%, -50%)
                scale(0.9);

            font-family:
                "Arial Black",
                Arial,
                sans-serif;

            font-size: clamp(35px, 7vw, 90px);

            letter-spacing: 0.05em;

            color: #ffffff;

            text-shadow:
                0 0 10px #ffffff,
                0 0 30px #1688ff,
                0 0 60px #0066ff;

            opacity: 0;

            transition:
                opacity 0.4s ease,
                transform 0.5s ease;
        }

        .rv-page-transition.active::after {
            opacity: 1;

            transform:
                translate(-50%, -50%)
                scale(1);
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
                    minmax(150px, 210px)
                    minmax(400px, 570px)
                    minmax(150px, 210px);

                gap: 18px;
            }

            .rv-feature {
                padding: 5px 12px;

                font-size: 11px;
            }

            .rv-feature-icon {
                width: 30px;
                height: 30px;
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

                max-width: 500px;

                gap: 18px;
            }

            .rv-showcase::before {
                width: 500px;
                height: 700px;
            }

            .rv-theme-card {
                max-width: 220px;

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

            .rv-features {
                flex-direction: column;

                gap: 12px;

                margin-top: 5px;
            }

            .rv-feature {
                width: 100%;

                justify-content: center;

                padding: 8px;

                font-size: 10px;
            }

            .rv-feature + .rv-feature {
                border-left: 0;

                border-top: 1px solid rgba(68, 151, 255, 0.25);

                padding-top: 14px;
            }

            .rv-start-button {
                min-width: 300px;

                min-height: 65px;

                padding: 15px 25px;

                font-size: 14px;
            }

            .rv-footer {
                margin-top: 26px;

                font-size: 8px;

                letter-spacing: 0.2em;

                gap: 10px;
            }

            .rv-footer-line {
                width: 40px;
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
                min-width: 270px;

                font-size: 12px;
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

                <p>
                    YOUR PROFESSIONAL STUDIO IN THE PALM OF YOUR HAND.
                </p>

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
                        src="{{ asset('images/themes/retro.jpg') }}"
                        alt="Retro Theme"
                        class="rv-theme-image"
                    >

                    <div class="rv-theme-info">

                        <div class="rv-theme-icon">
                            ✦
                        </div>

                        <div class="rv-theme-name">
                            RETRO
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
                                src="{{ asset('images/showcase/before.jpg') }}"
                                alt="Original Photo"
                            >

                            <div class="rv-image-label">
                                BEFORE
                            </div>

                        </div>


                        <!-- AFTER -->

                        <div class="rv-after">

                            <img
                                src="{{ asset('images/showcase/after.jpg') }}"
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
                        src="{{ asset('images/themes/mafia.jpg') }}"
                        alt="Mafia Theme"
                        class="rv-theme-image"
                    >

                    <div class="rv-theme-info">

                        <div class="rv-theme-icon">
                            ◆
                        </div>

                        <div class="rv-theme-name">
                            MAFIA
                        </div>

                    </div>

                </div>

            </section>


            <!-- =================================================
                 FEATURES
                 ================================================= -->

            <section class="rv-features">


                <!-- Feature 1 -->

                <div class="rv-feature">

                    <div class="rv-feature-icon">
                        ⚡
                    </div>

                    <span>
                        INSTANT GENERATION
                    </span>

                </div>


                <!-- Feature 2 -->

                <div class="rv-feature">

                    <div class="rv-feature-icon">
                        ✦
                    </div>

                    <span>
                        UNIQUE THEMES
                    </span>

                </div>


                <!-- Feature 3 -->

                <div class="rv-feature">

                    <div class="rv-feature-icon">
                        ↓
                    </div>

                    <span>
                        HD DOWNLOADS
                    </span>

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

                <div class="rv-cta-note">
                    What are you waiting for?
                </div>

            </section>


            <!-- =================================================
                 FOOTER
                 ================================================= -->

            <footer class="rv-footer">

                <span class="rv-footer-line"></span>

                <span>
                    AI POWERED PHOTO BOOTH
                </span>

                <span class="rv-footer-line"></span>

            </footer>


        </main>

    </div>


    <!-- =========================================================
         PAGE TRANSITION
         ========================================================= -->

    <div
        id="rvPageTransition"
        class="rv-page-transition"
    ></div>


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

                    const destination =
                        this.href;

                    transition.classList.add('active');

                    setTimeout(function () {

                        window.location.href =
                            destination;

                    }, 500);

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
                }

            });

        });

    </script>

</body>

</html>