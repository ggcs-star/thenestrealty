<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login · Golden Hour</title>
    <!-- Vite (kept as original) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Inter font for clean look -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz@14..32&display=swap" rel="stylesheet">
    
    <style>
        /* smooth reset & base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: linear-gradient(145deg, #fbf7f0 0%, #efe6d8 100%);
            /* subtle warm gradient instead of harsh purple — but keeps elegance.
               you can keep original purple gradient if you want; but #AC7E2C is gold/brass, so we pair with warm neutrals */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }
        
        /* main card – double column on larger screens, with image on left */
        .login-card {
            display: flex;
            max-width: 1000px;
            width: 100%;
            background: white;
            border-radius: 2rem;
            box-shadow: 0 25px 40px -12px rgba(0, 0, 0, 0.18), 0 8px 18px rgba(0,0,0,0.05);
            overflow: hidden;
            transition: all 0.2s ease;
            border: 1px solid rgba(172, 126, 44, 0.12);
        }
        
        /* left side – image area */
        .login-image {
            flex: 1.1;
            background: #d9c8b1; /* fallback */
            background-image: url('https://images.pexels.com/photos/3184418/pexels-photo-3184418.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2');
            background-size: cover;
            background-position: 40% 30%;
            position: relative;
            display: flex;
            align-items: flex-end;
            padding: 2rem;
        }
        
        /* overlay with #AC7E2C warmth */
        .image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(172, 126, 44, 0.24) 0%, rgba(75, 55, 30, 0.4) 100%);
            mix-blend-mode: multiply;
        }
        
        .image-caption {
            position: relative;
            z-index: 2;
            color: white;
            text-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }
        .image-caption h3 {
            font-size: 2.2rem;
            font-weight: 600;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }
        .image-caption p {
            font-size: 1rem;
            opacity: 0.9;
            margin-top: 0.5rem;
            backdrop-filter: blur(2px);
            display: inline-block;
            padding: 0.25rem 0;
        }
        
        /* right side – form container */
        .login-form-wrapper {
            flex: 1;
            padding: 3rem 2.5rem;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        /* theme color #AC7E2C applied to accents, focus, button */
        .welcome-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1e1e1e;
            margin-bottom: 0.25rem;
            letter-spacing: -0.02em;
        }
        .welcome-sub {
            color: #5f5f5f;
            margin-bottom: 2rem;
            font-size: 0.95rem;
            border-left: 4px solid #AC7E2C;
            padding-left: 8px;}
        
        .input-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            color: #4a3f2e;
            margin-bottom: 0.4rem;
        }
        
        /* custom input style with #AC7E2C focus */
        .input-field {
            width: 100%;
            padding: 0.85rem 1rem;
            background-color: #fcfaf7;
            border: 1.5px solid #e4dbcf;
            border-radius: 18px;
            font-size: 1rem;
            transition: all 0.15s;
            color: #1f1a14;
        }
        .input-field:focus {
            outline: none;
            border-color: #AC7E2C;
            box-shadow: 0 0 0 4px rgba(172, 126, 44, 0.15);
            background-color: white;
        }
        .input-field::placeholder {
            color: #a99e91;
            font-weight: 300;
            font-size: 0.9rem;
        }
        
        /* button — fully themed */
        .login-btn {
            background: #AC7E2C;
            color: white;
            font-weight: 600;
            padding: 0.9rem 1.8rem;
            border-radius: 40px;
            border: none;
            width: 100%;
            font-size: 1.05rem;
            cursor: pointer;
            transition: background 0.2s, box-shadow 0.2s, transform 0.1s;
            box-shadow: 0 8px 18px -6px rgba(172, 126, 44, 0.4);
            letter-spacing: 0.3px;
        }
        .login-btn:hover {
            background: #9b6f25;
            box-shadow: 0 10px 20px -5px rgba(172, 126, 44, 0.5);
        }
        .login-btn:active {
            transform: scale(0.99);
            background: #8d6421;
        }
        
        /* employee link in gold */
        .employee-link {
            color: #AC7E2C;
            font-weight: 600;
            text-decoration: none;
            font-size: 0.9rem;
            border-bottom: 1.5px dotted rgba(172, 126, 44, 0.5);
            padding-bottom: 2px;
        }
        .employee-link:hover {
            color: #7a591f;
            border-bottom-style: solid;
        }
        
        /* checkbox custom */
        .checkbox-custom {
            accent-color: #AC7E2C;
            width: 1.1rem;
            height: 1.1rem;
            margin-right: 0.5rem;
            vertical-align: middle;
        }
        
        /* session status green — keeps consistency */
        .status-message {
            background: #eef7ea;
            color: #2d6a4f;
            padding: 0.75rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            border-left: 5px solid #40916c;
        }
        
        /* error message */
        .error-text {
            color: #bc3f2e;
            font-size: 0.8rem;
            margin-top: 0.3rem;
            display: block;
        }
        
        /* responsive */
        @media (max-width: 700px) {
            .login-card {
                flex-direction: column;
                max-width: 480px;
                border-radius: 1.8rem;
            }
            .login-image {
                min-height: 200px;
                background-position: center 30%;
            }
            .login-form-wrapper {
                padding: 2rem 1.8rem;
            }
            .image-caption h3 {
                font-size: 1.8rem;
            }
        }
        
        /* extra touch — the image is absolutely placed and blends */
        .image-credit-note {
            position: absolute;
            bottom: 0.75rem;
            right: 1.5rem;
            z-index: 3;
            color: rgba(255,255,240,0.7);
            font-size: 0.7rem;
        }
        
        /* For demo: we simulate the old gradient if user wants, but we override */
        body {
            background: #f6efe8; /* warm neutral */
        }
        /* override any potential background from original inline style */
    </style>
