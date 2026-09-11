<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>RupaVue - Result</title>


    <!-- =====================================================
         QR CODE LIBRARY
    ====================================================== -->

    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>


    <style>

        /* =====================================================
           RESET
        ====================================================== */

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

            background: #f7e9df;

            color: #003f42;
        }


        /* =====================================================
           PAGE
        ====================================================== */

        .result-page {

            min-height: 100vh;

            padding:
                20px 2% 25px;

            background:
                url('/images/demo-background.jpg');

            background-size: cover;

            background-position: center;

            background-repeat: no-repeat;

        }


        /* =====================================================
           HEADER
        ====================================================== */

        .header {

            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-bottom: 18px;

        }


        .logo {

            display: flex;

            align-items: center;

            gap: 7px;

            font-size: 24px;

            font-weight: 800;

        }


        .logo-dot {

            width: 10px;

            height: 10px;

            border-radius: 50%;

            background: #ff929b;

        }


        .back-link {

            display: inline-flex;

            align-items: center;

            gap: 6px;

            padding:
                6px 13px;

            border-radius: 30px;

            background:
                rgba(0, 63, 66, 0.08);

            color: #003f42;

            font-size: 10px;

            font-weight: 700;

            text-decoration: none;

            transition: 0.2s ease;

        }


        .back-link:hover {

            background:
                rgba(0, 63, 66, 0.16);

        }


        .ready {

            padding:
                6px 13px;

            border-radius: 30px;

            background:
                rgba(0, 63, 66, 0.08);

            font-size: 10px;

            font-weight: 700;

        }


        /* =====================================================
           PHOTO + QR SECTION
        ====================================================== */

        .photo-qr-section {

            width: 100%;

            max-width: 1000px;

            margin: 0 auto 16px;

            display: flex;

            justify-content: center;

            align-items: center;

            gap: 25px;

        }


        /* =====================================================
           GENERATED PHOTO

           IMPORTANT:
           PHOTO REMAINS 2 : 3
        ====================================================== */

        .result-frame {

            width: 310px;

            aspect-ratio: 2 / 3;

            flex-shrink: 0;

            overflow: hidden;

            border:
                2px solid #003f42;

            border-radius: 18px;

            background: white;

            box-shadow:
                0 8px 20px
                rgba(0, 0, 0, 0.12);

        }


        .result-frame img {

            width: 100%;

            height: 100%;

            display: block;

            object-fit: cover;

        }


        .placeholder {

            width: 100%;

            height: 100%;

            display: flex;

            flex-direction: column;

            align-items: center;

            justify-content: center;

            text-align: center;

            color: #899596;

            font-size: 13px;

        }


        .placeholder-icon {

            font-size: 45px;

            margin-bottom: 10px;

        }


        /* =====================================================
           QR CARD
        ====================================================== */

        .qr-card {

            width: 330px;

            min-height: 430px;

            padding: 25px;

            background: white;

            border-radius: 18px;

            display: flex;

            flex-direction: column;

            align-items: center;

            justify-content: center;

            box-shadow:
                0 8px 20px
                rgba(0, 0, 0, 0.07);

        }


        .qr-title {

            font-size: 18px;

            font-weight: 700;

            margin-bottom: 5px;

        }


        .qr-description {

            max-width: 250px;

            text-align: center;

            font-size: 11px;

            line-height: 1.5;

            color: #7c8889;

            margin-bottom: 15px;

        }


        /* =====================================================
           QR CODE
        ====================================================== */

        .qr-container {

            width: 210px;

            height: 210px;

            padding: 8px;

            background: white;

            border:
                1px solid #dce2e2;

            border-radius: 10px;

            display: flex;

            align-items: center;

            justify-content: center;

            margin-bottom: 10px;

        }


        #qrCode {

            width: 190px;

            height: 190px;

        }


        #qrCode img {

            width: 190px;

            height: 190px;

        }


        .qr-status {

            font-size: 10px;

            color: #8b9697;

            margin-bottom: 15px;

        }


        /* =====================================================
           PRINT BUTTON
        ====================================================== */

        .print-button {

            width: 100%;

            padding: 12px;

            border:
                2px solid #003f42;

            border-radius: 30px;

            background: white;

            color: #003f42;

            font-size: 13px;

            font-weight: 700;

            cursor: pointer;

            transition: 0.2s ease;

        }


        .print-button:hover {

            background: #003f42;

            color: white;

        }


        /* =====================================================
           FEEDBACK
        ====================================================== */

        .feedback-card {

            width: 100%;

            max-width: 1000px;

            margin: 0 auto;

            padding:
                18px 22px;

            background: white;

            border-radius: 18px;

            text-align: center;

            box-shadow:
                0 8px 20px
                rgba(0, 0, 0, 0.05);

        }


        .feedback-title {

            font-size: 18px;

            font-weight: 700;

            margin-bottom: 4px;

        }


        .feedback-subtitle {

            font-size: 11px;

            color: #8a9495;

            margin-bottom: 12px;

        }


        /* =====================================================
           STARS
        ====================================================== */

        .stars {

            display: flex;

            justify-content: center;

            gap: 7px;

            margin-bottom: 12px;

        }


        .star {

            border: none;

            background: transparent;

            color: #ff8e98;

            font-size: 27px;

            cursor: pointer;

            padding: 0;

            transition: 0.15s ease;

        }


        .star:hover {

            transform: scale(1.15);

        }


        .star.selected {

            color: #ff7b87;

        }


        /* =====================================================
           QUICK FEEDBACK
        ====================================================== */

        .quick-feedback {

            display: flex;

            justify-content: center;

            gap: 8px;

            flex-wrap: wrap;

            margin-bottom: 12px;

        }


        .feedback-option {

            border:
                1px solid #d7dddd;

            background: white;

            color: #003f42;

            border-radius: 30px;

            padding:
                8px 15px;

            font-size: 11px;

            cursor: pointer;

            transition: 0.15s ease;

        }


        .feedback-option:hover {

            border-color: #003f42;

        }


        .feedback-option.selected {

            background: #003f42;

            color: white;

            border-color: #003f42;

        }


        /* =====================================================
           COMMENT
        ====================================================== */

        .comment {

            width: 100%;

            height: 65px;

            padding: 10px;

            resize: none;

            border:
                1px solid #d6dddd;

            border-radius: 10px;

            outline: none;

            font-family: Arial, Helvetica, sans-serif;

            font-size: 12px;

            color: #003f42;

        }


        .comment:focus {

            border-color: #003f42;

        }


        .comment::placeholder {

            color: #9ba4a5;

        }


        .comment-count {

            text-align: right;

            font-size: 9px;

            color: #929c9d;

            margin-top: 3px;

        }


        /* =====================================================
           SUBMIT
        ====================================================== */

        .submit-feedback {

            margin-top: 8px;

            padding:
                9px 22px;

            border: none;

            border-radius: 30px;

            background: #003f42;

            color: white;

            font-size: 11px;

            font-weight: 700;

            cursor: pointer;

        }


        .submit-feedback:hover {

            opacity: 0.9;

        }


        .success-message {

            display: none;

            margin-top: 8px;

            font-size: 11px;

            color: #4e7778;

        }


        /* =====================================================
           NEW SESSION
        ====================================================== */

        .new-session {

            width: 100%;

            max-width: 1000px;

            margin: 12px auto 0;

        }


        .new-session-button {

            width: 100%;

            padding: 13px;

            border: none;

            border-radius: 30px;

            background: #003f42;

            color: white;

            font-size: 13px;

            font-weight: 700;

            cursor: pointer;

        }


        .new-session-button:hover {

            opacity: 0.92;

        }


        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 800px) {

            .photo-qr-section {

                flex-direction: column;

            }


            .result-frame {

                width: 280px;

            }


            .qr-card {

                width: 100%;

                max-width: 350px;

                min-height: auto;

            }

        }


        @media (max-width: 500px) {

            .result-page {

                padding:
                    15px 12px 20px;

            }


            .logo {

                font-size: 20px;

            }


            .result-frame {

                width: 240px;

            }


            .quick-feedback {

                flex-direction: column;

                align-items: center;

            }


            .feedback-option {

                width: 200px;

            }

        }


        /* =====================================================
           FINAL RUPAVUE RESULT PAGE
           Large 2:3 result on left + QR/feedback on right
        ===================================================== */

        html,
        body {
            width: 100%;
            min-height: 100%;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #ffffff;
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

        .result-page {
            position: relative;
            min-height: 100vh;
            padding: 22px 3.5% 28px;
            overflow: hidden;

            /*
             * Explicitly cleared (not just omitted) so this
             * wins over the older unused .result-page rule
             * earlier in the stylesheet, which still points
             * at a background image.
             */
            background: none;
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

        .header {
            position: relative;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 25px;
            font-weight: 800;
            color: #fff !important;
            letter-spacing: .3px;
            text-shadow: 0 2px 10px rgba(0,25,80,.65);
        }

        .logo-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #ff929b;
            box-shadow: 0 0 10px rgba(255,146,155,.55);
        }

        /* Main split layout */
        .result-main {
            position: relative;
            z-index: 5;
            width: 100%;
            min-height: calc(100vh - 85px);

            display: grid;
            grid-template-columns: minmax(0, 1.08fr) minmax(420px, .92fr);
            gap: 34px;
            align-items: stretch;
        }

        .result-photo-area {
            min-width: 0;
            display: flex;
            align-items: stretch;
            justify-content: flex-start;
        }

        .result-frame {
            width: min(100%, 700px);
            height: calc(100vh - 105px);
            max-height: 920px;
            min-height: 620px;
            aspect-ratio: 2 / 3;

            overflow: hidden;
            border: 2px solid rgba(255,255,255,.92);
            border-radius: 28px;
            background: #fff;

            box-shadow:
                0 24px 65px rgba(0,25,80,.38),
                0 0 35px rgba(85,170,255,.28),
                inset 0 1px 0 rgba(255,255,255,.98);
        }

        .result-frame img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
        }

        .placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #66809d;
            font-size: 13px;
        }

        .placeholder-icon {
            font-size: 50px;
            margin-bottom: 10px;
        }

        /* Right side */
        .result-sidebar {
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 20px;
            min-height: 0;
        }

        .qr-card,
        .feedback-card {
            width: 100%;
            background: rgba(255,255,255,.88);
            border: 1px solid rgba(255,255,255,.92);
            border-radius: 24px;
            box-shadow:
                0 18px 45px rgba(0,30,85,.20),
                inset 0 1px 0 rgba(255,255,255,.98);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
        }

        .qr-card {
            min-height: 390px;
            padding: 25px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .qr-title {
            color: #062d70;
            font-size: 21px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .qr-description {
            max-width: 330px;
            text-align: center;
            font-size: 12px;
            line-height: 1.5;
            color: #4e6480;
            margin-bottom: 16px;
        }

        .qr-container {
            width: 225px;
            height: 225px;
            padding: 8px;
            background: #fff;
            border: 1px solid #cbdcf2;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            box-shadow: 0 8px 20px rgba(0,45,110,.10);
        }

        #qrCode {
            width: 205px;
            height: 205px;
        }

        #qrCode img {
            width: 205px;
            height: 205px;
        }

        .qr-status {
            font-size: 10px;
            color: #617a96;
            margin-bottom: 15px;
        }

        .print-button {
            width: 100%;
            max-width: 330px;
            padding: 13px;
            border: 1.5px solid #1689ff;
            border-radius: 999px;
            background: rgba(255,255,255,.65);
            color: #073477;
            font-size: 17px;
            font-weight: 800;
            cursor: pointer;
            box-shadow:
                0 8px 20px rgba(20,110,220,.13),
                inset 0 1px 0 rgba(255,255,255,.9);
            transition: .25s ease;
        }

        .print-button:hover {
            color: #fff;
            background: linear-gradient(135deg,#0a4dc7,#087fe8);
            box-shadow: 0 10px 25px rgba(0,90,230,.30);
        }

        /* Feedback */
        .feedback-card {
            flex: 1;
            min-height: 390px;
            padding: 22px 25px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .feedback-title {
            color: #062d70;
            font-size: 21px;
            font-weight: 800;
            margin-bottom: 4px;
        }

        .feedback-subtitle {
            font-size: 11px;
            color: #68809b;
            margin-bottom: 13px;
        }

        .stars {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-bottom: 13px;
        }

        .star {
            border: none;
            background: transparent;
            color: #1689ff;
            font-size: 30px;
            cursor: pointer;
            padding: 0;
            transition: .15s ease;
        }

        .star:hover { transform: scale(1.15); }
        .star.selected {
            color: #087fe8;
            text-shadow: 0 0 8px rgba(30,145,255,.25);
        }

        .quick-feedback {
            display: flex;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 13px;
        }

        .feedback-option {
            border: 1px solid #bdd4ee;
            background: rgba(255,255,255,.70);
            color: #073477;
            border-radius: 999px;
            padding: 8px 14px;
            font-size: 11px;
            cursor: pointer;
            transition: .2s ease;
        }

        .feedback-option:hover {
            border-color: #1689ff;
            transform: translateY(-1px);
        }

        .feedback-option.selected {
            background: linear-gradient(135deg,#0a4dc7,#087fe8);
            color: #fff;
            border-color: #087fe8;
        }

        .comment {
            width: 100%;
            height: 78px;
            padding: 11px;
            resize: none;
            border: 1px solid #bfd3eb;
            border-radius: 13px;
            outline: none;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #073477;
            background: rgba(255,255,255,.72);
        }

        .comment:focus {
            border-color: #1689ff;
            box-shadow: 0 0 0 3px rgba(22,137,255,.10);
        }

        .comment::placeholder { color: #7890a9; }

        .comment-count {
            text-align: right;
            font-size: 9px;
            color: #7187a0;
            margin-top: 3px;
        }

        .submit-feedback {
            margin: 9px auto 0;
            padding: 10px 25px;
            border: none;
            border-radius: 999px;
            background: linear-gradient(135deg,#063b9e,#087fe8);
            color: white;
            font-size: 11px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 8px 18px rgba(0,75,190,.22);
        }

        .submit-feedback:hover { transform: translateY(-1px); }

        .success-message {
            display: none;
            margin-top: 8px;
            font-size: 11px;
            color: #087fe8;
            font-weight: 700;
        }

        /* Start new session below feedback */
        .new-session {
            width: 100%;
            margin: 0;
        }

        .new-session-button {
            position: relative;
            width: 100%;
            padding: 15px;
            border: 1px solid rgba(255,255,255,.55);
            border-radius: 999px;
            background:
                linear-gradient(
                    135deg,
                    rgba(5,58,150,.95),
                    rgba(0,112,230,.92)
                );
            color: white;
            font-size: 18px;
            font-weight: 800;
            letter-spacing: .5px;
            cursor: pointer;
            box-shadow:
                0 12px 30px rgba(0,45,150,.32),
                inset 0 1px 0 rgba(255,255,255,.35);
            overflow: hidden;
            transition: .25s ease;
        }

        .new-session-button::before {
            content: "";
            position: absolute;
            top: -70%;
            left: -30%;
            width: 45%;
            height: 240%;
            background: linear-gradient(
                110deg,
                transparent,
                rgba(255,255,255,.28),
                transparent
            );
            transform: rotate(18deg);
            transition: left .55s ease;
        }

        .new-session-button:hover {
            transform: translateY(-3px);
            box-shadow:
                0 15px 35px rgba(0,75,220,.40),
                0 0 22px rgba(70,175,255,.28);
        }

        .new-session-button:hover::before { left: 125%; }

        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 1050px) {
            .result-main {
                grid-template-columns: minmax(0, 1fr) minmax(360px, .85fr);
                gap: 22px;
            }

            .result-frame {
                height: calc(100vh - 105px);
                min-height: 560px;
            }

            .qr-card {
                min-height: 350px;
            }

            .feedback-card {
                min-height: 350px;
            }
        }

        @media (max-width: 800px) {
            .result-page {
                padding: 16px;
                overflow-y: auto;
            }

            .header {
                margin-bottom: 18px;
            }

            .result-main {
                min-height: auto;
                grid-template-columns: 1fr;
                gap: 18px;
            }

            .result-photo-area {
                justify-content: center;
            }

            .result-frame {
                width: min(88vw, 500px);
                height: auto;
                min-height: 0;
                aspect-ratio: 2 / 3;
            }

            .result-sidebar {
                min-height: auto;
            }

            .qr-card,
            .feedback-card {
                min-height: auto;
            }

            .new-session {
                margin-top: 0;
            }
        }

        @media (max-width: 500px) {
            .logo { font-size: 20px; }

            .result-frame {
                width: min(90vw, 400px);
                border-radius: 20px;
            }

            .qr-card,
            .feedback-card {
                padding: 18px;
                border-radius: 20px;
            }

            .qr-container {
                width: 205px;
                height: 205px;
            }

            #qrCode,
            #qrCode img {
                width: 185px;
                height: 185px;
            }

            .quick-feedback {
                flex-direction: row;
            }

            .feedback-option {
                padding: 7px 10px;
                font-size: 10px;
            }
        }

        /* =========================================================
   FINAL ONE-SCREEN RESULT PAGE
========================================================= */

@media (min-width: 801px) {

    html,
    body {
        width: 100%;
        height: 100%;
        margin: 0;
        overflow: hidden !important;
    }

    /* Main page */
    .result-page {
        width: 100%;
        height: 100vh;
        min-height: 0 !important;

        padding: 12px 3.5% 10px !important;

        overflow: hidden !important;

        display: grid !important;

        grid-template-columns:
            minmax(520px, 1.08fr)
            minmax(440px, .72fr);

        grid-template-rows:
            38px
            344px
            minmax(0, 1fr)
            44px;

        column-gap: 28px;
        row-gap: 8px;
    }


    /* =====================================================
       REMOVE RUPAVUE LOGO
    ===================================================== */

    .header .logo,
    .header .logo-dot {
        display: none !important;
    }

    .header {
        grid-column: 1 / -1;
        grid-row: 1;

        width: 100%;
        height: 38px;

        margin: 0 !important;

        display: flex;
        justify-content: flex-end;
        align-items: center;

        position: relative;
        z-index: 20;
    }


    /* =====================================================
       PHOTO + QR WRAPPER
       
       Make the children behave as if they are directly
       inside the page grid.
    ===================================================== */

    .photo-qr-section {
        display: contents !important;
    }


    /* =====================================================
       GENERATED PHOTO
    ===================================================== */

    .result-frame {
        grid-column: 1;
        grid-row: 2 / 5;

        justify-self: center;
        align-self: start;

        width: auto !important;

        height: calc(100vh - 64px) !important;

        max-height: calc(100vh - 64px) !important;

        min-height: 0 !important;

        aspect-ratio: 2 / 3;

        border-radius: 24px !important;

        border: 2px solid rgba(255,255,255,.95);

        overflow: hidden;

        box-shadow:
            0 20px 50px rgba(0,25,80,.40),
            0 0 30px rgba(90,175,255,.25);
    }

    .result-frame img {
        width: 100% !important;
        height: 100% !important;

        object-fit: cover !important;
    }


    /* =====================================================
       QR CARD
    ===================================================== */

    .qr-card {
        grid-column: 2;
        grid-row: 2;

        width: 100% !important;
        height: 100% !important;

        min-height: 0 !important;

        padding: 14px 20px !important;

        border-radius: 22px !important;

        display: flex;

        flex-direction: column;

        align-items: center;

        justify-content: center;

        overflow: hidden;
    }

    .qr-title {
        font-size: 20px !important;

        margin-bottom: 3px !important;
    }

    .qr-description {
        font-size: 10px !important;

        line-height: 1.25 !important;

        max-width: 330px !important;

        margin-bottom: 7px !important;
    }

    .qr-container {
        width: 214px !important;
        height: 214px !important;

        padding: 6px !important;

        margin-bottom: 5px !important;

        border-radius: 12px !important;
    }

    #qrCode,
    #qrCode img {
        width: 200px !important;
        height: 200px !important;
    }

    .qr-status {
        font-size: 8px !important;

        margin-bottom: 6px !important;
    }

    .print-button {
        width: 85% !important;

        max-width: 300px !important;

        padding: 9px !important;

        font-size: 15px !important;
    }


    /* =====================================================
       FEEDBACK CARD
    ===================================================== */

    .feedback-card {
        grid-column: 2;
        grid-row: 3;

        width: 100% !important;
        height: 100% !important;

        min-height: 0 !important;

        padding: 12px 18px !important;

        border-radius: 22px !important;

        display: flex;

        flex-direction: column;

        justify-content: center;

        overflow: hidden;
    }

    .feedback-title {
        font-size: 18px !important;

        margin-bottom: 2px !important;
    }

    .feedback-subtitle {
        font-size: 9px !important;

        margin-bottom: 5px !important;
    }

    .stars {
        gap: 4px !important;

        margin-bottom: 5px !important;
    }

    .star {
        font-size: 23px !important;
    }

    .quick-feedback {
        gap: 4px !important;

        margin-bottom: 6px !important;

        flex-wrap: nowrap !important;
    }

    .feedback-option {
        padding: 5px 8px !important;

        font-size: 8px !important;

        white-space: nowrap;
    }

    .comment {
        height: 42px !important;

        min-height: 42px !important;

        padding: 8px !important;

        font-size: 10px !important;

        border-radius: 10px !important;
    }

    .comment-count {
        font-size: 7px !important;

        margin-top: 1px !important;
    }

    .submit-feedback {
        margin-top: 5px !important;

        padding: 8px 20px !important;

        font-size: 9px !important;
    }

    .success-message {
        margin-top: 4px !important;

        font-size: 9px !important;
    }


    /* =====================================================
       START NEW SESSION
    ===================================================== */

    .new-session {
        grid-column: 2;
        grid-row: 4;

        width: 100% !important;
        height: 44px !important;

        margin: 0 !important;
    }

    .new-session-button {
        width: 100% !important;

        height: 44px !important;

        padding: 8px !important;

        border-radius: 999px !important;

        font-size: 15px !important;
    }
}



/* =========================================================
   FINAL CLEAN DESKTOP LAYOUT — 1 SCREEN
   ========================================================= */
@media (min-width: 801px) {
    html, body {
        width: 100%;
        height: 100%;
        margin: 0;
        overflow: hidden !important;
    }

    .result-page {
        width: 100%;
        height: 100vh;
        min-height: 0 !important;
        padding: 10px 50px 10px !important;
        overflow: hidden !important;

        display: grid !important;
        grid-template-columns: 560px 820px !important;
        grid-template-rows: 32px 330px 280px 40px 40px !important;
        column-gap: 24px !important;
        row-gap: 8px !important;
        justify-content: center !important;
        align-content: start !important;
    }

    /* Hide logo completely */
    .header .logo,
    .header .logo-dot {
        display: none !important;
    }

    .header {
        grid-column: 1 / -1 !important;
        grid-row: 1 !important;
        width: 100% !important;
        height: 32px !important;
        margin: 0 !important;
        display: flex !important;
        justify-content: flex-end !important;
        align-items: center !important;
        z-index: 20 !important;
    }

    /* Generated image */
    .photo-qr-section {
        display: contents !important;
    }

    .result-frame {
        grid-column: 1 !important;
        grid-row: 2 / 6 !important;
        justify-self: start !important;
        align-self: start !important;
        width: 540px !important;
        height: 810px !important;
        min-height: 0 !important;
        max-height: none !important;
        aspect-ratio: 2 / 3 !important;
        margin-left: -30px !important;
        border-radius: 24px !important;
        border: 2px solid rgba(255,255,255,.95) !important;
        overflow: hidden !important;
        z-index: 5 !important;
        box-shadow:
            0 22px 55px rgba(0,25,80,.42),
            0 0 35px rgba(80,180,255,.28) !important;
    }

    .result-frame img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
    }

    /* QR */
    .qr-card {
        grid-column: 2 !important;
        grid-row: 2 !important;
        width: 460px !important;
        max-width: 100% !important;
        justify-self: center !important;
        height: 330px !important;
        min-height: 0 !important;
        padding: 16px 22px !important;
        border-radius: 22px !important;
        overflow: hidden !important;
        justify-content: center !important;
        z-index: 5 !important;
    }

    .qr-title {
        font-size: 21px !important;
        margin-bottom: 3px !important;
    }

    .qr-description {
        font-size: 10px !important;
        line-height: 1.25 !important;
        margin-bottom: 7px !important;
        max-width: 360px !important;
    }

    .qr-container {
        width: 232px !important;
        height: 232px !important;
        padding: 5px !important;
        margin-bottom: 4px !important;
        border-radius: 12px !important;
    }

    #qrCode,
    #qrCode img {
        width: 220px !important;
        height: 220px !important;
    }

    .qr-status {
        font-size: 8px !important;
        margin-bottom: 5px !important;
    }

    /* Print button — its own row, below the feedback card */
    .print-button {
        grid-column: 2 !important;
        grid-row: 4 !important;

        width: 100% !important;
        max-width: none !important;
        height: 40px !important;
        margin: 0 !important;

        padding: 8px !important;
        font-size: 15px !important;

        z-index: 5 !important;
    }

    /* Feedback */
    .feedback-card {
        grid-column: 2 !important;
        grid-row: 3 !important;
        width: 100% !important;
        height: 280px !important;
        min-height: 0 !important;
        padding: 14px 22px !important;
        border-radius: 22px !important;
        overflow: hidden !important;
        justify-content: center !important;
        z-index: 5 !important;
    }

    .feedback-title {
        font-size: 19px !important;
        margin-bottom: 2px !important;
    }

    .feedback-subtitle {
        font-size: 9px !important;
        margin-bottom: 5px !important;
    }

    .stars {
        gap: 4px !important;
        margin-bottom: 5px !important;
    }

    .star {
        font-size: 24px !important;
    }

    .quick-feedback {
        gap: 5px !important;
        margin-bottom: 6px !important;
        flex-wrap: nowrap !important;
    }

    .feedback-option {
        padding: 5px 10px !important;
        font-size: 9px !important;
        white-space: nowrap !important;
    }

    .comment {
        height: 48px !important;
        min-height: 48px !important;
        padding: 8px 10px !important;
        font-size: 10px !important;
        border-radius: 10px !important;
    }

    .comment-count {
        font-size: 7px !important;
        margin-top: 1px !important;
    }

    .submit-feedback {
        margin-top: 5px !important;
        padding: 8px 22px !important;
        font-size: 9px !important;
    }

    .success-message {
        margin-top: 3px !important;
        font-size: 9px !important;
    }

    /* New session */
    .new-session {
        grid-column: 2 !important;
        grid-row: 5 !important;
        width: 100% !important;
        height: 40px !important;
        margin: 0 !important;
        z-index: 5 !important;
    }

    .new-session-button {
        width: 100% !important;
        height: 40px !important;
        padding: 8px !important;
        font-size: 15px !important;
    }

}

    </style>

