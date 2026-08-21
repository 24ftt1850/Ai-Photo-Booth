<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>RUPAVUE — Admin Login</title>

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


        .login-container {
            width: min(
                430px,
                100%
            );

            text-align: center;
        }


        /* =====================================================
           LOGO
        ====================================================== */

        .logo {
            margin-bottom: 55px;

            font-size: 14px;

            letter-spacing: 0.18em;
        }


        .label {
            margin-bottom: 14px;

            color: #666;

            font-size: 9px;

            letter-spacing: 0.15em;
        }


        h1 {
            margin: 0;

            font-size:
                clamp(32px, 6vw, 48px);

            font-weight: 300;
        }


        .description {
            margin:
                18px auto 40px;

            max-width: 350px;

            color: #666;

            font-size: 10px;

            line-height: 1.7;
        }


        /* =====================================================
           FORM
        ====================================================== */

        .form {
            text-align: left;
        }


        .field {
            margin-bottom: 20px;
        }


        .field label {
            display: block;

            margin-bottom: 9px;

            color: #777;

            font-size: 9px;

            letter-spacing: 0.08em;
        }


        .field input {
            width: 100%;

            height: 48px;

            padding:
                0 14px;

            border:
                1px solid #242424;

            border-radius: 3px;

            outline: none;

            background: #101010;

            color: #fff;

            font-size: 12px;

            transition:
                0.2s ease;
        }


        .field input:focus {
            border-color:
                #693cff;
        }


        .field input::placeholder {
            color: #444;
        }


        /* =====================================================
           ERROR
        ====================================================== */

        .error {
            margin-bottom: 20px;

            padding: 12px;

            border:
                1px solid
                rgba(255, 80, 80, 0.25);

            background:
                rgba(255, 80, 80, 0.06);

            color: #ff8585;

            font-size: 9px;

            line-height: 1.5;
        }


        /* =====================================================
           LOGIN BUTTON
        ====================================================== */

        .login-button {
            width: 100%;

            height: 50px;

            border: none;

            border-radius: 3px;

            background: #693cff;

            color: #fff;

            font-size: 10px;

            font-weight: bold;

            letter-spacing: 0.1em;

            cursor: pointer;

            transition:
                0.25s ease;
        }


        .login-button:hover {
            background: #805cff;

            transform:
                translateY(-2px);
        }


        /* =====================================================
           FORGOT PASSWORD
        ====================================================== */

        .forgot {
            display: block;

            margin-top: 22px;

            text-align: center;

            color: #555;

            font-size: 9px;

            text-decoration: none;

            transition:
                0.2s ease;
        }


        .forgot:hover {
            color: #aaa;
        }


        /* =====================================================
           BACK
        ====================================================== */

        .back {
            display: inline-flex;

            align-items: center;

            gap: 10px;

            margin-top: 45px;

            color: #555;

            font-size: 9px;

            letter-spacing: 0.1em;

            text-decoration: none;

            transition:
                0.2s ease;
        }


        .back:hover {
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
           MOBILE
        ====================================================== */

        @media (max-width: 500px) {

            .page {
                padding:
                    25px 18px;
            }

        }

    </style>

</head>


<body>

<div class="page">

    <div class="login-container">


        <!-- LOGO -->

        <div class="logo">
            RUPAVUE
        </div>


        <div class="label">
            ADMINISTRATION
        </div>


        <h1>
            ADMIN LOGIN
        </h1>


        <p class="description">
            Sign in to manage events,
            themes and photobooth analytics.
        </p>


        <!-- ERRORS -->

        @if ($errors->any())

            <div class="error">

                {{ $errors->first() }}

            </div>

        @endif


        <!-- LOGIN FORM -->

        <form
            method="POST"
            action="{{ route('admin.login.submit') }}"
            class="form"
        >

            @csrf


            <!-- EMAIL -->

            <div class="field">

                <label for="email">
                    EMAIL
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="admin@rupavue.com"
                    autocomplete="username"
                    required
                >

            </div>


            <!-- PASSWORD -->

            <div class="field">

                <label for="password">
                    PASSWORD
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter your password"
                    autocomplete="current-password"
                    required
                >

            </div>


            <!-- LOGIN -->

            <button
                type="submit"
                class="login-button"
            >
                LOGIN →
            </button>

        </form>


        <!-- FORGOT -->

        <a
            href="#"
            class="forgot"
            onclick="
                alert(
                    'Password recovery will be configured when the email/database system is connected.'
                );
                return false;
            "
        >
            Forgot password?
        </a>


        <!-- BACK -->

        <a
            href="{{ route('access') }}"
            class="back"
        >

            <span class="back-arrow">
                ←
            </span>

            <span>
                BACK
            </span>

        </a>

    </div>

</div>

</body>

</html>