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

    </style>

</head>


<body>


<div class="result-page">


    <!-- =====================================================
         HEADER
    ====================================================== -->

    <header class="header">

        <div style="display: flex; align-items: center; gap: 14px;">

            <a href="{{ route('home') }}" class="back-link">
                ← Back
            </a>

            <div class="logo">

                <span class="logo-dot"></span>

                RupaVue

            </div>

        </div>


        <div class="ready">

            READY!

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


            <!-- PRINT ONLY -->

            <button
                type="button"
                class="print-button"
                id="printButton"
            >

                🖨️ Print Photo

            </button>

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

                    width: 190,

                    height: 190,

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