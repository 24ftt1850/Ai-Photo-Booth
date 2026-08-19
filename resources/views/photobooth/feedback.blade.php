<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>RUPAVUE — Feedback</title>

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
            min-height: 100vh;

            background: #050505;
            color: #fff;

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

            padding: 30px;
        }

        .feedback-container {
            width: min(650px, 100%);

            text-align: center;
        }

        .logo {
            margin-bottom: 60px;

            font-size: 14px;
            letter-spacing: 0.18em;
        }

        .label {
            margin-bottom: 15px;

            color: #666;

            font-size: 9px;
            letter-spacing: 0.15em;
        }

        h1 {
            margin: 0;

            font-size:
                clamp(32px, 6vw, 56px);

            font-weight: 300;
            line-height: 1.05;
        }

        .description {
            margin:
                22px auto 0;

            max-width: 430px;

            color: #777;

            font-size: 10px;
            line-height: 1.8;
        }

        /* =====================================================
           RATING
        ====================================================== */

        .rating-section {
            margin-top: 50px;
        }

        .rating-label {
            margin-bottom: 18px;

            color: #777;

            font-size: 9px;
            letter-spacing: 0.08em;
        }

        .stars {
            display: flex;

            justify-content: center;

            gap: 10px;
        }

        .star {
            width: 48px;
            height: 48px;

            display: flex;
            align-items: center;
            justify-content: center;

            border: 1px solid #2b2b2b;
            border-radius: 50%;

            background: #101010;

            color: #444;

            font-size: 20px;

            cursor: pointer;

            transition:
                0.2s ease;
        }

        .star:hover {
            border-color: #693cff;
            color: #693cff;

            transform:
                translateY(-3px);
        }

        .star.active {
            border-color: #693cff;

            background:
                rgba(105, 60, 255, 0.12);

            color: #8b6cff;
        }

        .rating-error {
            margin-top: 12px;

            color: #ff6b6b;

            font-size: 9px;

            display: none;
        }

        /* =====================================================
           COMMENT
        ====================================================== */

        .comment-section {
            margin-top: 45px;

            text-align: left;
        }

        .comment-label {
            display: block;

            margin-bottom: 10px;

            color: #777;

            font-size: 9px;
            letter-spacing: 0.08em;
        }

        textarea {
            width: 100%;

            min-height: 130px;

            padding: 16px;

            resize: vertical;

            border:
                1px solid #242424;

            border-radius: 3px;

            outline: none;

            background: #101010;

            color: #fff;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            font-size: 10px;

            line-height: 1.7;

            transition:
                0.2s ease;
        }

        textarea::placeholder {
            color: #444;
        }

        textarea:focus {
            border-color:
                #693cff;
        }

        /* =====================================================
           SUBMIT
        ====================================================== */

        .submit-area {
            margin-top: 35px;

            display: flex;

            justify-content: center;
        }

        .submit-button {
            display: inline-flex;

            align-items: center;

            gap: 12px;

            padding: 0;

            border: none;

            background: transparent;

            color: #777;

            font-size: 42px;

            font-weight: 300;

            cursor: pointer;

            transition:
                0.25s ease;
        }

        .submit-button:hover {
            color: #fff;

            transform:
                translateX(5px);
        }

        .submit-arrow {
            width: 30px;
            height: 30px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: #693cff;

            color: #fff;

            font-size: 12px;
        }

        .submit-button:disabled {
            opacity: 0.5;

            cursor:
                not-allowed;

            transform: none;
        }

        /* =====================================================
           BACK
        ====================================================== */

        .back-button {
            display: inline-flex;

            align-items: center;

            gap: 10px;

            margin-top: 40px;

            color: #666;

            font-size: 9px;

            letter-spacing: 0.1em;

            transition:
                0.25s ease;
        }

        .back-button:hover {
            color: #fff;

            transform:
                translateX(-4px);
        }

        .back-arrow {
            width: 28px;
            height: 28px;

            display: flex;
            align-items: center;
            justify-content: center;

            border:
                1px solid #333;

            border-radius: 50%;

            font-size: 12px;
        }

        /* =====================================================
           SUCCESS
        ====================================================== */

        .success {
            display: none;
        }

        .success-icon {
            width: 70px;
            height: 70px;

            margin:
                0 auto 25px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background:
                rgba(105, 60, 255, 0.15);

            color: #8b6cff;

            font-size: 28px;
        }

        .success h2 {
            margin: 0;

            font-size: 28px;

            font-weight: 300;
        }

        .success p {
            margin-top: 15px;

            color: #777;

            font-size: 10px;
        }

        /* =====================================================
           MOBILE
        ====================================================== */

        @media (max-width: 600px) {

            .page {
                padding: 25px 18px;
            }

            .logo {
                margin-bottom: 45px;
            }

            .stars {
                gap: 6px;
            }

            .star {
                width: 43px;
                height: 43px;
            }

            .submit-button {
                font-size: 34px;
            }

        }

    </style>

</head>


<body>

