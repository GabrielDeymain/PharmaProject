<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 100px;
        }
        .login-container {
            max-width: 300px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 2px 2px 10px #ddd;
        }
        input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>User Login</h2>
        <form action="login.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <label for="userType">User Type:</label>
    <select name="userType" id="userType" required>
        <option value="">Select User Type</option>
        <option value="Patient">Patient</option>
        <option value="Pharmacist">Pharmacist</option>
    </select>

            <button type="submit">Login</button>
        </form>
    </div>

</body>
</html>