<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receiver List</title>
    <style>
        /* Reset & basic styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #121212;
            color: #f0f0f0;
            line-height: 1.6;
            padding: 20px;
        }

        h2 {
            margin-bottom: 20px;
            color: #fff;
            text-align: center;
        }

        a.button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #1f80e0;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
            margin-bottom: 20px;
        }

        a.button:hover {
            background-color: #3aa0ff;
        }

        .success {
            background-color: #2e7d32;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }

        ul.receiver-list {
            list-style: none;
            max-width: 800px;
            margin: 0 auto;
            padding: 0;
        }

        ul.receiver-list li {
            background-color: #1e1e1e;
            padding: 15px 20px;
            margin-bottom: 10px;
            border-radius: 8px;
            transition: transform 0.2s;
        }

        ul.receiver-list li:hover {
            transform: scale(1.02);
        }

        strong {
            color: #1f80e0;
        }

        small {
            color: #aaa;
        }
    </style>
</head>

<body>

    <h2>All Received Messages</h2>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <div style="text-align:center;">
        <a class="button" href="/receiver/create">Add New</a>
    </div>

    <ul class="receiver-list">
        @foreach($receivers as $receive)
            <li>
                <strong>{{ $receive->sender_name }}</strong>:
                {{ $receive->message }}
                <br>
                <small>{{ $receive->created_at->format('d M, Y H:i') }}</small>
            </li>
        @endforeach
    </ul>

</body>

</html>