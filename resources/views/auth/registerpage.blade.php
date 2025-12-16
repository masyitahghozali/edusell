<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EduSell – Sign up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background-color: #f5f5f5;
        }

        .page-wrapper { display: flex; min-height: 100vh; }

        /* LEFT SIDE */
        .left-panel {
            flex: 1;
            background-color: #242C37;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            text-align: center;
            transform: translateX(50px);
            opacity: 0;
            animation: slideLeft 0.7s ease-out forwards;
        }

        @keyframes slideLeft {
            to { transform: translateX(0); opacity: 1; }
        }

        .left-logo { width: 65px; margin-bottom: 2rem; }
        .left-illustration {
            width: 80%;
            max-width: 480px;
            margin: 0 auto 1.5rem auto;
        }

        .left-caption {
            font-size: 1.2rem;
            letter-spacing: 0.08em;
            color: #d0d6e2;
            font-weight: 700;
        }

        /* RIGHT SIDE */
        .right-panel {
            flex: 1;
            background-color: #FAFAF8;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 3rem 5rem;
        }

        .login-card { width: 100%; max-width: 420px; }

        .brand-row {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 2.5rem;
        }

        .brand-logo { height: 50px; }

        .login-title {
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 1.75rem;
            color: #111827;
        }

        /* INPUT / BOX STYLING */
        .form-group {
            margin-bottom: 1.25rem;
            position: relative;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.75rem 0.9rem;
            border-radius: 8px;
            border: 1px solid #E6E5E3;
            background-color: #FFFEFC;
            font-size: 0.95rem;
        }

        input:focus {
            outline: none;
            border-color: #111827;
            background-color: #FFFEFC !important;
            box-shadow: 0 0 0 1px #11182710;
        }

        /* red star inside input */
        .form-group.required::after {
            content: "*";
            color: red;
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1rem;
            font-weight: 700;
        }

        .terms-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
            color: #4b5563;
            margin: 0.5rem 0 1.4rem;
        }

        .terms-left {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .view-link {
            font-size: 0.88rem;
            color: #111827;
            text-decoration: none;
            font-weight: 500;
        }

        .btn-signin {
            width: 100%;
            border: none;
            border-radius: 8px;
            padding: 0.85rem;
            font-size: 1rem;
            font-weight: 500;
            background-color: #242C37;
            color: #ffffff;
            cursor: pointer;
        }

        .signup-row {
            margin-top: 1.25rem;
            text-align: center;
            font-size: 0.95rem;
            color: #6b7280;
        }

        .signup-row a {
            color: #111827;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
<div class="page-wrapper">

    <!-- LEFT SECTION -->
    <div class="left-panel">
        <img src="{{ asset('images/edusell-logo.png') }}" class="left-logo">
        <img src="{{ asset('images/edusell-hero-bag.jpg') }}" class="left-illustration">
        <p class="left-caption">BUY &amp; SELL SMARTER ON CAMPUS</p>
    </div>

    <!-- RIGHT SECTION -->
    <div class="right-panel">
        <div class="login-card">

            <div class="brand-row">
                <img src="{{ asset('images/edusell-logo.png') }}" style="height:48px;">
                <img src="{{ asset('images/edusell-text-black.png') }}" class="brand-logo">
            </div>

            <h1 class="login-title">Sign up</h1>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- EMAIL ONLY --}}
                <div class="form-group required">
                    <input
                        type="email"
                        name="email"
                        placeholder="Email"
                        value="{{ old('email') }}"
                        required
                    >
                </div>

                {{-- PASSWORD --}}
                <div class="form-group required">
                    <input
                        type="password"
                        name="password"
                        placeholder="Password"
                        required
                    >
                </div>

                {{-- PASSWORD CONFIRMATION --}}
                <div class="form-group required">
                    <input
                        type="password"
                        name="password_confirmation"
                        placeholder="Password confirmation"
                        required
                    >
                </div>

                <!-- TERMS -->
                <div class="terms-row">
                    <div class="terms-left">
                        <input type="checkbox" id="terms" required>
                        <label for="terms">I agree with terms &amp; conditions</label>
                    </div>

                    <a href="#" class="view-link">view</a>
                </div>

                <button type="submit" class="btn-signin">Sign up</button>

                <div class="signup-row">
                    Already have an account?
                    <a href="{{ route('login') }}">Sign in</a>
                </div>

            </form>
        </div>
    </div>

</div>
</body>
</html>
