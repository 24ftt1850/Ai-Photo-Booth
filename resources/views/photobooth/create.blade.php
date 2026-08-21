<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AI Photo Booth</title>

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
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .booth {
            width: 100%;
            max-width: 1000px;
            background: #1e293b;
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            margin: 0;
            font-size: 32px;
        }

        .header p {
            color: #94a3b8;
            margin-top: 10px;
        }

        .camera-area {
            position: relative;
            width: 100%;
            aspect-ratio: 16 / 10;
            background: #020617;
            border-radius: 20px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        video,
        #preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #preview {
            display: none;
        }

        .camera-placeholder {
            text-align: center;
            color: #64748b;
        }

        .camera-placeholder .icon {
            font-size: 60px;
            margin-bottom: 10px;
        }

        .controls {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 25px;
            flex-wrap: wrap;
        }

        button,
        .upload-button {
            border: none;
            padding: 14px 24px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        .camera-button {
            background: #7c3aed;
            color: white;
        }

        .camera-button:hover {
            background: #6d28d9;
        }

        .capture-button {
            background: #ef4444;
            color: white;
        }

        .capture-button:hover {
            background: #dc2626;
        }

        .upload-button {
            background: #334155;
            color: white;
            display: inline-block;
        }

        .upload-button:hover {
            background: #475569;
        }

        .continue-button {
            background: #06b6d4;
            color: white;
        }

        .continue-button:hover {
            background: #0891b2;
        }

        .hidden {
            display: none !important;
        }

        #photoInput {
            display: none;
        }

        .message {
            text-align: center;
            margin-top: 15px;
            color: #f87171;
        }

        .photo-info {
            text-align: center;
            margin-top: 15px;
            color: #94a3b8;
        }

        .back-home-button {
            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 10px;

            padding: 12px 18px;

            border: 1px solid #334155;

            border-radius: 12px;

            color: #94a3b8;

            background: transparent;

            text-decoration: none;

            font-size: 13px;

            font-weight: bold;

            transition: 0.2s ease;
        }

        .back-home-button:hover {
            color: white;

            border-color: #64748b;

            background: #1e293b;
        }

        .back-home-arrow {
            font-size: 14px;
        }
    </style>
</head>

<body>

<div class="page">

    <div class="booth">

        <div class="header">
            <h1>✨ AI Photo Booth</h1>

            <p>
                Take a photo or upload an image to create your AI portrait.
            </p>
        </div>

        <!-- Camera / Preview -->

        <div class="camera-area">

            <!-- Webcam -->

            <video
                id="camera"
                autoplay
                playsinline
            ></video>

            <!-- Image Preview -->

            <img
                id="preview"
                alt="Photo preview"
            >

            <!-- Initial placeholder -->

            <div
                id="placeholder"
                class="camera-placeholder"
            >
                <div class="icon">📷</div>

                <div>
                    Camera preview will appear here
                </div>
            </div>

        </div>


        <!-- Controls -->

        <div class="controls">

            <!-- Open Camera -->

            <button
                id="openCamera"
                class="camera-button"
                type="button"
            >
                📷 Open Camera
            </button>


            <!-- Capture -->

            <button
                id="capture"
                class="capture-button hidden"
                type="button"
            >
                📸 Take Photo
            </button>


            <!-- Upload -->

            <label
                for="photoInput"
                class="upload-button"
            >
                🖼️ Upload Image
            </label>

            <input
                type="file"
                id="photoInput"
                accept="image/*"
            >


            <!-- Continue -->

            <button
                id="continueButton"
                class="continue-button hidden"
                type="button"
            >
                Continue →
            </button>

            <a
                href="{{ route('home') }}"
                class="back-home-button"
            >
                <span class="back-home-arrow">←</span>
                <span>BACK TO HOME</span>
            </a>

        </div>


        <div
            id="message"
            class="message"
        ></div>

        <div
            id="photoInfo"
            class="photo-info"
        ></div>

    </div>

</div>


<script>

const camera = document.getElementById('camera');
const preview = document.getElementById('preview');
const placeholder = document.getElementById('placeholder');

const openCameraButton = document.getElementById('openCamera');
const captureButton = document.getElementById('capture');
const continueButton = document.getElementById('continueButton');

const photoInput = document.getElementById('photoInput');

const message = document.getElementById('message');
const photoInfo = document.getElementById('photoInfo');

let stream = null;
let selectedFile = null;


/*
|--------------------------------------------------------------------------
| Open Camera
|--------------------------------------------------------------------------
*/

