<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Your AI Portrait — RUPAVUE</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;

            background: #050505;

            color: white;

            font-family:
                Arial,
                Helvetica,
                sans-serif;
        }

        .page {
            min-height: 100vh;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 40px 20px;
        }

        .container {
            width: 100%;

            max-width: 760px;

            text-align: center;
        }

        /* =====================================================
           HEADER
        ====================================================== */

        .logo {
            margin-bottom: 45px;

            font-size: 14px;

            letter-spacing: 0.18em;
        }

        .label {
            margin-bottom: 12px;

            color: #666;

            font-size: 9px;

            letter-spacing: 0.15em;
        }

        h1 {
            margin: 0;

            font-size:
                clamp(32px, 6vw, 52px);

            font-weight: 300;
        }

        .subtitle {
            margin:
                15px 0 35px;

            color: #777;

            font-size: 10px;

            line-height: 1.7;
        }

        /* =====================================================
           IMAGE
        ====================================================== */

        .image-container {
            position: relative;

            padding: 8px;

            background: #101010;

            border:
                1px solid #202020;

            border-radius: 4px;
        }

        .image-container img {
            width: 100%;

            display: block;

            border-radius: 2px;

            background: #111;
        }

        /* =====================================================
           BUTTONS
        ====================================================== */

        .buttons {
            display: flex;

            justify-content: center;

            align-items: center;

            gap: 14px;

            margin-top: 30px;

            flex-wrap: wrap;
        }

        .button {
            display: inline-flex;

            align-items: center;

            justify-content: center;

            min-height: 44px;

            padding:
                0 20px;

            border-radius: 3px;

            border:
                1px solid #292929;

            background: #111;

            color: #aaa;

            text-decoration: none;

            font-size: 9px;

            letter-spacing: 0.08em;

            transition:
                0.25s ease;
        }

        .button:hover {
            color: white;

            border-color: #555;

            transform:
                translateY(-2px);
        }

        .download {
            background: #693cff;

            border-color: #693cff;

            color: white;
        }

        .download:hover {
            background: #7c55ff;

            border-color: #7c55ff;
        }

        .feedback {
            background: transparent;

            color: #aaa;
        }

        .again {
            background: #111;
        }

        /* =====================================================
           FOOTER
        ====================================================== */

        .footer-text {
            margin-top: 35px;

            color: #444;

            font-size: 8px;

            letter-spacing: 0.08em;
        }

        /* =====================================================
           MOBILE
        ====================================================== */

        @media (max-width: 600px) {

            .page {
                padding:
                    30px 16px;
            }

            .logo {
                margin-bottom:
                    35px;
            }

            .buttons {
                flex-direction:
                    column;
            }

            .button {
                width:
                    100%;
            }

        }

    </style>

</head>


<body>

<div class="page">

    <div class="container">


        <!-- =================================================
             HEADER
        ================================================== -->

        <div class="logo">
            RUPAVUE
        </div>


        <div class="label">
            AI PORTRAIT
        </div>


        <h1>
            YOUR PORTRAIT
        </h1>


        <p class="subtitle">
            Your AI-generated portrait is ready.
        </p>


        <!-- =================================================
             RESULT IMAGE
        ================================================== -->

        <div class="image-container">

            <img
                id="resultImage"
                alt="AI Generated Portrait"
            >

        </div>


        <!-- =================================================
             BUTTONS
        ================================================== -->

        <div class="buttons">


            <!-- DOWNLOAD -->

            <a
                id="downloadButton"
                class="button download"
                download="rupavue-ai-portrait.jpg"
            >
                ↓ &nbsp; DOWNLOAD
            </a>


            <!-- FEEDBACK -->

            <a
                href="{{ route('photobooth.feedback') }}"
                class="button feedback"
            >
                FINISH &nbsp; →
            </a>


            <!-- GENERATE AGAIN -->

            <a
                href="{{ route('photobooth.scene') }}"
                class="button again"
            >
                ↻ &nbsp; GENERATE AGAIN
            </a>


        </div>


        <div class="footer-text">
            THANK YOU FOR USING RUPAVUE
        </div>

    </div>

</div>


<script>

/*
|--------------------------------------------------------------------------
| Get generated image
|--------------------------------------------------------------------------
*/

const imageUrl =
    sessionStorage.getItem(
        'generated_image'
    );


const image =
    document.getElementById(
        'resultImage'
    );


const download =
    document.getElementById(
        'downloadButton'
    );


/*
|--------------------------------------------------------------------------
| Display generated image
|--------------------------------------------------------------------------
*/

if (!imageUrl) {

    image.alt =
        'Generated image not found.';

} else {

    image.src =
        imageUrl;

    download.href =
        imageUrl;

}


/*
|--------------------------------------------------------------------------
| Prevent broken download button
|--------------------------------------------------------------------------
*/

if (!imageUrl) {

    download.style.display =
        'none';

}

</script>

</body>

</html>