</head>


<body>


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


<div class="result-page">


    <!-- =====================================================
         HEADER
    ====================================================== -->

    <header class="header">

        <div style="display: flex; align-items: center; gap: 14px;">

            <div class="logo">

                <span class="logo-dot"></span>

                RupaVue

            </div>

        </div>

    </header>



    <!-- =====================================================
         PHOTO + QR
    ====================================================== -->

    <section class="photo-qr-section">


        <!-- GENERATED PHOTO -->

        <div class="result-frame">

            <img
                id="resultImage"
                src=""
                alt="RupaVue AI generated photo"
                style="display: none;"
            >


            <div
                class="placeholder"
                id="placeholder"
            >

                <div class="placeholder-icon">
                    ✨
                </div>

                <p>
                    Generated photo
                </p>

            </div>

        </div>



        <!-- QR CODE -->

        <div class="qr-card">

            <h2 class="qr-title">

                Scan to Download

            </h2>


            <p class="qr-description">

                Point your phone camera at
                the QR code to save your
                high-resolution photo.

            </p>


            <div class="qr-container">

                <div id="qrCode"></div>

            </div>


            <div
                class="qr-status"
                id="qrStatus"
            >

                Preparing QR code...

            </div>

        </div>

    </section>



    <!-- =====================================================
         FEEDBACK
    ====================================================== -->

    <section class="feedback-card">


        <h2 class="feedback-title">

            Share your thoughts

        </h2>


        <p class="feedback-subtitle">

            We'd love to hear what you think!

        </p>



        <!-- STAR RATING -->

        <div
            class="stars"
            id="stars"
        >

            <button
                type="button"
                class="star"
                data-rating="1"
            >
                ☆
            </button>


            <button
                type="button"
                class="star"
                data-rating="2"
            >
                ☆
            </button>


            <button
                type="button"
                class="star"
                data-rating="3"
            >
                ☆
            </button>


            <button
                type="button"
                class="star"
                data-rating="4"
            >
                ☆
            </button>


            <button
                type="button"
                class="star"
                data-rating="5"
            >
                ☆
            </button>

        </div>



        <!-- QUICK FEEDBACK -->

        <div
            class="quick-feedback"
            id="quickFeedback"
        >

            <button
                type="button"
                class="feedback-option"
                data-feedback="Amazing!"
            >
                😍 Amazing!
            </button>


            <button
                type="button"
                class="feedback-option"
                data-feedback="Love it!"
            >
                ❤️ Love it!
            </button>


            <button
                type="button"
                class="feedback-option"
                data-feedback="So cool!"
            >
                😎 So cool!
            </button>


            <button
                type="button"
                class="feedback-option"
                data-feedback="Good"
            >
                👍 Good
            </button>


            <button
                type="button"
                class="feedback-option"
                data-feedback="Not bad"
            >
                😐 Not bad
            </button>

        </div>



        <!-- COMMENT -->

        <textarea
            class="comment"
            id="comment"
            maxlength="200"
            placeholder="Write a comment (optional)..."
        ></textarea>


        <div
            class="comment-count"
            id="commentCount"
        >
            0/200
        </div>



        <!-- SUBMIT -->

        <button
            type="button"
            class="submit-feedback"
            id="submitFeedback"
        >

            Submit Feedback

        </button>


        <div
            class="success-message"
            id="successMessage"
        >

            Thank you for your feedback! ❤️

        </div>

    </section>


    <!-- =====================================================
         PRINT PHOTO
    ====================================================== -->

    <button
        type="button"
        class="print-button"
        id="printButton"
    >

        🖨️ Print Photo

    </button>


    <!-- =====================================================
         NEW SESSION
    ====================================================== -->

    <div class="new-session">

        <button
            type="button"
            class="new-session-button"
            id="newSessionButton"
        >

            ↻ Start New Session

        </button>

    </div>