</head>
<body>
    <!-- main container — image + form -->
    <div class="login-card">
        
        <!-- LEFT: IMAGE SECTION (exactly one image aana chahiye) -->
        <div class="login-image">
            <div class="image-overlay"></div>
            <!-- Caption / branding -->
            <div class="image-caption">
                {{-- <h3>crafted<br>moments</h3>
                <p>✦  enter with grace  ✦</p> --}}
            </div>
            <!-- tiny attribution (design element) -->
            {{-- <div class="image-credit-note">— #AC7E2C —</div> --}}
        </div>
        
        <!-- RIGHT: LOGIN FORM (UI sahi kiya with #AC7E2C theme) -->
        <div class="login-form-wrapper">
            
            <h2 class="welcome-title">Admin Login </h2>
            <div class="welcome-sub">sign in to continue</div>
            
            <!-- Session Status (Laravel style) -->
            @if (session('status'))
                <div class="status-message">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Field -->
                <div style="margin-bottom: 1.5rem;">
                    <label class="input-label" for="email">Email address</label>
                    <input type="email" name="email" id="email"
                        value="{{ old('email') }}"
                        class="input-field"
                        placeholder="hello@example.com"
                        required autofocus>
                    
                    @error('email')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Field -->
                <div style="margin-bottom: 1.2rem;">
                    <label class="input-label" for="password">Password</label>
                    <input type="password" name="password" id="password"
                        class="input-field"
                        placeholder="••••••••"
                        required>
                    
                    @error('password')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Row: Remember & Employee Login (styled with gold) -->
                <div style="display: flex; align-items: center; justify-content: space-between; margin: 1.8rem 0 2rem;">
                    <label style="display: flex; align-items: center; cursor: pointer; color: #3a3227;">
                        <input type="checkbox" name="remember" class="checkbox-custom">
                        <span style="margin-left: 0.3rem; font-size: 0.9rem;">Remember me</span>
                    </label>
                    
                    <a href="{{ route('employee.login') }}" class="employee-link">
                         Employee Login
                    </a>
                </div>

                <!-- Submit Button (fully #AC7E2C) -->
                <button type="submit" class="login-btn">
                    Sign in → 
                </button>
                
                <!-- subtle hint -->
                {{-- <p style="text-align: center; margin-top: 1.5rem; font-size: 0.8rem; color: #8f806e;">
                    secure access • #AC7E2C
                </p> --}}
            </form>
            
            <!-- you can keep additional stuff, but UI complete -->
        </div>
    </div>


</body>
</html>