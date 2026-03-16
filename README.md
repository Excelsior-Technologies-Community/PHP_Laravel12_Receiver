# PHP_Laravel12_Receiver



## Project Description

PHP_Laravel12_Receiver is a simple Laravel 12 web application designed to receive, store, and display messages submitted by users.
It provides a modern dark-mode UI for listing all received messages and a form to send new messages.

This project demonstrates the MVC architecture in Laravel, including Models, Views, Controllers, Routes, and Migrations, making it a beginner-friendly example of a full-stack Laravel application.



## Features

- Add New Message: Users can submit messages with their name.

- View Messages: Display all received messages in a clean, dark-themed UI.

- Validation: Input fields are validated before saving to the database.

- Responsive Design: Works well on desktop and mobile screens.

- Dark Mode UI: Modern dark-mode interface for better user experience.


## How it Works
1. User opens the main page to see all received messages.
2. Click "Add New" to go to the form page.
3. User enters sender name and message.
4. Upon submitting, message is saved in the database and displayed on the main page.


## Future Enhancements
- Add authentication for users.
- Enable editing or deleting messages.
- Create API endpoints for external apps.
- Add search and filtering for messages.


## Technology Stack

- Backend: PHP 8+, Laravel 12

- Frontend: Blade Templates, HTML, CSS

- Database: MySQL

- Server: Built-in Laravel Artisan server for development


## Prerequisites
- PHP 8+
- Composer
- MySQL
- Web browser (Chrome, Firefox, etc.)


---



## Installation Steps


---


## STEP 1: Create Laravel 12 Project

### Open terminal / CMD and run:

```
composer create-project laravel/laravel PHP_Laravel12_Receiver "12.*"

```

### Go inside project:

```
cd PHP_Laravel12_Receiver

```

#### Explanation:

Installs a fresh Laravel 12 application using Composer and sets up the project folder to start development.



## STEP 2: Database Setup 

### Update database details:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel12_Receiver
DB_USERNAME=root
DB_PASSWORD=

```

### Create database in MySQL / phpMyAdmin:

```
Database name: laravel12_Receiver

```

### Then Run:

```
php artisan migrate

```


#### Explanation:

Configures the .env file with MySQL details and runs migrations to create default tables in the database.





## STEP 3: Create Model and Migration

### Run:

```
php artisan make:model Receiver -m

```


### Open: database/migrations/xxxx_create_receivers_table.php

```
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('receivers', function (Blueprint $table) {
            $table->id();
            $table->string('sender_name')->nullable();
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('receivers');
    }
};

```

### Then Run:

```
php artisan migrate

```


### Edit: app/Models/Receiver.php

```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receiver extends Model
{
    protected $fillable = [
        'sender_name',
        'message',
    ];
}

```

#### Explanation: 

Creates the Receiver model and a migration file to define the receivers table structure, then runs it to create the table.




## STEP 4: Create Controller

### Run:

```
php artisan make:controller ReceiverController

```

### Edit: app/Http/Controllers/ReceiverController.php

```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receiver;

class ReceiverController extends Controller
{
    public function index()
    {
        $receivers = Receiver::latest()->get();
        return view('receiver.index', compact('receivers'));
    }

    public function create()
    {
        return view('receiver.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sender_name' => 'required',
            'message' => 'required',
        ]);

        Receiver::create([
            'sender_name' => $request->sender_name,
            'message' => $request->message,
        ]);

        return redirect('/')->with('success', 'Message received successfully!');
    }
}

```

#### Explanation: 

Creates the Receiver model and a migration file to define the receivers table structure, then runs it to create the table.





## STEP 5: Add Routes

### Open: routes/web.php

```
use App\Http\Controllers\ReceiverController;

Route::get('/', [ReceiverController::class, 'index']);
Route::get('/receiver/create', [ReceiverController::class, 'create']);
Route::post('/receiver/store', [ReceiverController::class, 'store']);

```

#### Explanation: 

Defines web routes for listing messages, showing the create form, and storing submitted messages using the controller.





## STEP 6: Views / Blade Templates

### Create view folder:

```
mkdir resources/views/receiver

```


### resources/views/receiver/index.blade.php

```
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

```


### resources/views/receiver/create.blade.php

```
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
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
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

```

#### Explanation: 

Creates index.blade.php to display all messages and create.blade.php to send new messages, styled with modern dark mode UI.





## STEP 7: Run the App

### Start dev server:

```
php artisan serve

```

### Open in browser:

```
http://127.0.0.1:8000

```

#### Explanation: 

Starts the Laravel development server and opens the app in the browser to test full functionality.




## Expected Output:

### Main Page:


<img src="screenshots/Screenshot 2026-03-16 173220.png" width="900">


### Send Message Page:


<img src="screenshots/Screenshot 2026-03-16 173248.png" width="900">


### After Send Message:


<img src="screenshots/Screenshot 2026-03-16 173257.png" width="900">


---


## Project Folder Structure:

```
PHP_Laravel12_Receiver/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── ReceiverController.php
│   └── Models/
│       └── Receiver.php
├── database/
│   └── migrations/
│       └── xxxx_create_receivers_table.php
├── resources/
│   └── views/
│       └── receiver/
│           ├── index.blade.php
│           └── create.blade.php
├── routes/
│   └── web.php
├── .env
├── composer.json
└── README.md

```
