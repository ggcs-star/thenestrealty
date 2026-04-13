<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Portal · Secure Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(145deg, #fbf7f0 0%, #efe6d8 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 24px;
            color: #2d3748;
        }
        
        /* Main card container with image + form */
        .login-card {
            display: flex;
            max-width: 1000px;
            width: 100%;
            background: white;
            border-radius: 28px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15), 
                        0 8px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            border: 1px solid rgba(172, 126, 44, 0.15);
            animation: fadeIn 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.98);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        /* LEFT SIDE - IMAGE SECTION */
        .login-image {
            flex: 1.1;
            background: #d4c4ae;
            background-image: url('https://images.pexels.com/photos/3184292/pexels-photo-3184292.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2');
            background-size: cover;
            background-position: center 30%;
            position: relative;
            display: flex;
            align-items: flex-end;
            padding: 32px;
            min-height: 100%;
        }
        
        /* Warm gold overlay using #AC7E2C */
        .image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, 
                rgba(172, 126, 44, 0.35) 0%, 
                rgba(120, 85, 30, 0.5) 100%);
            mix-blend-mode: multiply;
        }
        
        .image-content {
            position: relative;
            z-index: 2;
            color: white;
            text-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }
        
        .image-content h3 {
            font-size: 2.4rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.2;
            margin-bottom: 8px;
        }
        
        .image-content p {
            font-size: 1rem;
            opacity: 0.95;
            display: flex;
            align-items: center;
            gap: 8px;
            backdrop-filter: blur(4px);
            padding: 6px 0;
        }
        
        .image-content i {
            color: #AC7E2C;
            background: white;
            border-radius: 50%;
            padding: 4px;
            font-size: 12px;
        }
        
        .theme-badge {
            position: absolute;
            bottom: 20px;
            right: 24px;
            z-index: 3;
            color: rgba(255,255,245,0.8);
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        
        /* RIGHT SIDE - FORM SECTION with #AC7E2C theme */
        .login-form-wrapper {
            flex: 1;
            padding: 48px 40px;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .form-header {
            margin-bottom: 36px;
        }
        
        .employee-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #AC7E2C, #8d6421);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            box-shadow: 0 8px 16px -4px rgba(172, 126, 44, 0.3);
        }
        
        .employee-icon i {
            font-size: 28px;
            color: white;
        }
        
        h2 {
            font-size: 28px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 6px;
            letter-spacing: -0.5px;
        }
        
        .subtitle {
            color: #6b5a42;
            font-size: 14px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-left: 4px solid #AC7E2C;
            padding-left: 7px;
        }
        
        /* Error message styling */
        .error-message {
            background: linear-gradient(to right, #fff5eb, #ffe8d6);
            color: #8b4513;
            padding: 14px 18px;
            border-radius: 14px;
            margin-bottom: 28px;
            font-size: 14px;
            font-weight: 500;
            border-left: 4px solid #AC7E2C;
            box-shadow: 0 2px 8px rgba(172, 126, 44, 0.1);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .error-message i {
            color: #AC7E2C;
            font-size: 18px;
        }
        
        /* Form elements */
        .form-group {
            margin-bottom: 24px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #5c4d35;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #b8a58a;
            font-size: 16px;
            transition: color 0.2s;
        }
        
        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: 100%;
            padding: 14px 16px 14px 48px;
            border: 2px solid #e8ddd0;
            border-radius: 16px;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.25s;
            background-color: #fdfbf9;
            color: #2d1f0e;
            font-family: 'Inter', sans-serif;
        }
        
        input[type="text"]:hover,
        input[type="password"]:hover,
        input[type="email"]:hover {
            border-color: #d4c4ae;
            background-color: white;
        }
        
        input[type="text"]:focus,
        input[type="password"]:focus,
        input[type="email"]:focus {
            outline: none;
            border-color: #AC7E2C;
            background-color: white;
            box-shadow: 0 0 0 4px rgba(172, 126, 44, 0.12);
        }
        
        .input-wrapper:focus-within .input-icon {
            color: #AC7E2C;
        }
        
        .password-hint {
            font-size: 12px;
            color: #9b8b78;
            margin-top: 6px;
            margin-left: 4px;
        }
        
        /* Login button with #AC7E2C */
        .login-button {
            width: 100%;
            padding: 15px 20px;
            background: #AC7E2C;
            color: white;
            border: none;
            border-radius: 40px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 8px 20px -6px rgba(172, 126, 44, 0.4);
            margin-top: 10px;
            letter-spacing: 0.3px;
            position: relative;
            overflow: hidden;
        }
        
        .login-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
            transition: left 0.5s;
        }
        
        .login-button:hover {
            background: #9b6f25;
            transform: translateY(-2px);
            box-shadow: 0 14px 28px -8px rgba(172, 126, 44, 0.5);
        }
        
        .login-button:hover::before {
            left: 100%;
        }
        
        .login-button:active {
            transform: translateY(1px);
            box-shadow: 0 5px 15px -3px rgba(172, 126, 44, 0.4);
            background: #8d6421;
        }
        
        /* Footer */
        .form-footer {
            text-align: center;
            margin-top: 32px;
            font-size: 14px;
            color: #7a6b58;
            border-top: 1px solid #ede4d8;
            padding-top: 28px;
        }
        
        .secure-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 18px;
            color: #6b5a42;
            font-size: 13px;
            font-weight: 500;
        }
        
        .secure-badge i {
            color: #AC7E2C;
        }
        
        .admin-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #AC7E2C;
            text-decoration: none;
            font-weight: 700;
            padding: 10px 20px;
            border-radius: 40px;
            background: rgba(172, 126, 44, 0.06);
            transition: all 0.2s;
            border: 1.5px solid transparent;
        }
        
        .admin-link i {
            font-size: 14px;
            transition: transform 0.2s;
        }
        
        .admin-link:hover {
            background: rgba(172, 126, 44, 0.12);
            border-color: rgba(172, 126, 44, 0.25);
            color: #8d6421;
        }
        
        .admin-link:hover i {
            transform: translateX(3px);
        }
        
        /* Responsive */
        @media (max-width: 700px) {
            .login-card {
                flex-direction: column;
                max-width: 480px;
            }
            
            .login-image {
                min-height: 220px;
                background-position: center 25%;
            }
            
            .login-form-wrapper {
                padding: 36px 28px;
            }
            
            .image-content h3 {
                font-size: 2rem;
            }
        }
        
        @media (max-width: 480px) {
            body {
                padding: 16px;
            }
            
            .login-form-wrapper {
                padding: 28px 20px;
            }
            
            h2 {
                font-size: 24px;
            }
        }
        
        /* Accessibility */
        *:focus-visible {
            outline: 2px solid #AC7E2C;
            outline-offset: 2px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        
        <!-- LEFT SIDE - IMAGE (one image as requested) -->
        <div class="login-image">
            <div class="image-overlay"></div>
            <div class="image-content">
                {{-- <h3>Team<br>Workspace</h3> --}}
                {{-- <p>
                    <i class="fas fa-circle"></i>
                    Secure employee access
                </p> --}}
            </div>
            <div class="theme-badge">
                {{-- <i class="fas fa-shield"></i> #AC7E2C --}}
            </div>
        </div>
        
        <!-- RIGHT SIDE - LOGIN FORM with #AC7E2C theme -->
        <div class="login-form-wrapper">
            <div class="form-header">
                {{-- <div class="employee-icon">
                    <i class="fas fa-user-tie"></i>
                </div> --}}
                <h2>Employee Login</h2>
                <div class="subtitle">Access your dashboard</div>
            </div>

            @if ($errors->any())
                <div class="error-message">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('employee.login.submit') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Work Email</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" id="email" name="email" 
                               value="{{ old('email') }}" 
                               placeholder="name@company.com"
                               required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" 
                               placeholder="••••••••" 
                               required>
                    </div>
                    <div class="password-hint">
                        <i class="far fa-keyboard"></i> Use your employee credentials
                    </div>
                </div>

                <button type="submit" class="login-button">
                    <i class="fas fa-arrow-right-to-bracket" style="margin-right: 10px;"></i>
                     Sign in 
                </button>
            </form>
            
            <div class="form-footer">
               
                
                <a href="{{ route('login') }}" class="admin-link">
                    <i class="fas fa-arrow-left"></i>
                    Switch to Admin Login
                    <i class="fas fa-user-cog"></i>
                </a>
               
            </div>
        </div>
    </div>
    
    <script>
        // Enhance input interaction
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.querySelector('.input-icon').style.color = '#AC7E2C';
                });
                input.addEventListener('blur', function() {
                    this.parentElement.querySelector('.input-icon').style.color = '#b8a58a';
                });
            });
        });
    </script>
</body>
</html>