<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }
        
        .login-container {
            background-color: white;
            width: 100%;
            max-width: 400px;
            padding: 40px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
        }
        
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #222;
            font-weight: 600;
            font-size: 24px;
        }
        
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 14px;
            border-left: 4px solid #dc3545;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }
        
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
            background-color: #fafafa;
        }
        
        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #555;
            background-color: white;
        }
        
        .login-button {
            width: 100%;
            padding: 12px;
            background-color: #222;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .login-button:hover {
            background-color: #000;
        }
        
        .login-button:active {
            transform: translateY(1px);
        }
        
        .form-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }
        
        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
                margin: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Employee Login</h2>

        @if ($errors->any())
            <div class="error-message">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('employee.login.submit') }}">
            @csrf
            <div class="form-group">
                <label for="email">Employee Email</label>
                <input type="text" id="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="login-button">Login</button>
        </form>
        
       <div class="form-footer">
    Secure Employee Access<br><br>

    <a href="{{ route('login') }}" 
       style="color:#007bff; text-decoration:none; font-weight:600;">
        Admin Login
    </a>
</div>

    </div>
</body>
</html>