openCameraButton.addEventListener('click', async () => {

    message.textContent = '';

    try {

        stream = await navigator.mediaDevices.getUserMedia({
            video: {
                facingMode: 'user'
            },
            audio: false
        });

        camera.srcObject = stream;

        camera.style.display = 'block';
        preview.style.display = 'none';

        placeholder.style.display = 'none';

        captureButton.classList.remove('hidden');

        openCameraButton.textContent = '📷 Camera Active';

    } catch (error) {

        console.error(error);

        message.textContent =
            'Unable to access the camera. Please allow camera permission.';

    }

});


/*
|--------------------------------------------------------------------------
| Take Photo
|--------------------------------------------------------------------------
*/

captureButton.addEventListener('click', () => {

    if (!stream) {
        return;
    }

    const canvas = document.createElement('canvas');

    canvas.width = camera.videoWidth;
    canvas.height = camera.videoHeight;

    const context = canvas.getContext('2d');

    context.drawImage(
        camera,
        0,
        0,
        canvas.width,
        canvas.height
    );

    canvas.toBlob((blob) => {

        selectedFile = new File(
            [blob],
            'camera-photo.jpg',
            {
                type: 'image/jpeg'
            }
        );

        preview.src = URL.createObjectURL(blob);

        showPreview();

    }, 'image/jpeg', 0.9);

});


/*
|--------------------------------------------------------------------------
| Upload Image
|--------------------------------------------------------------------------
*/

photoInput.addEventListener('change', (event) => {

    const file = event.target.files[0];

    if (!file) {
        return;
    }

    if (!file.type.startsWith('image/')) {

        message.textContent =
            'Please select an image file.';

        return;
    }

    selectedFile = file;

    preview.src = URL.createObjectURL(file);

    showPreview();

});


/*
|--------------------------------------------------------------------------
| Show Preview
|--------------------------------------------------------------------------
*/

function showPreview() {

    /*
     * Stop camera
     */

    stopCamera();

    /*
     * Show image
     */

    camera.style.display = 'none';

    preview.style.display = 'block';

    placeholder.style.display = 'none';

    /*
     * Buttons
     */

    captureButton.classList.add('hidden');

    continueButton.classList.remove('hidden');

    openCameraButton.textContent = '📷 Retake Photo';

    /*
     * Information
     */

    if (selectedFile) {

        const size =
            (selectedFile.size / 1024 / 1024).toFixed(2);

        photoInfo.textContent =
            `${selectedFile.name} • ${size} MB`;

    }

}


/*
|--------------------------------------------------------------------------
| Stop Camera
|--------------------------------------------------------------------------
*/

function stopCamera() {

    if (stream) {

        stream.getTracks().forEach(track => {
            track.stop();
        });

        stream = null;
    }

}


/*
|--------------------------------------------------------------------------
| Continue
|--------------------------------------------------------------------------
*/

continueButton.addEventListener('click', () => {

    if (!selectedFile) {

        message.textContent =
            'Please take or upload a photo first.';

        return;
    }

    message.textContent = 'Preparing your photo...';

    /*
    |--------------------------------------------------------------------------
    | Compress image before storing it
    |--------------------------------------------------------------------------
    */

    const reader = new FileReader();

    reader.onload = function(event) {

        const img = new Image();

        img.onload = function() {

            const canvas = document.createElement('canvas');

            /*
             * Limit image size.
             * This prevents sessionStorage from becoming too large.
             */

            const maxWidth = 1200;
            const maxHeight = 1200;

            let width = img.width;
            let height = img.height;

            if (width > maxWidth || height > maxHeight) {

                const ratio = Math.min(
                    maxWidth / width,
                    maxHeight / height
                );

                width = Math.round(width * ratio);
                height = Math.round(height * ratio);
            }

            canvas.width = width;
            canvas.height = height;

            const context = canvas.getContext('2d');

            context.drawImage(
                img,
                0,
                0,
                width,
                height
            );

            /*
             * Convert to compressed JPEG.
             */

            const compressedPhoto =
                canvas.toDataURL(
                    'image/jpeg',
                    0.75
                );

            try {

                sessionStorage.setItem(
                    'photobooth_photo',
                    compressedPhoto
                );

                console.log(
                    'Photo saved successfully.'
                );

                /*
                 * Move to theme selection.
                 */

                window.location.href =
                    "{{ route('photobooth.scene') }}";

            } catch (error) {

                console.error(error);

                message.textContent =
                    'The image is too large. Please choose a smaller image.';

            }

        };

        img.onerror = function() {

            message.textContent =
                'Unable to process this image.';

        };

        img.src = event.target.result;

    };

    reader.onerror = function() {

        message.textContent =
            'Unable to read the selected image.';

    };

    reader.readAsDataURL(selectedFile);

});

</script>

</body>
</html>