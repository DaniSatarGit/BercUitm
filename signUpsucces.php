<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success Create Acc</title>
    <style>
        /* Basic reset and full-height layout */
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to bottom, #2c3e50, #bdc3c7); /* Moonlight gradient */
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        /* Container styling */
        .container {
            background: rgba(255, 255, 255, 0.8);
            color: #333;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            padding: 40px;
            max-width: 500px;
            width: 100%;
            box-sizing: border-box;
            position: relative;
            backdrop-filter: blur(10px); /* Add blur effect for a frosted glass look */
        }

        h1 {
            font-size: 36px;
            margin-bottom: 20px;
            color: #333;
        }

        p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        a:hover {
            color: #2980b9;
        }

        /* Image styling */
        .success-image {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
        }

        /* Add some spacing */
        body > * {
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Success image -->
        <img src="https://img.icons8.com/ios/452/checkmark.png" alt="Success" class="success-image">
        <h1>Sign Up</h1>
        <p>Sign up successful. You can now <a href="index.php">Log in</a>.</p>
    </div>
</body>
</html>