</div>



<!-- =========================================================
     JAVASCRIPT
========================================================= -->

<script>

    /*
    |--------------------------------------------------------------------------
    | GET STORED PHOTO
    |--------------------------------------------------------------------------
    */

    const generatedPhoto =
        sessionStorage.getItem(
            'rupavueGeneratedPhoto'
        );


    const selectedTheme =
        sessionStorage.getItem(
            'rupavueThemeName'
        );


    const generatedImageId =
        sessionStorage.getItem(
            'rupavueGeneratedImageId'
        );


    /*
    |--------------------------------------------------------------------------
    | ELEMENTS
    |--------------------------------------------------------------------------
    */

    const resultImage =
        document.getElementById(
            'resultImage'
        );


    const placeholder =
        document.getElementById(
            'placeholder'
        );


    const qrCode =
        document.getElementById(
            'qrCode'
        );


    const qrStatus =
        document.getElementById(
            'qrStatus'
        );


    /*
    |--------------------------------------------------------------------------
    | DISPLAY GENERATED PHOTO
    |--------------------------------------------------------------------------
    */

    if (generatedPhoto) {

        resultImage.src =
            generatedPhoto;


        resultImage.style.display =
            'block';


        placeholder.style.display =
            'none';

    }


    /*
    |--------------------------------------------------------------------------
    | GENERATE QR CODE
    |--------------------------------------------------------------------------
    */

    function generateQRCode() {

        if (!generatedPhoto) {

            qrStatus.textContent =
                'No generated photo found.';

            return;

        }


        try {

            qrCode.innerHTML = '';


            /*
             * Convert relative image URL
             * into a complete URL.
             */

            const imageUrl =
                new URL(
                    generatedPhoto,
                    window.location.origin
                ).href;


            new QRCode(
                qrCode,
                {

                    text: imageUrl,

                    width: 220,

                    height: 220,

                    colorDark: '#003f42',

                    colorLight: '#ffffff',

                    correctLevel:
                        QRCode.CorrectLevel.H

                }
            );


            qrStatus.textContent =
                'Scan with your phone to save your photo.';


        } catch (error) {

            console.error(
                'QR Code Error:',
                error
            );


            qrStatus.textContent =
                'Unable to create QR code.';

        }

    }


    generateQRCode();



    /*
    |--------------------------------------------------------------------------
    | PRINT PHOTO
    |--------------------------------------------------------------------------
    */

    const printButton =
        document.getElementById(
            'printButton'
        );


    printButton.addEventListener(
        'click',
        function () {

            if (!generatedPhoto) {

                alert(
                    'No generated photo is available.'
                );

                return;

            }


            const printWindow =
                window.open(
                    '',
                    '_blank'
                );


            if (!printWindow) {

                alert(
                    'Please allow pop-ups to print the photo.'
                );

                return;

            }


            /*
             * Build the print document with DOM APIs
             * rather than a literal HTML string, so the
             * page's own source never contains text that
             * looks like head/body/html tags.
             */

            const printDoc =
                printWindow.document;

            printDoc.title =
                'RupaVue Photo';


            const printStyle =
                printDoc.createElement('style');

            printStyle.textContent =
                '@page { size: auto; margin: 0; }' +
                'html, body { margin: 0; padding: 0; width: 100%; min-height: 100%; display: flex; justify-content: center; align-items: center; }' +
                'img { width: 2in; height: 3in; object-fit: cover; display: block; }';

            printDoc.head.appendChild(
                printStyle
            );


            const printImage =
                printDoc.createElement('img');

            printImage.alt =
                'RupaVue Photo';

            printImage.onload =
                function () {

                    printWindow.focus();

                    printWindow.print();

                    printWindow.close();

                };

            printImage.onerror =
                function () {

                    printWindow.close();

                    alert(
                        'Unable to load the photo for printing.'
                    );

                };

            printImage.src =
                generatedPhoto;

            printDoc.body.appendChild(
                printImage
            );

        }
    );



    /*
    |--------------------------------------------------------------------------
    | STAR RATING
    |--------------------------------------------------------------------------
    */

    let selectedRating = 0;


    const stars =
        document.querySelectorAll(
            '.star'
        );


    stars.forEach(
        function (star) {

            star.addEventListener(
                'click',
                function () {

                    selectedRating =
                        Number(
                            this.dataset.rating
                        );


                    stars.forEach(
                        function (item) {

                            const rating =
                                Number(
                                    item.dataset.rating
                                );


                            if (
                                rating <=
                                selectedRating
                            ) {

                                item.textContent =
                                    '★';

                                item.classList.add(
                                    'selected'
                                );

                            } else {

                                item.textContent =
                                    '☆';

                                item.classList.remove(
                                    'selected'
                                );

                            }

                        }
                    );

                }
            );

        }
    );



    /*
    |--------------------------------------------------------------------------
    | QUICK FEEDBACK
    |--------------------------------------------------------------------------
    */

    let selectedFeedback = '';


    const feedbackOptions =
        document.querySelectorAll(
            '.feedback-option'
        );


    feedbackOptions.forEach(
        function (option) {

            option.addEventListener(
                'click',
                function () {

                    feedbackOptions.forEach(
                        function (item) {

                            item.classList.remove(
                                'selected'
                            );

                        }
                    );


                    this.classList.add(
                        'selected'
                    );


                    selectedFeedback =
                        this.dataset.feedback;

                }
            );

        }
    );



    /*
    |--------------------------------------------------------------------------
    | COMMENT COUNTER
    |--------------------------------------------------------------------------
    */

    const comment =
        document.getElementById(
            'comment'
        );


    const commentCount =
        document.getElementById(
            'commentCount'
        );


    comment.addEventListener(
        'input',
        function () {

            commentCount.textContent =
                this.value.length +
                '/200';

        }
    );



    /*
    |--------------------------------------------------------------------------
    | SUBMIT FEEDBACK
    |--------------------------------------------------------------------------
    */

    const submitFeedback =
        document.getElementById(
            'submitFeedback'
        );


    const successMessage =
        document.getElementById(
            'successMessage'
        );


    submitFeedback.addEventListener(
        'click',
        async function () {

            if (!selectedRating) {

                alert(
                    'Please select a star rating first.'
                );

                return;

            }


            if (!generatedImageId) {

                alert(
                    'Feedback is not available for this photo.'
                );

                return;

            }


            try {

                submitFeedback.disabled =
                    true;


                submitFeedback.textContent =
                    'Submitting...';


                const response =
                    await fetch(
                        "{{ route('photobooth.feedback.store') }}",
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

                            body:
                                JSON.stringify({

                                    generated_image_id:
                                        Number(generatedImageId),

                                    rating:
                                        selectedRating,

                                    feedback:
                                        selectedFeedback,

                                    comment:
                                        comment.value,

                                    theme:
                                        selectedTheme

                                })

                        }
                    );


                if (!response.ok) {

                    throw new Error(
                        'Failed to submit feedback.'
                    );

                }


                submitFeedback.style.display =
                    'none';


                successMessage.style.display =
                    'block';


            } catch (error) {

                console.error(
                    'Feedback error:',
                    error
                );


                submitFeedback.disabled =
                    false;


                submitFeedback.textContent =
                    'Submit Feedback';


                alert(
                    'Unable to submit feedback. Please try again.'
                );

            }

        }
    );



    /*
    |--------------------------------------------------------------------------
    | START NEW SESSION
    |--------------------------------------------------------------------------
    */

    const newSessionButton =
        document.getElementById(
            'newSessionButton'
        );


    newSessionButton.addEventListener(
        'click',
        function () {

            sessionStorage.removeItem(
                'rupavueCapturedPhoto'
            );


            sessionStorage.removeItem(
                'rupavueGeneratedPhoto'
            );


            sessionStorage.removeItem(
                'rupavueGeneratedImageId'
            );


            sessionStorage.removeItem(
                'rupavueOriginalPhoto'
            );


            sessionStorage.removeItem(
                'rupavueThemeId'
            );


            sessionStorage.removeItem(
                'rupavueThemeName'
            );


            window.location.href =
                "{{ route('home') }}";

        }
    );

</script>


</body>

</html>
