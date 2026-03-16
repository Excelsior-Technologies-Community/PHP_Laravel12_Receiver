<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Receiver Message</title>
    <style>
        body {
            background-color: #121212;
            color: #f0f0f0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .form-container {
            background-color: #1e1e1e;
            padding: 30px 40px;
            border-radius: 10px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #fff;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: none;
            background-color: #2c2c2c;
            color: #f0f0f0;
            font-size: 16px;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #1f80e0;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background-color: #3aa0ff;
        }

        .errors {
            background-color: #b71c1c;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .errors ul {
            list-style: none;
            padding-left: 0;
        }

        .errors li {
            margin-bottom: 5px;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #1f80e0;
            text-decoration: none;
        }

        .back-link:hover {
            color: #3aa0ff;
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h2>Send Message</h2>

        @if ($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/receiver/store" method="POST">
            @csrf
            <label>Sender Name:</label>
            <input type="text" name="sender_name" placeholder="Enter your name">

            <label>Message:</label>
            <textarea name="message" placeholder="Enter your message"></textarea>

            <button type="submit">Submit</button>
        </form>

        <a class="back-link" href="/">← Back to List</a>
    </div>

</body>

</html>