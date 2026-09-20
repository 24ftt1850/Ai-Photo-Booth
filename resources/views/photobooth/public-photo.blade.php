<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>RUPAVUE Photo</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            padding: 30px;

            background: #07142f;
            color: white;

            font-family: Arial, sans-serif;

            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 100%;
            max-width: 700px;
            text-align: center;
        }

        .logo {
            font-size: 30px;
            font-weight: 800;
            letter-spacing: 3px;
            margin-bottom: 25px;
        }

        .photo-card {
            padding: 15px;

            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);

            border-radius: 24px;
        }

        .photo-card img {
            width: 100%;
            max-height: 75vh;

            object-fit: contain;
            display: block;

            border-radius: 16px;
        }

        .download-btn {
            display: inline-block;

            margin-top: 22px;
            padding: 14px 30px;

            background: #2563eb;
            color: white;

            text-decoration: none;
            font-weight: 700;

            border-radius: 12px;
        }

        .uid {
            margin-top: 15px;
            opacity: 0.6;
            font-size: 13px;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="logo">
        RUPAVUE
    </div>

    <div class="photo-card">

        <img
            src="{{ route('public.photo.download', $image->public_token) }}"
            alt="RUPAVUE generated photo"
        >

    </div>

    <a
        href="{{ route('public.photo.download', $image->public_token) }}"
        class="download-btn"
    >
        Download Photo
    </a>

    <div class="uid">
        {{ $image->image_uid }}
    </div>

</div>

</body>

</html>