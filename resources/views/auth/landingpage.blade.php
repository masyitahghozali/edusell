<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSell – Buy & Sell on Campus</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background-color: #242C37; /* your background */
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .landing-wrapper {
            width: 100%;
            max-width: 900px;
            padding: 32px 16px;
        }

        .card {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .brand-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }

        .brand-logo {
            height: 72px;      /* adjust if too big/small */
            width: auto;
        }

        .brand-text {
            height: 80px;      /* adjust as needed */
            width: auto;
        }

        .hero-image {
            display: block;
            margin-bottom: 32px;
            max-width: 100%;
            border-radius: 0px;
        }

        h1 {
            font-size: 30px;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            margin-bottom: 32px;
        }

        .btn-primary {
            display: inline-block;
            padding: 12px 140px;
            border-radius: 7px;
            border: none;
            background-color: #ffffff;
            color: #242C37;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 150ms ease, transform 150ms ease, box-shadow 150ms ease;
        }

        .btn-primary:hover {
            background-color: #f3f3f3;
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.35);
        }

        .btn-primary:active {
            transform: translateY(0);
            box-shadow: none;
        }

        .subtext {
            margin-top: 16px;
            font-size: 14px;
            color: #c7cdd8;
        }

        .subtext a {
            color: #ffffff;
            font-weight: 500;
            text-decoration: none;
        }

        .subtext a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="landing-wrapper">
    <div class="card">

        {{-- Top row: logo + "EduSell" word image --}}
        <div class="brand-row">
            <img src="{{ asset('images/edusell-logo.png') }}" alt="EduSell logo" class="brand-logo">
            <img src="{{ asset('images/edusell-text.png') }}" alt="EduSell" class="brand-text">
        </div>

        {{-- Bag illustration --}}
        <img src="{{ asset('images/edusell-hero-bag.jpg') }}"
             alt="Student handing bag and shoes"
             class="hero-image">

        {{-- Tagline --}}
        <h1>BUY &amp; SELL SMARTER ON CAMPUS</h1>

        {{-- Sign in button – goes to Laravel login route --}}
        <form action="{{ route('login') }}" method="get">
            <button type="submit" class="btn-primary">
                Sign in
            </button>
        </form>

        {{-- Sign up link --}}
        <p class="subtext">
            Don’t have an account?
            <a href="{{ route('register') }}">Sign up</a>
        </p>
    </div>
</div>

</body>
</html>
