<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Receiver Message</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, #2563eb 0%, transparent 30%),
                radial-gradient(circle at bottom right, #7c3aed 0%, transparent 30%),
                #0f172a;

            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
            overflow-x: hidden;
        }

        .form-wrapper {
            width: 100%;
            max-width: 650px;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            color: white;
        }

        .top-bar h1 {
            font-size: 32px;
            font-weight: 700;
        }

        .top-bar p {
            color: #94a3b8;
            margin-top: 5px;
        }

        .back-btn {
            text-decoration: none;
            background: rgba(255,255,255,0.08);
            padding: 12px 20px;
            border-radius: 12px;
            color: white;
            transition: 0.3s;
            border: 1px solid rgba(255,255,255,0.08);
        }

        .back-btn:hover {
            background: rgba(255,255,255,0.15);
        }

        .form-container {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            backdrop-filter: blur(15px);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.35);
        }

        .form-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .form-header h2 {
            color: white;
            font-size: 30px;
            margin-bottom: 10px;
        }

        .form-header p {
            color: #94a3b8;
            font-size: 15px;
        }

        .errors {
            background: rgba(239,68,68,0.15);
            border: 1px solid rgba(239,68,68,0.4);
            color: #fecaca;
            padding: 18px;
            border-radius: 14px;
            margin-bottom: 25px;
        }

        .errors ul {
            list-style: none;
        }

        .errors li {
            margin-bottom: 8px;
        }

        .input-group {
            margin-bottom: 28px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #e2e8f0;
            font-weight: 500;
            font-size: 15px;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 16px 18px;
            border-radius: 16px;
            border: 1px solid rgba(255,255,255,0.08);
            background: rgba(255,255,255,0.04);
            color: white;
            font-size: 15px;
            outline: none;
            transition: 0.3s;
        }

        input[type="text"]:focus,
        textarea:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59,130,246,0.15);
            background: rgba(255,255,255,0.07);
        }

        textarea {
            min-height: 160px;
            resize: vertical;
        }

        input::placeholder,
        textarea::placeholder {
            color: #94a3b8;
        }

        .submit-btn {
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 16px;
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            color: white;
            font-size: 17px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(59,130,246,0.3);
        }

        .bottom-text {
            text-align: center;
            margin-top: 25px;
            color: #94a3b8;
            font-size: 14px;
        }

        @media(max-width:768px) {

            .top-bar {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .form-container {
                padding: 25px;
            }

            .top-bar h1 {
                font-size: 26px;
            }

            .form-header h2 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>

    <div class="form-wrapper">

        <div class="top-bar">

            <div>
                <h1>Receiver Panel</h1>
                <p>Create and manage incoming messages</p>
            </div>

            <a href="/" class="back-btn">
                ← Back Dashboard
            </a>

        </div>

        <div class="form-container">

            <div class="form-header">
                <h2>Send New Message</h2>
                <p>Fill in the details below to submit your message.</p>
            </div>

            @if ($errors->any())
                <div class="errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/receiver/store" method="POST">

                @csrf

                <div class="input-group">
                    <label>Sender Name</label>

                    <input
                        type="text"
                        name="sender_name"
                        placeholder="Enter sender name"
                        value="{{ old('sender_name') }}">
                </div>

                <div class="input-group">
                    <label>Message</label>

                    <textarea
                        name="message"
                        placeholder="Write your message here...">{{ old('message') }}</textarea>
                </div>

                <button type="submit" class="submit-btn">
                    Submit Message
                </button>

            </form>

            <div class="bottom-text">
                Receiver Management System • Laravel 12
            </div>

        </div>

    </div>

</body>

</html>