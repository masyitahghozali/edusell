<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EduSell – Forgot Password</title>
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
            display: block;
            margin: 0 auto 1.5rem auto;
        }

        .left-caption {
            font-size: 1.2rem;
            letter-spacing: 0.08em;
            color: #d0d6e2;
            font-weight: 400;
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

        .login-card {
            width: 100%;
            max-width: 420px;
        }

        .brand-row {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 2.5rem;
        }

        .brand-logo { height: 48px; }

        .login-title {
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 1.5rem;
            color: #111827;
        }

        .description {
            text-align: center;
            color: #4b5563;
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        /* INPUT */
        input[type="email"] {
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

        .form-group { margin-bottom: 1.25rem; }

        .btn-reset {
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

        .signin-row {
            margin-top: 1.25rem;
            text-align: center;
            font-size: 0.9rem;
            color: #6b7280;
        }

        .signin-row a {
            color: #111827;
            text-decoration: none;
            font-weight: 500;
        }

    </style>
</head>
<body>

<div class="page-wrapper">

    {{-- LEFT SECTION --}}
    <div class="left-panel">
        <img src="{{ asset('images/edusell-logo.png') }}" class="left-logo">
        <img src="{{ asset('images/edusell-hero-bag.jpg') }}" class="left-illustration">
        <p class="left-caption">BUY &amp; SELL SMARTER ON CAMPUS</p>
    </div>

    {{-- RIGHT SECTION --}}
    <div class="right-panel">
        <div class="login-card">

            <div class="brand-row">
                <img src="{{ asset('images/edusell-logo.png') }}" style="height:48px;">
                <img src="{{ asset('images/edusell-text-black.png') }}" class="brand-logo">
            </div>

            <h1 class="login-title">Forgot Password</h1>

            <p class="description">
                Enter your email and we’ll send you a link to reset your password.
            </p>

            <!-- success message -->
            @if (session('status'))
                <div style="margin-bottom: 1rem; color: #047857; font-size: 0.9rem; text-align:center;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <input
                        type="email"
                        name="email"
                        required
                        placeholder="Email"
                        value="{{ old('email') }}"
                    >
                    @error('email')
                    <div style="color:#b91c1c; font-size:0.85rem; margin-top:0.3rem;">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <button type="submit" class="btn-reset">Reset Password</button>

                <div class="signin-row">
                    Remember your password?
                    <a href="{{ route('login') }}">Sign in</a>
                </div>

            </form>

        </div>
    </div>

</div>

</body>
</html>
