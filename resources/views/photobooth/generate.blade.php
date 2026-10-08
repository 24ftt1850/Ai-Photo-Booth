<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Applying AI Magic - RupaVue</title>

    <script>
        /*
         * Start in "intro" mode before the first paint, so the
         * page never flashes its full layout before the
         * generating box takes over the screen.
         */
        if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            document.documentElement.classList.add('gen-intro');
        }
    </script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
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
        }

        /* =====================================================
           MAIN PAGE — SAME BLUE/WHITE RUPAVUE STYLE
        ===================================================== */

        .generate-page {
            position: relative;
            width: 100%;
            height: 100vh;
            height: 100dvh;
            overflow: hidden;

            padding: 48px 2.5% 16px;

            display: flex;
            flex-direction: column;
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
           TOP NAV
        ===================================================== */

        .top-nav {
            position: relative;
            z-index: 10;
            flex-shrink: 0;
            margin-bottom: 6px;
        }

        .back-link {
            color: rgba(7, 20, 47, .70);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .5px;
            transition: color .2s ease;
        }

        .back-link:hover {
            color: #07142f;
        }

        /* =====================================================
           APPLYING AI MAGIC — MOVED TO TOP
        ===================================================== */

        .title-section {
            position: relative;
            z-index: 10;

            text-align: center;
            flex-shrink: 0;

            margin: 2px auto 4px;
        }

        .title-section h1 {
            color: #ffffff;

            font-size: clamp(34px, 4.6vw, 58px);
            font-weight: 800;

            letter-spacing: .5px;
            margin-bottom: 4px;

            text-shadow:
                0 0 12px rgba(255,255,255,.35),
                0 0 30px rgba(30,140,255,.55),
                0 0 60px rgba(20,110,255,.35);

            animation: titleGlow 3s ease-in-out infinite;
        }

        @keyframes titleGlow {

            0%,
            100% {
                text-shadow:
                    0 0 12px rgba(255,255,255,.35),
                    0 0 30px rgba(30,140,255,.55),
                    0 0 60px rgba(20,110,255,.35);
            }

            50% {
                text-shadow:
                    0 0 18px rgba(255,255,255,.55),
                    0 0 45px rgba(30,140,255,.8),
                    0 0 85px rgba(20,110,255,.5);
            }
        }

        .title-section p {
            color: rgba(218,237,255,.85);
            font-size: 20px;
        }

        /* =====================================================
           THEME BADGE
        ===================================================== */

        .theme-label {
            position: relative;
            z-index: 10;

            text-align: center;
            flex-shrink: 0;

            margin-top: 10px;
            margin-bottom: 6px;
        }

        .theme-label span {
            display: inline-block;

            padding: 11px 28px;

            border: 1px solid rgba(255,255,255,.9);
            border-radius: 50px;

            background: rgba(255,255,255,.62);

            color: #17385e;

            box-shadow:
                0 7px 20px rgba(0,45,120,.10),
                inset 0 1px 0 rgba(255,255,255,.95);

            backdrop-filter: blur(10px);

            font-size: 21px;
            letter-spacing: .8px;
        }

        .theme-label strong {
            color: #075a91;
        }

        /* =====================================================
           GENERATION AREA
        ===================================================== */

        .generation-container {
            position: relative;
            z-index: 10;

            width: 100%;
            max-width: 1900px;

            margin: 0 auto;

            display: grid;
            grid-template-columns: minmax(0, 1fr) clamp(140px, 13vw, 240px) minmax(0, 1fr);

            align-items: center;

            gap: 20px;

            flex: 1;
            min-height: 0;
        }

        /* =====================================================
           PHOTO
        ===================================================== */

        .photo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

            min-width: 0;
            min-height: 0;
        }

        .photo-title {
            color: #ffffff;

            font-size: 30px;
            font-weight: 700;

            letter-spacing: 2px;
            text-transform: uppercase;

            margin-bottom: 8px;

            /* Lift the label without moving the photo frame */
            transform: translateY(-16px);

            text-shadow:
                0 0 12px rgba(0,102,255,.55);
        }

        .photo-frame {
            width: min(100%, 900px);

            aspect-ratio: 3 / 2;

            max-height: 56vh;

            border-radius: 20px;

            overflow: hidden;

            background: rgba(255,255,255,.38);

            border:
                2px solid
                rgba(255,255,255,.82);

            box-shadow:
                0 18px 45px rgba(0,30,90,.25),
                0 0 25px rgba(70,160,255,.15),
                inset 0 1px 0 rgba(255,255,255,.9);

            position: relative;

            backdrop-filter: blur(8px);
        }

        .photo-frame img {
            width: 100%;
            height: 100%;

            display: block;

            object-fit: cover;
        }

        .photo-placeholder {
            width: 100%;
            height: 100%;

            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;

            color: rgba(7,20,47,.58);

            text-align: center;

            background:
                linear-gradient(
                    145deg,
                    rgba(255,255,255,.62),
                    rgba(225,240,255,.35)
                );
        }

        .photo-placeholder-icon {
            font-size: 42px;
            margin-bottom: 10px;
        }

        .photo-placeholder p {
            font-size: 18px;
        }

        /* =====================================================
           RUPA (between the two photo frames)
        ===================================================== */

        .rupa-character {
            position: relative;

            /* Keeps the speech bubble above both photo frames */
            z-index: 5;

            width: 100%;

            pointer-events: none;
            line-height: 0;
        }

        .rupa-character::before {
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

        .rupa-character img {
            position: relative;

            display: block;
            width: 100%;
            height: auto;
            object-fit: contain;

            will-change: translate;

            animation: rupaFloat 3.6s cubic-bezier(0.45, 0, 0.55, 1) infinite;
        }

        @keyframes rupaFloat {
            0%,
            100% {
                translate: 0 0;
            }

            50% {
                translate: 0 -12px;
            }
        }

        /*
         * Speech bubble above Rupa's head holding the
         * progress message and bar. It is wider than
         * the middle column, so it may overlap the inner
         * edges of the photo frames.
         */

        .rupa-speech {
            position: absolute;

            z-index: 2;

            bottom: calc(100% + 6px);
            left: 50%;

            transform: translateX(-50%);

            width: clamp(260px, 22vw, 380px);

            padding: 18px 22px;

            border-radius: 24px;

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

            line-height: 1.3;
            text-align: center;

            transform-origin: 50% 100%;

            animation: rupaSpeechPop 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) 0.3s both;
        }

        /* Tail pointing down at Rupa's head */

        .rupa-speech::after {
            content: "";

            position: absolute;

            left: 50%;
            bottom: -9px;

            width: 16px;
            height: 16px;

            margin-left: -8px;

            background: rgba(6, 28, 75, 0.95);

            border-right: 1px solid rgba(90, 170, 255, 0.65);
            border-bottom: 1px solid rgba(90, 170, 255, 0.65);

            rotate: 45deg;
        }

        .rupa-speech-message {
            min-height: 2.6em;

            margin: 0;

            font-size: 20px;
            letter-spacing: 0.02em;
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

        @keyframes rupaSpeechPop {
            from {
                opacity: 0;
                scale: 0.6;
                translate: 0 10px;
            }

            to {
                opacity: 1;
                scale: 1;
                translate: 0 0;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .rupa-character img,
            .rupa-speech,
            .rupa-speech-caret {
                animation: none;
            }
        }

        /* =====================================================
           AI RESULT LOADING — DARK BLUE PORTAL
        ===================================================== */

        /*
         * Near-black navy backdrop with a dark blue portal
         * swirling in the middle. The arms are bent by an SVG
         * noise filter (#aiPortalWarp) and inner bands spin
         * faster than outer ones, like a real vortex. When the
         * photo is ready the box gets .is-done and the portal
         * and the backdrop burn to a bright white.
         */

        .ai-magic-placeholder {
            position: relative;

            overflow: hidden;

            color: #ffffff;

            background:
                radial-gradient(
                    circle at 50% 42%,
                    rgba(8, 30, 110, 0.55) 0%,
                    transparent 55%
                ),
                linear-gradient(
                    120deg,
                    #000208,
                    #020a24,
                    #01061a,
                    #03113a,
                    #000208
                );

            background-size: 100% 100%, 300% 300%;

            animation: aiAurora 10s ease-in-out infinite;
        }

        /* White light that floods the box once the photo is ready */

        .ai-magic-placeholder::after {
            content: "";

            position: absolute;
            inset: 0;

            z-index: 1;

            background:
                radial-gradient(
                    circle at 50% 42%,
                    #ffffff 0%,
                    rgba(235, 246, 255, 0.95) 35%,
                    rgba(190, 225, 255, 0.85) 100%
                );

            opacity: 0;

            pointer-events: none;

            transition: opacity 0.9s ease 0.2s;
        }

        .ai-magic-placeholder.is-done::after {
            opacity: 1;
        }

        .ai-magic-placeholder p {
            position: relative;
            z-index: 3;

            font-size: 20px;
            font-weight: 600;
            letter-spacing: 0.04em;

            color: #b9d6ff;

            text-shadow: 0 0 12px rgba(30, 90, 255, 0.8);

            transition: color 0.6s ease, text-shadow 0.6s ease;
        }

        .ai-magic-placeholder.is-done p {
            color: #0a2a5c;

            text-shadow: 0 0 12px rgba(255, 255, 255, 0.9);
        }

        /*
         * The portal fills the whole box: it is a circle wider
         * than the box's diagonal, centred and clipped by the
         * box, with the text sitting along the bottom.
         */

        .ai-magic-placeholder {
            justify-content: flex-end;

            padding-bottom: 5%;
        }

        .ai-magic-placeholder.is-error {
            justify-content: center;

            padding-bottom: 0;
        }

        .ai-magic {
            position: absolute;
            inset: 0;

            z-index: 2;
        }

        .ai-portal-filters {
            position: absolute;
        }

        .ai-portal {
            position: absolute;

            left: 50%;
            top: 50%;

            width: 135%;

            aspect-ratio: 1;

            translate: -50% -50%;

            container-type: inline-size;

            transition:
                filter 0.9s ease,
                scale 0.9s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        /* Dark blue haze drifting around the portal */

        .ai-portal-mist {
            position: absolute;
            inset: -28%;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(10, 40, 150, 0.6) 0%,
                    rgba(5, 22, 90, 0.35) 38%,
                    transparent 68%
                );

            filter: url(#aiPortalWarp);

            animation:
                aiSpin 14s linear infinite,
                aiPortalBreathe 3s ease-in-out infinite;
        }

        /*
         * Spiral bands: each one is a ring of dark blue arms.
         * Inner bands are smaller and spin faster, and their
         * arms start further round, so together they twist
         * into a spiral.
         */

        .ai-portal-swirl {
            position: absolute;
            inset: var(--i);

            border-radius: 50%;

            background:
                repeating-conic-gradient(
                    from var(--r),
                    rgba(1, 6, 26, 0) 0deg,
                    rgba(18, 62, 190, 0.9) 12deg,
                    rgba(6, 26, 100, 0.75) 22deg,
                    rgba(1, 6, 26, 0) 36deg
                );

            -webkit-mask: radial-gradient(farthest-side, transparent 52%, #000 70%, #000 86%, transparent 100%);
            mask: radial-gradient(farthest-side, transparent 52%, #000 70%, #000 86%, transparent 100%);

            filter: url(#aiPortalWarp) blur(0.6px);

            animation: aiSpin var(--s) linear infinite;
        }

        /* Thin crackling rim of electric blue around the eye */

        .ai-portal-ring {
            position: absolute;
            inset: 36%;

            border-radius: 50%;

            border: 2px solid rgba(40, 110, 255, 0.55);

            box-shadow:
                0 0 18px rgba(20, 80, 255, 0.7),
                inset 0 0 22px rgba(20, 80, 255, 0.5);

            filter: url(#aiPortalWarp);

            animation: aiPortalFlicker 2.8s ease-in-out infinite;
        }

        /* Sparks pulled in along a spiral towards the centre */

        .ai-portal-spark {
            position: absolute;

            left: 50%;
            top: 50%;

            width: 5px;
            height: 5px;

            margin: -2.5px 0 0 -2.5px;

            border-radius: 50%;

            background: #8fb8ff;

            box-shadow:
                0 0 6px #2f6bff,
                0 0 14px rgba(20, 70, 230, 0.9);

            opacity: 0;

            animation: aiPortalPull 2.4s cubic-bezier(0.5, 0, 0.9, 0.6) var(--d) infinite;
        }

        /* Dark eye of the portal holding Rupa */

        .ai-portal-core {
            position: absolute;
            inset: 38%;

            display: flex;
            align-items: center;
            justify-content: center;

            overflow: hidden;

            border-radius: 50%;

            font-size: 38px;

            background:
                radial-gradient(
                    circle,
                    #061a5a 0%,
                    #020a28 55%,
                    #000105 100%
                );

            box-shadow:
                0 0 26px 6px rgba(0, 2, 12, 0.95),
                0 0 40px rgba(20, 70, 230, 0.55),
                inset 0 0 24px rgba(0, 0, 0, 0.9);

            animation: aiCorePulse 2s ease-in-out infinite;
        }

        .ai-portal-core img {
            width: 100%;
            height: 100%;

            object-fit: cover;
        }

        /* DONE: the portal flares up to bright white */

        .ai-magic-placeholder.is-done .ai-portal {
            filter: brightness(6) saturate(0);

            scale: 1.15;
        }

        .ai-magic-placeholder.is-done .ai-portal-core {
            background: #ffffff;
        }

        @keyframes aiAurora {
            0%,
            100% {
                background-position: 0 0, 0% 50%;
            }

            50% {
                background-position: 0 0, 100% 50%;
            }
        }

        @keyframes aiSpin {
            to {
                rotate: 360deg;
            }
        }

        @keyframes aiPortalBreathe {
            0%,
            100% {
                opacity: 0.75;
                scale: 0.95;
            }

            50% {
                opacity: 1;
                scale: 1.05;
            }
        }

        @keyframes aiPortalFlicker {
            0%,
            100% {
                opacity: 0.6;
            }

            40% {
                opacity: 1;
            }

            55% {
                opacity: 0.45;
            }

            70% {
                opacity: 0.9;
            }
        }

        @keyframes aiPortalPull {
            0% {
                opacity: 0;
                transform: rotate(var(--a)) translateX(48cqw) scale(1);
            }

            20% {
                opacity: 1;
            }

            100% {
                opacity: 0;
                transform: rotate(calc(var(--a) + 220deg)) translateX(0) scale(0.2);
            }
        }

        @keyframes aiCorePulse {
            0%,
            100% {
                scale: 0.97;
            }

            50% {
                scale: 1.03;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .ai-magic-placeholder,
            .ai-portal-mist,
            .ai-portal-swirl,
            .ai-portal-ring,
            .ai-portal-core {
                animation: none;
            }

            .ai-portal-spark {
                display: none;
            }
        }

        .retry-button {
            margin-top: 14px;
            padding: 10px 26px;

            border: 1px solid rgba(255,255,255,.65);
            border-radius: 999px;

            background: rgba(8,119,232,.85);
            color: #ffffff;

            font-size: 18px;
            font-weight: 700;

            cursor: pointer;
        }

        .retry-button:hover {
            background: rgba(8,119,232,1);
        }

        /* =====================================================
           PROGRESS
        ===================================================== */

        /* Sits inside Rupa's speech bubble */

        .progress-container {
            width: 100%;

            margin-top: 14px;
        }

        .progress-bar {
            width: 100%;
            height: 12px;

            border-radius: 10px;
            overflow: hidden;

            background: rgba(255,255,255,.2);

            box-shadow:
                inset 0 1px 3px rgba(0,50,120,.12);
        }

        .progress-fill {
            width: 0%;
            height: 100%;

            background:
                linear-gradient(
                    90deg,
                    #0877e8,
                    #54c4ff
                );

            border-radius: 10px;

            transition: width .5s ease;

            box-shadow:
                0 0 12px rgba(0,130,255,.55);
        }

        .progress-text {
            text-align: center;

            margin-top: 8px;

            font-size: 18px;
            font-weight: 700;

            color: #8fd0ff;
        }

        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 800px) {

            html,
            body {
                overflow-y: auto;
            }

            .generate-page {
                min-height: 100vh;
                height: auto;
                min-height: 100dvh;
                overflow-y: auto;
                padding: 18px 20px 25px;
            }

            .generation-container {
                flex: none;
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .rupa-character {
                width: 120px;
                margin: 0 auto;
            }

            /*
             * Frames are stacked on mobile, so the bubble
             * sits in the flow above Rupa instead of
             * floating over the photo above it.
             */
            .rupa-speech {
                position: relative;
                bottom: auto;

                width: min(88vw, 360px);

                margin-bottom: 14px;
            }

            .photo-frame {
                width: min(88vw, 560px);
                max-height: none;
            }

            .title-section h1 {
                font-size: 38px;
            }
        }

        @media (max-width: 480px) {

            .title-section h1 {
                font-size: 32px;
            }

            .title-section p {
                font-size: 16px;
            }

            .photo-frame {
                width: min(90vw, 420px);
            }
        }

        /* =====================================================
        FINAL HEADER / BACK BUTTON FIX
        ===================================================== */

        /* Move the whole Back container to bottom-left */
        .top-nav {
            position: fixed !important;

            left: 35px !important;
            bottom: 28px !important;

            top: auto !important;
            right: auto !important;

            margin: 0 !important;

            z-index: 999 !important;
        }


        /* Liquid glass Back button */
        .back-link {
            position: relative !important;

            display: flex !important;
            align-items: center !important;
            justify-content: center !important;

            width: 150px !important;
            height: 62px !important;

            padding: 0 !important;

            border-radius: 999px !important;

            color: #ffffff !important;

            background:
                linear-gradient(
                    135deg,
                    rgba(255,255,255,0.24),
                    rgba(80,170,255,0.12)
                ) !important;

            border:
                1px solid rgba(255,255,255,0.65) !important;

            backdrop-filter: blur(16px) saturate(140%) !important;
            -webkit-backdrop-filter: blur(16px) saturate(140%) !important;

            box-shadow:
                0 10px 30px rgba(0,25,80,0.45),
                inset 0 1px 0 rgba(255,255,255,0.75),
                inset 0 -1px 0 rgba(0,50,130,0.25) !important;

            font-size: 17px !important;
            font-weight: 700 !important;
            letter-spacing: 0.5px !important;

            text-decoration: none !important;

            overflow: hidden !important;

            transition:
                transform 0.3s ease,
                box-shadow 0.3s ease,
                background 0.3s ease !important;
        }


        /* Liquid reflection */
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


        /* Hover effect */
        .back-link:hover {
            color: #ffffff !important;

            transform:
                translateY(-4px) !important;

            background:
                linear-gradient(
                    135deg,
                    rgba(255,255,255,0.32),
                    rgba(50,155,255,0.25)
                ) !important;

            box-shadow:
                0 12px 35px rgba(0,80,220,0.5),
                0 0 25px rgba(80,190,255,0.35),
                inset 0 1px 0 rgba(255,255,255,0.85) !important;
        }


        .back-link:hover::before {
            left: 130%;
        }


        /* Exit animation before moving on to the result page */
        .generate-page.is-leaving {
            animation: generatePageLeave .6s cubic-bezier(.4, 0, .2, 1) forwards;
        }

        @keyframes generatePageLeave {

            to {
                opacity: 0;
                transform: scale(1.06);
                filter: blur(10px);
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .generate-page.is-leaving {
                animation-duration: .01s;
            }
        }


        /* =====================================================
           WHITE FLASH TRANSITION
           Plays once the photo is ready: a white bloom fills
           the screen like a camera flash, light rings burst
           out and the RUPAVUE logo shines in. The result page
           picks up from this exact frame and reveals itself.
        ===================================================== */

        .rv-flash {
            position: fixed;
            inset: 0;

            z-index: 9999;

            display: grid;
            place-items: center;

            overflow: hidden;

            pointer-events: none;

            visibility: hidden;
        }

        .rv-flash.active {
            visibility: visible;
        }

        .rv-flash-bloom {
            position: absolute;

            left: 50%;
            top: 50%;

            width: 160vmax;
            height: 160vmax;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    #ffffff 0%,
                    #ffffff 42%,
                    #eaf5ff 56%,
                    rgba(190,225,255,.6) 64%,
                    rgba(120,190,255,0) 70%
                );

            transform: translate(-50%, -50%) scale(0);
        }

        .rv-flash.active .rv-flash-bloom {
            animation: rvFlashBloom 1s cubic-bezier(.7, 0, .25, 1) forwards;
        }

        .rv-flash-ring {
            position: absolute;

            left: 50%;
            top: 50%;

            width: 40vmin;
            height: 40vmin;

            border-radius: 50%;

            border: 2px solid rgba(255,255,255,.95);

            box-shadow:
                0 0 30px rgba(120,200,255,.9),
                inset 0 0 30px rgba(120,200,255,.6);

            opacity: 0;

            transform: translate(-50%, -50%) scale(0);
        }

        .rv-flash.active .rv-flash-ring {
            animation: rvFlashRing .9s cubic-bezier(.2, .7, .2, 1) forwards;
        }

        .rv-flash.active .rv-flash-ring.is-late {
            animation-delay: .18s;
        }

        .rv-flash-word {
            position: relative;

            font-family: "Arial Black", Arial, sans-serif;
            font-size: clamp(38px, 8vw, 110px);

            letter-spacing: .06em;

            color: transparent;

            background:
                linear-gradient(
                    110deg,
                    #0a58d6 0%,
                    #0a58d6 40%,
                    #a8dcff 50%,
                    #0a58d6 60%,
                    #0a58d6 100%
                );
            background-size: 250% 100%;
            background-position: 100% 0;

            -webkit-background-clip: text;
            background-clip: text;

            filter: drop-shadow(0 0 18px rgba(0,110,255,.35));

            opacity: 0;

            transform: scale(.85);
        }

        .rv-flash.active .rv-flash-word {
            animation:
                rvFlashWordIn .6s .45s cubic-bezier(.2, .8, .2, 1) forwards,
                rvFlashShine 1.2s .6s ease-in-out forwards;
        }

        @keyframes rvFlashBloom {

            to {
                transform: translate(-50%, -50%) scale(1);
            }
        }

        @keyframes rvFlashRing {

            0% {
                opacity: 1;
                transform: translate(-50%, -50%) scale(0);
            }

            100% {
                opacity: 0;
                transform: translate(-50%, -50%) scale(3.2);
            }
        }

        @keyframes rvFlashWordIn {

            to {
                opacity: 1;
                transform: scale(1);
                letter-spacing: .12em;
            }
        }

        @keyframes rvFlashShine {

            to {
                background-position: 0% 0;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .rv-flash.active .rv-flash-bloom,
            .rv-flash.active .rv-flash-ring,
            .rv-flash.active .rv-flash-word {
                animation-duration: .01s;
                animation-delay: 0s;
            }
        }


        /* =====================================================
           INTRO — generating box full screen, then settles
           The AI Result box first appears alone, enlarged in
           the middle of the screen. After a few seconds it
           glides back into its place and the rest of the page
           fades in around it.
        ===================================================== */

        .top-nav,
        .title-section,
        .theme-label,
        .generation-container > .photo-container:not(.ai-result-container),
        .rupa-character,
        .ai-result-container .photo-title {
            transition:
                opacity .6s ease var(--gen-reveal-delay, 0s),
                translate .6s ease var(--gen-reveal-delay, 0s);
        }

        .title-section {
            --gen-reveal-delay: .1s;
        }

        .theme-label {
            --gen-reveal-delay: .2s;
        }

        .generation-container > .photo-container:not(.ai-result-container) {
            --gen-reveal-delay: .3s;
        }

        .rupa-character {
            --gen-reveal-delay: .45s;
        }

        .ai-result-container .photo-title {
            --gen-reveal-delay: .3s;
        }

        .top-nav {
            --gen-reveal-delay: .6s;
        }

        html.gen-intro .top-nav,
        html.gen-intro .title-section,
        html.gen-intro .theme-label,
        html.gen-intro .generation-container > .photo-container:not(.ai-result-container),
        html.gen-intro .rupa-character,
        html.gen-intro .ai-result-container .photo-title {
            opacity: 0;
            translate: 0 18px;

            pointer-events: none;
        }

        /* Hidden until the script has moved it to the centre */

        html.gen-intro #aiResultFrame {
            position: relative;
            z-index: 50;

            opacity: 0;
        }

        html.gen-intro #aiResultFrame.is-intro-ready {
            opacity: 1;

            animation: genIntroPop .7s cubic-bezier(.2, .8, .2, 1) both;
        }

        #aiResultFrame.is-settling {
            position: relative;
            z-index: 50;

            transition: transform 1.1s cubic-bezier(.65, 0, .25, 1);
        }

        @keyframes genIntroPop {
            from {
                opacity: 0;
                scale: .7;
            }

            to {
                opacity: 1;
                scale: 1;
            }
        }
    </style>
</head>

<body>

    <!-- =====================================================
         WHITE FLASH TRANSITION
    ===================================================== -->

    <div class="rv-flash" id="rvFlash" aria-hidden="true">
        <div class="rv-flash-bloom"></div>
        <div class="rv-flash-ring"></div>
        <div class="rv-flash-ring is-late"></div>
        <div class="rv-flash-word">RUPAVUE</div>
    </div>

    <!-- =====================================================
         BACKGROUND
    ===================================================== -->

    <div class="rv-background">

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


<div class="generate-page">

    <!-- =========================
         BACK
    ========================== -->

    <div class="top-nav">

        <a
            href="{{ route('photobooth.create') }}?theme_id={{ $theme->id ?? '' }}"
            class="back-link"
        >
            ← Back
        </a>

    </div>




    <!-- =========================
         TITLE
    ========================== -->

    <section class="title-section">

        <h1>
            Applying AI Magic
        </h1>

    </section>


    <!-- =========================
         THEME
    ========================== -->

    <p id="statusText" style="display:none;"></p>

    <div class="theme-label">

        <span>
            Theme:
            <strong id="themeName">
                {{ $theme->theme_name ?? 'Unknown Theme' }}
            </strong>
        </span>

    </div>


    <!-- =========================
         PHOTO COMPARISON
    ========================== -->

    <div class="generation-container">

        <!-- ORIGINAL -->

        <div class="photo-container">

            <div class="photo-title">
                Your Photo
            </div>

            <div class="photo-frame">

                <img
                    id="originalPhoto"
                    alt="Your captured photo"
                    style="display: none;"
                >

                <div
                    class="photo-placeholder"
                    id="photoPlaceholder"
                >

                    <div class="photo-placeholder-icon">
                        📷
                    </div>

                    <p>
                        Preparing your photo...
                    </p>

                </div>

            </div>

        </div>


        <!-- RUPA -->

        <div class="rupa-character">

            <!-- Rupa "talks" the progress -->

            <div class="rupa-speech" id="rupaSpeech" role="status" aria-live="polite">

                <p class="rupa-speech-message">
                    <span id="rupaSpeechText"></span><span class="rupa-speech-caret" aria-hidden="true"></span>
                </p>

                <div class="progress-container">

                    <div class="progress-bar">

                        <div
                            class="progress-fill"
                            id="progressFill"
                        ></div>

                    </div>

                    <div
                        class="progress-text"
                        id="progressText"
                    >
                        0%
                    </div>

                </div>

            </div>

            <img
                src="{{ asset('images/rupa-waiting.png') }}"
                alt=""
                aria-hidden="true"
            >
        </div>


        <!-- GENERATED -->

        <div class="photo-container ai-result-container">

            <div class="photo-title">
                AI Result
            </div>

            <div class="photo-frame" id="aiResultFrame">

                <div class="photo-placeholder ai-magic-placeholder">

                    <!-- AI "creating" animation -->

                    <div class="ai-magic" id="aiMagic" aria-hidden="true">

                        <!--
                            Noise that bends the portal's arms like
                            swirling energy instead of straight rays.
                        -->
                        <svg class="ai-portal-filters" width="0" height="0" focusable="false">
                            <filter id="aiPortalWarp" x="-25%" y="-25%" width="150%" height="150%">
                                <feTurbulence type="fractalNoise" baseFrequency="0.022" numOctaves="2" seed="7" result="noise">
                                    <animate attributeName="baseFrequency" dur="9s" values="0.018;0.03;0.018" repeatCount="indefinite" />
                                </feTurbulence>
                                <feDisplacementMap in="SourceGraphic" in2="noise" scale="22" xChannelSelector="R" yChannelSelector="G" />
                            </filter>
                        </svg>

                        <div class="ai-portal">
                            <span class="ai-portal-mist"></span>

                            <span class="ai-portal-swirl" style="--i: 0%; --r: 0deg; --s: 7s;"></span>
                            <span class="ai-portal-swirl" style="--i: 9%; --r: 12deg; --s: 5s;"></span>
                            <span class="ai-portal-swirl" style="--i: 17%; --r: 24deg; --s: 3.6s;"></span>
                            <span class="ai-portal-swirl" style="--i: 24%; --r: 36deg; --s: 2.5s;"></span>

                            <span class="ai-portal-ring"></span>

                            <span class="ai-portal-spark" style="--a: 0deg; --d: 0s;"></span>
                            <span class="ai-portal-spark" style="--a: 45deg; --d: 0.8s;"></span>
                            <span class="ai-portal-spark" style="--a: 90deg; --d: 1.6s;"></span>
                            <span class="ai-portal-spark" style="--a: 135deg; --d: 0.4s;"></span>
                            <span class="ai-portal-spark" style="--a: 180deg; --d: 1.2s;"></span>
                            <span class="ai-portal-spark" style="--a: 225deg; --d: 2s;"></span>
                            <span class="ai-portal-spark" style="--a: 270deg; --d: 0.6s;"></span>
                            <span class="ai-portal-spark" style="--a: 315deg; --d: 1.4s;"></span>

                            <!-- Centre picture: public/images/rupa-generating.png -->
                            <span class="ai-portal-core">
                                <img
                                    src="{{ asset('images/rupa-generating.png') }}"
                                    alt=""
                                    onerror="this.replaceWith('✨')"
                                >
                            </span>
                        </div>
                    </div>

                    <p id="loadingText">
                        AI is creating...
                    </p>

                    <button
                        type="button"
                        id="retryButton"
                        class="retry-button"
                        style="display: none;"
                        onclick="window.location.reload()"
                    >
                        Try Again
                    </button>

                </div>

            </div>

        </div>

    </div>


    <!-- Status is displayed at the top and in Rupa's speech bubble. -->

</div>


<script>

    /*
     * =========================
     * ELEMENTS
     * =========================
     */

    const originalPhoto =
        document.getElementById('originalPhoto');

    const photoPlaceholder =
        document.getElementById('photoPlaceholder');

    const statusText =
        document.getElementById('statusText');

    const topStatusText =
        document.getElementById('topStatusText');

    const progressFill =
        document.getElementById('progressFill');

    const progressText =
        document.getElementById('progressText');

    const rupaSpeechText =
        document.getElementById('rupaSpeechText');

    const prefersReducedMotion =
        window.matchMedia('(prefers-reduced-motion: reduce)').matches;


    /*
     * =========================
     * RUPA TALKING
     * =========================
     *
     * Rupa "types" each progress message in its
     * speech bubble. A newer message cancels one
     * that is still being typed.
     */

    let rupaTypingId = 0;

    async function rupaSay(message) {

        const typingId =
            ++rupaTypingId;

        if (prefersReducedMotion) {
            rupaSpeechText.textContent = message;

            return;
        }

        rupaSpeechText.textContent = '';

        for (const character of message) {

            if (typingId !== rupaTypingId) {
                return;
            }

            rupaSpeechText.textContent += character;

            await new Promise(
                (resolve) => setTimeout(resolve, 40)
            );
        }

    }


    /*
     * =========================
     * THEME (RESOLVED SERVER-SIDE)
     * =========================
     */

    const themeId =
        @json($theme->id ?? null);


    /*
     * =========================
     * LOAD CAPTURED PHOTO
     * =========================
     */

    const capturedPhoto =
        sessionStorage.getItem(
            'rupavueCapturedPhoto'
        );


    if (capturedPhoto) {

        originalPhoto.src =
            capturedPhoto;

        originalPhoto.style.display =
            'block';

        photoPlaceholder.style.display =
            'none';

    }


    /*
    |--------------------------------------------------------------------------
    | Progress
    |--------------------------------------------------------------------------
    */

    function updateProgress(
        value,
        message
    ) {

        stopProgressCreep();

        setProgressBar(value);

        setProgressMessage(message);

    }

    function setProgressBar(value) {

        progressFill.style.width =
            value + '%';

        progressText.textContent =
            Math.round(value) + '%';

    }

    function setProgressMessage(message) {

        statusText.textContent =
            message;

        if (topStatusText) {
            topStatusText.textContent = message;
        }

        rupaSay(message);

    }


    /*
     * Gemini does not report how far along an image is,
     * so while waiting the bar eases from `from` towards
     * `ceiling`, slowing down as it gets closer so it never
     * finishes before the photo really is ready. Around
     * `expectedMilliseconds` it is roughly 85% of the way.
     */

    let progressCreepTimer = null;

    function startProgressCreep(
        from,
        ceiling,
        expectedMilliseconds
    ) {

        stopProgressCreep();

        const startedAt =
            performance.now();

        progressCreepTimer = setInterval(() => {

            const elapsed =
                performance.now() - startedAt;

            const eased =
                1 - Math.exp(-2 * elapsed / expectedMilliseconds);

            setProgressBar(
                from + (ceiling - from) * eased
            );

        }, 250);

    }

    function stopProgressCreep() {

        clearInterval(progressCreepTimer);

        progressCreepTimer = null;

    }


    /*
    |--------------------------------------------------------------------------
    | Show Error (visible to the guest, stops the spinner)
    |--------------------------------------------------------------------------
    */

    function showError(message) {

        stopProgressCreep();

        statusText.textContent = message;

        if (topStatusText) {
            topStatusText.textContent = message;
        }

        progressText.textContent = 'Error';
        progressFill.style.width = '0%';

        rupaSay('Oh no! ' + message);

        const aiMagic =
            document.getElementById('aiMagic');

        const loadingText =
            document.getElementById('loadingText');

        const retryButton =
            document.getElementById('retryButton');

        if (aiMagic) {
            aiMagic.style.display = 'none';

            aiMagic.parentElement.classList.add('is-error');
        }

        if (loadingText) {
            loadingText.textContent = 'Generation failed';
        }

        if (retryButton) {
            retryButton.style.display = 'inline-block';
        }

    }


    /*
    |--------------------------------------------------------------------------
    | Wait Helper
    |--------------------------------------------------------------------------
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
    |--------------------------------------------------------------------------
    | Generate AI Image
    |--------------------------------------------------------------------------
    */

    async function generateAIImage() {

        if (!capturedPhoto) {

            showError(
                'No photo was captured. Please go back and take a photo.'
            );

            return;

        }


        if (!themeId) {

            showError(
                'No theme was selected. Please go back and choose a theme.'
            );

            return;

        }


        let creatingMessageTimer = null;

        try {

            updateProgress(
                10,
                'Preparing your photo...'
            );


            await wait(500);


            updateProgress(
                25,
                'Uploading your photo...'
            );

            startProgressCreep(25, 90, 20000);

            creatingMessageTimer =
                setTimeout(() => {
                    setProgressMessage('AI is creating your photo...');
                }, 1500);


            /*
            * Send photo + theme to Laravel
            */

            const response =
                await fetch(
                    "{{ route('gemini.generate') }}",
                    {

                        method: 'POST',

                        headers: {

                            'Content-Type':
                                'application/json',

                            'X-CSRF-TOKEN':
                                '{{ csrf_token() }}',

                            'Accept':
                                'application/json'

                        },

                        body: JSON.stringify({

                            image:
                                capturedPhoto,

                            theme_id:
                                themeId,

                            frame_id:
                                sessionStorage.getItem('rupavueFrameId')

                        })

                    }
                );


            clearTimeout(creatingMessageTimer);


            let data = null;

            try {

                data = await response.json();

            } catch (parseError) {

                console.error(
                    'Non-JSON response:',
                    response.status
                );

                throw new Error(
                    'The server returned an unexpected response (' +
                    response.status + '). Please try again.'
                );

            }


            /*
            * Check response
            */

            if (!response.ok ||
                !data.success) {

                console.error(
                    'Generation error:',
                    data
                );

                throw new Error(
                    data.message ||
                    'AI generation failed.'
                );

            }


            updateProgress(
                90,
                'Finishing your photo...'
            );


            /*
            * Save generated image
            */

            sessionStorage.setItem(
                'rupavueGeneratedPhoto',
                data.generated_image
            );


            sessionStorage.setItem(
                'rupavueGeneratedImageId',
                data.generated_image_id
            );


            sessionStorage.setItem(
                'rupavueAiPhoto',
                data.ai_image || data.generated_image
            );


            sessionStorage.setItem(
                'rupavueOriginalPhoto',
                data.original_image
            );


            sessionStorage.setItem(
                'rupavueThemeName',
                data.theme
            );


            sessionStorage.setItem(
                'rupavuePublicPhotoUrl',
                data.public_photo_url || ''
            );


            sessionStorage.setItem(
                'rupavueQrCodeUrl',
                data.qr_code_url || ''
            );


            await wait(700);


            updateProgress(
                100,
                'Your photo is ready!'
            );


            /*
            * Portal flares up to bright white
            */

            document
                .querySelector('.ai-magic-placeholder')
                .classList
                .add('is-done');

            document.getElementById('loadingText').textContent =
                'Your photo is ready!';


            await wait(1100);


            /*
            * Go to result
            */

            const flash =
                document.getElementById('rvFlash');

            flash.classList.add('active');

            document
                .querySelector('.generate-page')
                .classList
                .add('is-leaving');

            // Tell the result page to continue the flash on arrival
            try {
                sessionStorage.setItem('rupavueFlashIn', '1');
            } catch (e) {}

            await wait(600);

            // Let the logo shine before switching pages
            await wait(700);

            // Undo the fade if the browser restores this page via Back
            window.addEventListener('pageshow', event => {
                if (event.persisted) {
                    flash.classList.remove('active');

                    document
                        .querySelector('.generate-page')
                        .classList
                        .remove('is-leaving');
                }
            }, { once: true });

            window.location.href =
                "{{ route('photobooth.result') }}";


        } catch (error) {

            clearTimeout(creatingMessageTimer);

            console.error(
                error
            );


            showError(
                error.message ||
                'Something went wrong while creating your photo.'
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Intro
    |--------------------------------------------------------------------------
    |
    | Moves the AI Result box to the middle of the screen and
    | enlarges it, holds it there for a few seconds, then lets
    | it glide back into place while the rest of the page
    | fades in.
    */

    function playGenerateIntro() {

        const aiResultFrame =
            document.getElementById('aiResultFrame');

        const root =
            document.documentElement;

        if (!root.classList.contains('gen-intro') || !aiResultFrame) {
            root.classList.remove('gen-intro');

            return;
        }

        const bounds =
            aiResultFrame.getBoundingClientRect();

        const scale =
            Math.min(
                (window.innerWidth * 0.9) / bounds.width,
                (window.innerHeight * 0.85) / bounds.height
            );

        const offsetX =
            window.innerWidth / 2 - (bounds.left + bounds.width / 2);

        const offsetY =
            window.innerHeight / 2 - (bounds.top + bounds.height / 2);

        aiResultFrame.style.transform =
            'translate(' + offsetX + 'px, ' + offsetY + 'px) scale(' + scale + ')';

        aiResultFrame.classList.add('is-intro-ready');

        setTimeout(function () {

            aiResultFrame.classList.add('is-settling');

            aiResultFrame.style.transform = '';

            root.classList.remove('gen-intro');

            aiResultFrame.classList.remove('is-intro-ready');

            setTimeout(function () {
                aiResultFrame.classList.remove('is-settling');
            }, 1200);

        }, 3000);

    }

    playGenerateIntro();


    /*
    |--------------------------------------------------------------------------
    | Start Generation
    |--------------------------------------------------------------------------
    */

    generateAIImage();

</script>

</body>
</html>
