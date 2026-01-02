<?php
// Set HTTP response code
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 - Page Not Found</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Optional: your main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
        }
        .container {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .box {
            background: #fff;
            padding: 40px;
            text-align: center;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 400px;
        }
        h1 {
            font-size: 72px;
            margin: 0;
            color: #e74c3c;
        }
        p {
            color: #555;
            margin: 15px 0 25px;
        }
        a {
            display: inline-block;
            padding: 10px 20px;
            background: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
        a:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="box">
        <h1>404</h1>
        <p>Sorry, the page you are looking for does not exist.</p>
        <a href="index.php">Back to Home</a>
    </div>
</div>

</body>
</html>
