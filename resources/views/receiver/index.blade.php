<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receiver Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #0f172a;
            color: white;
            min-height: 100vh;
            padding: 30px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .title h1 {
            font-size: 34px;
        }

        .title p {
            color: #94a3b8;
        }

        .btn {
            padding: 12px 22px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            transition: .3s;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: rgba(255,255,255,0.05);
            padding: 25px;
            border-radius: 18px;
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.08);
        }

        .card h2 {
            font-size: 32px;
            margin-top: 10px;
        }

        .search-box {
            margin-bottom: 25px;
        }

        .search-box form {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .search-box input {
            flex: 1;
            padding: 14px;
            border: none;
            border-radius: 12px;
            background: #1e293b;
            color: white;
        }

        .search-btn {
            padding: 14px 25px;
            border: none;
            border-radius: 12px;
            background: #22c55e;
            color: white;
            cursor: pointer;
            font-weight: 600;
        }

        .message-grid {
            display: grid;
            gap: 20px;
        }

        .message-card {
            background: rgba(255,255,255,0.05);
            padding: 25px;
            border-radius: 18px;
            border: 1px solid rgba(255,255,255,0.06);
            transition: .3s;
        }

        .message-card:hover {
            transform: translateY(-4px);
        }

        .message-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .message-top h3 {
            color: #60a5fa;
        }

        .date {
            color: #94a3b8;
            font-size: 14px;
        }

        .delete-btn {
            background: #ef4444;
            border: none;
            padding: 10px 16px;
            color: white;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 18px;
        }

        .success {
            background: #14532d;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .empty {
            text-align: center;
            padding: 60px;
            background: rgba(255,255,255,0.05);
            border-radius: 20px;
            color: #94a3b8;
        }

        @media(max-width:768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <div class="title">
            <h1>Receiver Dashboard</h1>
            <p>Manage all received messages easily</p>
        </div>

        <a href="/receiver/create" class="btn">
            + Add Message
        </a>
    </div>

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <div class="stats">
        <div class="card">
            <p>Total Messages</p>
            <h2>{{ $totalMessages }}</h2>
        </div>

        <div class="card">
            <p>Today's Messages</p>
            <h2>{{ $todayMessages }}</h2>
        </div>
    </div>

    <div class="search-box">
        <form>
            <input type="text" name="search" placeholder="Search sender or message...">
            <button class="search-btn">
                Search
            </button>
        </form>
    </div>

    <div class="message-grid">

        @forelse($receivers as $receive)

            <div class="message-card">

                <div class="message-top">
                    <div>
                        <h3>{{ $receive->sender_name }}</h3>
                        <div class="date">
                            {{ $receive->created_at->format('d M Y - h:i A') }}
                        </div>
                    </div>
                </div>

                <p>
                    {{ $receive->message }}
                </p>

                <form action="{{ route('receiver.destroy', $receive->id) }}"
                      method="POST"
                      onsubmit="return confirm('Delete this message?')">

                    @csrf
                    @method('DELETE')

                    <button class="delete-btn">
                        Delete
                    </button>

                </form>

            </div>

        @empty

            <div class="empty">
                <h2>No Messages Found</h2>
            </div>

        @endforelse

    </div>

</div>

</body>
</html>