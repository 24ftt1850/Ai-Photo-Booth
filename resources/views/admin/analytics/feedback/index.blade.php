<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Feedback - Admin</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body>

<div style="padding: 40px;">

    <h1>Feedback</h1>

    <p>
        User feedback will be displayed here.
    </p>

    <a href="{{ route('admin.dashboard') }}">
        ← Back to Dashboard
    </a>

</div>

</body>

</html>