<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Choose Theme - AI Photo Booth</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #0f172a;
            color: white;
        }

        .page {
            min-height: 100vh;
            padding: 50px 20px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            font-size: 38px;
            margin: 0 0 12px;
        }

        .header p {
            color: #94a3b8;
            font-size: 16px;
        }

        /* Photo */

        .photo-preview {
            width: 260px;
            height: 260px;
            margin: 0 auto 45px;
            border-radius: 20px;
            overflow: hidden;
            background: #020617;
            border: 1px solid #334155;
        }

        .photo-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Theme section */

        .section-title {
            text-align: center;
            font-size: 22px;
            margin-bottom: 25px;
        }

        .themes {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .theme {
            position: relative;
            background: #1e293b;
            border: 2px solid transparent;
            border-radius: 20px;
            overflow: hidden;
            cursor: pointer;
            transition: 0.25s;
        }

        .theme:hover {
            transform: translateY(-6px);
            border-color: #64748b;
        }

        .theme.selected {
            border-color: #8b5cf6;
            box-shadow: 0 0 30px rgba(139, 92, 246, 0.35);
        }

        .theme-image {
            height: 260px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 90px;
        }

        .theme-default {
            background:
                linear-gradient(
                    135deg,
                    #172554,
                    #7c3aed
                );
        }

        .theme-image {
            background-size: cover;
            background-position: center;
        }

        .empty-themes {
            grid-column: 1 / -1;
            text-align: center;
            color: #94a3b8;
            padding: 40px 20px;
        }

        .theme-info {
            padding: 20px;
            text-align: center;
        }

        .theme-info h3 {
            margin: 0 0 8px;
            font-size: 21px;
        }

        .theme-info p {
            margin: 0;
            color: #94a3b8;
            font-size: 14px;
        }

        /* Check */

        .check {
            position: absolute;
            top: 15px;
            right: 15px;

            width: 35px;
            height: 35px;

            border-radius: 50%;

            background: #8b5cf6;

            display: none;
            align-items: center;
            justify-content: center;

            font-weight: bold;
        }

        .theme.selected .check {
            display: flex;
        }

        /* Buttons */

        .buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 45px;
        }

        button {
            border: none;
            border-radius: 12px;
            padding: 14px 28px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .back {
            background: #334155;
            color: white;
        }

        .generate {
            background: #8b5cf6;
            color: white;
        }

        .generate:hover {
            background: #7c3aed;
        }

        .generate:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Mobile */

        @media (max-width: 800px) {

            .themes {
                grid-template-columns: 1fr;
                max-width: 450px;
                margin: auto;
            }

            .theme-image {
                height: 220px;
            }

        }

    </style>
</head>

<body>

<div class="page">

    <div class="container">

        <!-- Header -->

        <div class="header">

            <h1>Choose Your Theme</h1>

            <p>
                Select a theme for your AI-generated portrait.
            </p>

        </div>


        <!-- Selected Photo -->

        <div class="photo-preview">

            <img
                id="selectedPhoto"
                alt="Your selected photo"
            >

        </div>


        <!-- Theme -->

        <h2 class="section-title">
            Select a Theme
        </h2>


        <div class="themes">

            @forelse ($themes as $theme)

                <div
                    class="theme"
                    data-scene="{{ $theme->slug }}"
                    data-name="{{ $theme->name }}"
                    data-description="{{ $theme->description }}"
                    data-prompt="{{ $theme->prompt }}"
                >

                    <div
                        class="theme-image {{ $theme->thumbnail ? '' : 'theme-default' }}"
                        @if ($theme->thumbnail)
                            style="background-image: url('{{ $theme->thumbnail }}');"
                        @endif
                    >
                        @unless ($theme->thumbnail)
                            ✦
                        @endunless
                    </div>

                    <div class="theme-info">

                        <h3>{{ $theme->name }}</h3>

                        <p>
                            {{ $theme->description }}
                        </p>

                    </div>

                    <div class="check">
                        ✓
                    </div>

                </div>

            @empty

                <div class="empty-themes">
                    No themes are available right now. Please check back later.
                </div>

            @endforelse

        </div>


        <!-- Buttons -->

        <div class="buttons">

            <button
                class="back"
                type="button"
                onclick="history.back()"
            >
                ← Back
            </button>

            <button
                id="generateButton"
                class="generate"
                type="button"
                disabled
            >
                ✨ Generate AI Portrait
            </button>

        </div>

    </div>

</div>


<script>

const photo =
    sessionStorage.getItem('photobooth_photo');

const selectedPhoto =
    document.getElementById('selectedPhoto');

const themes =
    document.querySelectorAll('.theme');

const generateButton =
    document.getElementById('generateButton');

let selectedTheme = null;


/*
|--------------------------------------------------------------------------
| Display photo
|--------------------------------------------------------------------------
*/

if (photo) {

    selectedPhoto.src = photo;

} else {

    selectedPhoto.alt =
        'No photo selected';

}


/*
|--------------------------------------------------------------------------
| Select theme
|--------------------------------------------------------------------------
*/

themes.forEach(theme => {

    theme.addEventListener('click', () => {

        themes.forEach(item => {

            item.classList.remove('selected');

        });

        theme.classList.add('selected');

        selectedTheme = {

            slug: theme.dataset.scene,

            name: theme.dataset.name,

            description: theme.dataset.description,

            prompt: theme.dataset.prompt

        };

        generateButton.disabled = false;

    });

});


/*
|--------------------------------------------------------------------------
| Generate button
|--------------------------------------------------------------------------
*/

generateButton.addEventListener('click', () => {

    if (!selectedTheme) {
        return;
    }

    sessionStorage.setItem(
        'selected_scene',
        JSON.stringify(selectedTheme)
    );

    window.location.href =
        "{{ route('photobooth.generate') }}";

});

</script>

</body>
</html>