<div class="page">

    <div class="feedback-container">


        <!-- =================================================
             FEEDBACK FORM
        ================================================== -->

        <div id="feedbackForm">

            <div class="logo">
                RUPAVUE
            </div>


            <div class="label">
                YOUR EXPERIENCE
            </div>


            <h1>
                HOW WAS<br>
                YOUR EXPERIENCE?
            </h1>


            <p class="description">

                We'd love to know what you think
                about your AI photobooth experience.

            </p>


            <!-- Rating -->

            <div class="rating-section">

                <div class="rating-label">
                    RATE YOUR EXPERIENCE
                </div>


                <div class="stars">

                    <button
                        type="button"
                        class="star"
                        data-rating="1"
                    >
                        ★
                    </button>

                    <button
                        type="button"
                        class="star"
                        data-rating="2"
                    >
                        ★
                    </button>

                    <button
                        type="button"
                        class="star"
                        data-rating="3"
                    >
                        ★
                    </button>

                    <button
                        type="button"
                        class="star"
                        data-rating="4"
                    >
                        ★
                    </button>

                    <button
                        type="button"
                        class="star"
                        data-rating="5"
                    >
                        ★
                    </button>

                </div>


                <div
                    id="ratingError"
                    class="rating-error"
                >
                    Please select a rating.
                </div>

            </div>


            <!-- Comment -->

            <div class="comment-section">

                <label
                    for="comment"
                    class="comment-label"
                >
                    COMMENT
                    <span style="color:#444;">
                        (OPTIONAL)
                    </span>
                </label>


                <textarea
                    id="comment"
                    maxlength="1000"
                    placeholder="Tell us what you think..."
                ></textarea>

            </div>


            <!-- Submit -->

            <div class="submit-area">

                <button
                    id="submitButton"
                    class="submit-button"
                    type="button"
                >

                    <span>
                        SUBMIT
                    </span>

                    <span class="submit-arrow">
                        →
                    </span>

                </button>

            </div>


            <!-- Back -->

            <a
                href="{{ route('photobooth.result') }}"
                class="back-button"
            >

                <span class="back-arrow">
                    ←
                </span>

                <span>
                    BACK
                </span>

            </a>

        </div>


        <!-- =================================================
             SUCCESS MESSAGE
        ================================================== -->

        <div
            id="success"
            class="success"
        >

            <div class="success-icon">
                ✓
            </div>


            <h2>
                THANK YOU
            </h2>


            <p>
                Your feedback has been received.
            </p>

        </div>

    </div>

</div>


<script>

/*
|--------------------------------------------------------------------------
| Elements
|--------------------------------------------------------------------------
*/

const stars =
    document.querySelectorAll(
        '.star'
    );

const ratingError =
    document.getElementById(
        'ratingError'
    );

const comment =
    document.getElementById(
        'comment'
    );

const submitButton =
    document.getElementById(
        'submitButton'
    );

const feedbackForm =
    document.getElementById(
        'feedbackForm'
    );

const success =
    document.getElementById(
        'success'
    );


/*
|--------------------------------------------------------------------------
| Selected rating
|--------------------------------------------------------------------------
*/

let selectedRating =
    0;


/*
|--------------------------------------------------------------------------
| Select rating
|--------------------------------------------------------------------------
*/

stars.forEach(
    star => {

        star.addEventListener(
            'click',
            () => {

                selectedRating =
                    Number(
                        star.dataset.rating
                    );


                stars.forEach(
                    item => {

                        const rating =
                            Number(
                                item.dataset.rating
                            );


                        item.classList.toggle(
                            'active',
                            rating <=
                                selectedRating
                        );

                    }
                );


                ratingError.style.display =
                    'none';

            }
        );

    }
);


/*
|--------------------------------------------------------------------------
| Submit feedback
|--------------------------------------------------------------------------
*/

submitButton.addEventListener(
    'click',
    async () => {


        /*
        |--------------------------------------------------------------------------
        | Rating required
        |--------------------------------------------------------------------------
        */

        if (
            selectedRating === 0
        ) {

            ratingError.style.display =
                'block';

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | Disable button
        |--------------------------------------------------------------------------
        */

        submitButton.disabled =
            true;


        submitButton.querySelector(
            'span:first-child'
        ).textContent =
            'SENDING...';


        /*
        |--------------------------------------------------------------------------
        | Get session information
        |--------------------------------------------------------------------------
        */

        const theme =
            sessionStorage.getItem(
                'generated_theme'
            );


        /*
        |--------------------------------------------------------------------------
        | Send feedback
        |--------------------------------------------------------------------------
        */

        try {

            const response =
                await fetch(

                    "{{ route('photobooth.feedback.store') }}",

                    {

                        method:
                            'POST',

                        headers: {

                            'Content-Type':
                                'application/json',

                            'X-CSRF-TOKEN':
                                "{{ csrf_token() }}",

                            'Accept':
                                'application/json'

                        },

                        body:
                            JSON.stringify({

                                rating:
                                    selectedRating,

                                comment:
                                    comment.value.trim(),

                                theme:
                                    theme

                            })

                    }

                );


            if (
                !response.ok
            ) {

                throw new Error(
                    'Unable to submit feedback.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Show success
            |--------------------------------------------------------------------------
            */

            feedbackForm.style.display =
                'none';

            success.style.display =
                'block';


            /*
            |--------------------------------------------------------------------------
            | Clear previous session
            |--------------------------------------------------------------------------
            */

            sessionStorage.removeItem(
                'photobooth_photo'
            );

            sessionStorage.removeItem(
                'selected_scene'
            );

            sessionStorage.removeItem(
                'generated_image'
            );

            sessionStorage.removeItem(
                'generated_theme'
            );


            /*
            |--------------------------------------------------------------------------
            | Return to take photo
            |--------------------------------------------------------------------------
            */

            setTimeout(
                () => {

                    window.location.href =
                        "{{ route('photobooth.create') }}";

                },
                1500
            );


        } catch (error) {

            console.error(
                error
            );


            alert(
                'Unable to submit feedback. Please try again.'
            );


            submitButton.disabled =
                false;


            submitButton.querySelector(
                'span:first-child'
            ).textContent =
                'SUBMIT';

        }

    }
);

</script>

</body>

</html>