<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | BuyMatch</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            margin: 0;
            height: 100vh;
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }

        .register-box {
            background-color: #111;
            padding: 30px;
            width: 100%;
            max-width: 380px;
            border-radius: 10px;
            box-shadow: 0 0 25px rgba(0,0,0,0.6);
        }

        .register-box h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #00d4ff;
        }

        .register-box input,
        .register-box select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: none;
            outline: none;
            background-color: #222;
            color: #fff;
            font-size: 14px;
        }

        .register-box input::placeholder {
            color: #aaa;
        }

        .register-box select {
            color: #aaa;
        }

        .register-box button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 5px;
            background-color: #00d4ff;
            color: #000;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .register-box button:hover {
            background-color: #00a8cc;
        }

        .footer-text {
            text-align: center;
            margin-top: 15px;
            font-size: 13px;
            color: #aaa;
        }

        a{
                color: #aaa;
        }
    </style>
</head>
<body>

    <div class="register-box">
        <h2>Create Account</h2>

        <form method="POST" action="../auth/register.php">
            <input type="text" name="name" placeholder="Full Name" required>

            <input type="email" name="email" placeholder="Email Address" required>

            <input type="password" name="password" placeholder="Password" required>

            <select name="role" required>
                <option value="" disabled selected>Select Role</option>
                <option value="buyer">Buyer</option>
                <option value="organizer">Organizer</option>
            </select>

            <button type="submit">Register</button>
        </form>

        <div class="footer-text">
            Already have an account? <a href="login.php">login</a>
        </div>
    </div>

</body>
</html>
