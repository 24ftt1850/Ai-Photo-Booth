<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>RUPAVUE — AI Photobooth</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <style>
        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            background: #050505;
            color: #f5f5f5;
            font-family: Arial, Helvetica, sans-serif;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        /* =========================================================
           PAGE
        ========================================================= */

        .rupavue-page {
            min-height: 100vh;
            overflow: hidden;
            background: #050505;
        }

        .container {
            width: min(1200px, calc(100% - 72px));
            margin: 0 auto;
        }

        /* =========================================================
           HEADER
        ========================================================= */

        .header {
            height: 74px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
        }

        .header-inner {
            width: min(1200px, calc(100% - 72px));
            margin: 0 auto;

            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 0.18em;
        }

        .nav {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-link {
            padding: 8px 14px;
            font-size: 9px;
            color: #888;
            border-radius: 3px;
            transition: 0.2s ease;
        }

        .nav-link:hover {
            color: white;
            background: #151515;
        }

        .contact-button {
            margin-left: 20px;
            padding: 8px 13px;

            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 3px;

            font-size: 8px;
            color: #ddd;

            transition: 0.2s ease;
        }

        .contact-button:hover {
            background: #fff;
            color: #000;
        }

        /* =========================================================
           HERO
        ========================================================= */

        .hero {
            position: relative;
            padding: 48px 0 80px;
        }

        .hero::before {
            content: "";
            position: absolute;

            width: 300px;
            height: 300px;

            left: 50%;
            top: -100px;

            transform: translateX(-50%);

            border-radius: 50%;

            border: 2px solid rgba(255,255,255,0.025);

            box-shadow:
                0 0 0 30px rgba(255,255,255,0.012),
                0 0 0 60px rgba(255,255,255,0.008);

            pointer-events: none;
        }

        .hero-heading {
            position: relative;
            z-index: 1;

            display: flex;
            justify-content: space-between;
            align-items: flex-end;

            margin-bottom: 34px;
        }

        .hero-small-title {
            font-size: 9px;
            line-height: 1.6;
            color: #777;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .hero-brand {
            font-size: 18px;
            letter-spacing: 0.12em;
        }

        /* =========================================================
           DEMO IMAGE COLLAGE
        ========================================================= */

        .hero-collage {
            display: grid;

            grid-template-columns:
                0.85fr
                1.65fr
                1.15fr
                0.85fr;

            grid-template-rows:
                145px
                145px;

            gap: 5px;
        }

        .demo-image {
            position: relative;
            overflow: hidden;

            background:
                linear-gradient(
                    135deg,
                    #252525,
                    #101010
                );
        }

        .demo-image::after {
            content: "DEMO IMAGE";

            position: absolute;

            left: 50%;
            top: 50%;

            transform:
                translate(-50%, -50%);

            color: rgba(255,255,255,0.2);

            font-size: 8px;
            letter-spacing: 0.15em;
        }

        .demo-1 {
            grid-row: 1 / 3;

            background:
                linear-gradient(
                    145deg,
                    #1b1b1b,
                    #383838
                );
        }

        .demo-2 {
            grid-row: 1 / 3;

            background:
                linear-gradient(
                    135deg,
                    #201b32,
                    #51405f,
                    #151515
                );
        }

        .demo-3 {
            background:
                linear-gradient(
                    135deg,
                    #222,
                    #555
                );
        }

        .demo-4 {
            background:
                linear-gradient(
                    135deg,
                    #111,
                    #353535
                );
        }

        .demo-5 {
            background:
                linear-gradient(
                    135deg,
                    #302514,
                    #5d4928
                );
        }

        .demo-6 {
            background:
                linear-gradient(
                    135deg,
                    #182229,
                    #394e58
                );
        }

        /* =========================================================
           ABOUT
        ========================================================= */

        .about {
            padding: 70px 0 100px;
        }

        .section-label {
            font-size: 8px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            margin-bottom: 4px;
        }

        .section-title {
            margin: 0;
            font-size: 17px;
            font-weight: 400;
            letter-spacing: 0.04em;
        }

        .about-content {
            margin-top: 34px;

            display: grid;

            grid-template-columns:
                1fr
                1fr;

            gap: 70px;

            align-items: start;
        }

        .about-image {
            width: 100%;
            aspect-ratio: 0.82;

            background:
                linear-gradient(
                    145deg,
                    #241d25,
                    #504451,
                    #181818
                );

            position: relative;
            overflow: hidden;
        }

        .about-image::after {
            content: "DEMO IMAGE";

            position: absolute;

            left: 50%;
            top: 50%;

            transform:
                translate(-50%, -50%);

            color: rgba(255,255,255,0.2);

            font-size: 9px;
            letter-spacing: 0.15em;
        }

        .about-copy {
            padding-top: 4px;
        }

        .about-copy h3 {
            margin: 0 0 18px;

            font-size: 13px;
            font-weight: 400;
            letter-spacing: 0.08em;
        }

        .about-copy p {
            margin: 0;

            max-width: 460px;

            color: #777;

            font-size: 10px;
            line-height: 1.9;
        }

        .contact {
            margin-top: 50px;
        }

        .contact-title {
            font-size: 9px;
            letter-spacing: 0.08em;
            margin-bottom: 16px;
        }

        .contact-grid {
            display: grid;

            grid-template-columns:
                1fr
                1fr;

            gap: 25px;

            max-width: 430px;
        }

        .contact-item {
            color: #777;
            font-size: 9px;
            line-height: 1.7;
        }

        .contact-item strong {
            display: block;
            color: #ddd;
            font-weight: 400;
            margin-bottom: 3px;
        }

        /* =========================================================
           START SECTION
        ========================================================= */

        .start-section {
            padding: 20px 0 90px;
        }

        .start-heading {
            font-size: 15px;
            font-weight: 400;
            letter-spacing: 0.04em;
            margin-bottom: 40px;
        }

        .start-content {
            display: grid;

            grid-template-columns:
                1fr
                1fr;

            align-items: center;

            gap: 80px;
        }

        .start-link {
            display: inline-flex;
            align-items: center;
            gap: 12px;

            font-size: 48px;
            font-weight: 300;

            color: #777;

            transition: 0.25s ease;
        }

        .start-link:hover {
            color: #fff;
            transform: translateX(6px);
        }

        .start-arrow {
            width: 28px;
            height: 28px;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #693cff;
            color: #fff;

            font-size: 12px;

            transition: 0.25s ease;
        }

        .start-link:hover .start-arrow {
            transform: translateX(4px);
            background: #805cff;
        }

        /* =========================================================
           START IMAGE GRID
        ========================================================= */

        .start-images {
            display: grid;

            grid-template-columns:
                1fr
                1fr;

            grid-template-rows:
                100px
                100px;

            gap: 4px;
        }

        .start-demo-1 {
            background:
                linear-gradient(
                    135deg,
                    #3e174c,
                    #b83a8d
                );
        }

        .start-demo-2 {
            background:
                linear-gradient(
                    135deg,
                    #242424,
                    #80663e
                );
        }

        .start-demo-3 {
            background:
                linear-gradient(
                    135deg,
                    #1b3145,
                    #40799b
                );
        }

        .start-demo-4 {
            background:
                linear-gradient(
                    135deg,
                    #3c1e1e,
                    #a25d62
                );
        }

        /* =========================================================
           FOOTER
        ========================================================= */

        .footer {
            border-top:
                1px solid
                rgba(255,255,255,0.08);

            padding:
                25px 0;

            color:
                #555;

            font-size:
                8px;

            letter-spacing:
                0.08em;
        }

        .footer-inner {
            display:
                flex;

            justify-content:
                space-between;
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 800px) {

            .container,
            .header-inner {
                width:
                    min(
                        100% - 32px,
                        1200px
                    );
            }

            .nav {
                display: none;
            }

            .hero {
                padding-top:
                    35px;
            }

            .hero-heading {
                align-items:
                    flex-start;

                flex-direction:
                    column;

                gap: 15px;
            }

            .hero-collage {
                grid-template-columns:
                    1fr 1fr;

                grid-template-rows:
                    130px
                    130px
                    130px;
            }

            .demo-1,
            .demo-2 {
                grid-row:
                    auto;
            }

            .about-content,
            .start-content {
                grid-template-columns:
                    1fr;

                gap:
                    35px;
            }

            .start-link {
                font-size:
                    38px;
            }

            .start-images {
                max-width:
                    500px;
            }

        }

        @media (max-width: 480px) {

            .header {
                height:
                    60px;
            }

            .hero-collage {
                grid-template-columns:
                    1fr 1fr;

                grid-template-rows:
                    110px
                    110px
                    110px;
            }

            .about {
                padding:
                    50px 0 70px;
            }

            .start-section {
                padding-bottom:
                    60px;
            }

            .start-link {
                font-size:
                    32px;
            }

        }

    </style>

</head>


<body>

<div class="rupavue-page">


    <!-- =========================================================
         HEADER
    ========================================================== -->

    <header class="header">

        <div class="header-inner">

            <a
                href="/"
                class="logo"
            >
                RUPAVUE
            </a>


            <nav class="nav">

                <a
                    href="#about"
                    class="nav-link"
                >
                    ABOUT
                </a>

                <a
                    href="#about"
                    class="nav-link"
                >
                    INFO
                </a>

                <a
                    href="#start"
                    class="nav-link"
                >
                    START
                </a>

                <a
                    href="#contact"
                    class="contact-button"
                >
                    CONTACT US
                </a>

            </nav>

        </div>

    </header>


    <!-- =========================================================
         HERO
    ========================================================== -->

    <main>

        <section class="hero">

            <div class="container">

                <div class="hero-heading">

                    <div class="hero-small-title">

                        FIRST AI PHOTOBOOTH<br>

                        IN BRUNEI

                    </div>


                    <div class="hero-brand">

                        RUPAVUE

                    </div>

                </div>


                <div class="hero-collage">

                    <div class="demo-image demo-1"></div>

                    <div class="demo-image demo-2"></div>

                    <div class="demo-image demo-3"></div>

                    <div class="demo-image demo-4"></div>

                    <div class="demo-image demo-5"></div>

                    <div class="demo-image demo-6"></div>

                </div>

            </div>

        </section>


        <!-- =====================================================
             ABOUT
        ====================================================== -->

        <section
            id="about"
            class="about"
        >

            <div class="container">

                <div class="section-label">
                    ABOUT
                </div>

                <h2 class="section-title">
                    RUPAVUE
                </h2>


                <div class="about-content">


                    <div class="about-image"></div>


                    <div class="about-copy">

                        <h3>
                            Introduction
                        </h3>

                        <p>
                            RUPAVUE is an AI-powered
                            photobooth experience designed
                            to transform ordinary portraits
                            into creative and immersive
                            visual experiences.
                        </p>

                        <p style="margin-top: 18px;">
                            Capture your moment, choose
                            your world, and let AI create
                            a portrait designed around you.
                        </p>


                        <div
                            id="contact"
                            class="contact"
                        >

                            <div class="contact-title">
                                Contact Information
                            </div>


                            <div class="contact-grid">

                                <div class="contact-item">

                                    <strong>
                                        Email
                                    </strong>

                                    hello@rupavue.com

                                </div>


                                <div class="contact-item">

                                    <strong>
                                        Location
                                    </strong>

                                    Brunei

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        <!-- =====================================================
             START
        ====================================================== -->

        <section
            id="start"
            class="start-section"
        >

            <div class="container">

                <h2 class="start-heading">
                    READY TO IMMERSE TO THE AI WORLD?
                </h2>


                <div class="start-content">


                    <div>

                        <a
                            href="{{ route('access') }}"
                            class="start-link"
                        >

                            <span>
                                START
                            </span>

                            <span class="start-arrow">
                                →
                            </span>

                        </a>

                    </div>


                    <div class="start-images">

                        <div class="demo-image start-demo-1"></div>

                        <div class="demo-image start-demo-2"></div>

                        <div class="demo-image start-demo-3"></div>

                        <div class="demo-image start-demo-4"></div>

                    </div>

                </div>

            </div>

        </section>

    </main>


    <!-- =========================================================
         FOOTER
    ========================================================== -->

    <footer class="footer">

        <div class="container footer-inner">

            <span>
                © {{ date('Y') }} RUPAVUE
            </span>

            <span>
                AI PHOTOBOOTH — BRUNEI
            </span>

        </div>

    </footer>

</div>

</body>

</html>