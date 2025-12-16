<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EduSell – Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background-color: #F3F4F6;
            color: #111827;
        }

        .page-wrapper {
            min-height: 100vh;
            background-color: #F3F4F6;
        }

        /* TOP NAVBAR */
        .navbar {
            background-color: #111827;
            color: #FFFFFF;
            padding: 0.7rem 3.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            min-width: 170px;
        }

        .navbar-left img.logo {
            height: 40px;
        }

        .navbar-left img.logo-text {
            height: 26px;
        }

        .navbar-center {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 1rem;
            max-width: 650px;
        }

        /* SEARCH */
        .search-wrapper {
            flex: 1;
            position: relative;
        }

        .search-wrapper input {
            width: 100%;
            padding: 0.55rem 0.9rem 0.55rem 2.4rem;
            border-radius: 999px;
            border: none;
            background-color: #111827;
            outline: 1px solid #4B5563;
            color: #F9FAFB;
            font-size: 0.9rem;
        }

        .search-wrapper input::placeholder {
            color: #9CA3AF;
        }

        .search-icon {
            position: absolute;
            top: 50%;
            left: 0.75rem;
            transform: translateY(-50%);
            height: 16px;
            width: 16px;
            opacity: 0.85;
        }

        /* CATEGORY DROPDOWN (visual only) */
        .category-select {
            display: flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.55rem 0.9rem;
            border-radius: 999px;
            border: 1px solid #4B5563;
            background-color: #111827;
            color: #E5E7EB;
            font-size: 0.85rem;
            cursor: pointer;
            white-space: nowrap;
        }

        .category-select span.chevron {
            font-size: 0.8rem;
            opacity: 0.7;
        }

        /* RIGHT SECTION */
        .navbar-right {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn-sell {
            padding: 0.55rem 1.2rem;
            border-radius: 999px;
            border: none;
            background-color: #FACC15;
            color: #111827;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
        }

        .icon-button {
            width: 36px;
            height: 36px;
            border-radius: 999px;
            border: none;
            background-color: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            padding: 0;
        }

        .icon-button img {
            height: 20px;
            width: 20px;
        }

        /* PROFILE DROPDOWN */
        .profile-menu {
            position: relative;
        }

        .profile-dropdown {
            position: absolute;
            right: 0;
            top: 115%;
            background-color: #FFFFFF;
            color: #111827;
            border-radius: 0.75rem;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.25);
            padding: 0.4rem 0;
            min-width: 170px;
            display: none;
        }

        .profile-dropdown a {
            display: block;
            padding: 0.55rem 0.95rem;
            font-size: 0.9rem;
            text-decoration: none;
            color: inherit;
        }

        .profile-dropdown a:hover {
            background-color: #F3F4F6;
        }

        /* show dropdown on hover – just interface */
        .profile-menu:hover .profile-dropdown {
            display: block;
        }

        /* PAGE HEADING */
        .page-header {
            padding: 1.5rem 3.5rem 0.75rem 3.5rem;
        }

        .page-header h1 {
            margin: 0;
            font-size: 1.6rem;
            font-weight: 700;
        }

        .page-header span {
            font-size: 0.9rem;
            color: #6B7280;
        }

        /* PRODUCT GRID */
        .products-section {
            padding: 0.25rem 3.5rem 2.5rem 3.5rem;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
            gap: 1.5rem;
        }

        .product-card {
            background-color: #FFFFFF;
            border-radius: 1rem;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
            padding: 0.9rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .product-card-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.78rem;
            color: #4B5563;
        }

        .product-card-header img.avatar {
            width: 26px;
            height: 26px;
            border-radius: 999px;
            object-fit: cover;
        }

        .product-image-wrapper {
            margin-top: 0.2rem;
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .product-image-wrapper img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
        }

        .product-title {
            font-size: 0.95rem;
            font-weight: 600;
            margin-top: 0.35rem;
        }

        .product-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.85rem;
            margin-top: 0.1rem;
        }

        .product-price {
            font-weight: 700;
        }

        .product-condition {
            font-size: 0.8rem;
            color: #6B7280;
        }

        .product-fav {
            border: none;
            background: none;
            padding: 0;
            cursor: pointer;
        }

        .product-fav img {
            height: 18px;
            width: 18px;
        }

        /* RESPONSIVE */
        @media (max-width: 900px) {
            .navbar {
                padding: 0.7rem 1rem;
            }

            .page-header,
            .products-section {
                padding: 1rem;
            }

            .navbar-center {
                display: none; /* simplify on small screens */
            }
        }

    </style>
</head>
<body>
<div class="page-wrapper">

    {{-- NAVBAR --}}
    <header class="navbar">
        <div class="navbar-left">
            <img src="{{ asset('images/edusell-logo.png') }}" alt="EduSell logo" class="logo">
            <img src="{{ asset('images/edusell-text.png') }}" alt="EduSell" class="logo-text">
        </div>

        <div class="navbar-center">
            <div class="search-wrapper">
                <img src="{{ asset('images/edusell-search.png') }}" alt="Search" class="search-icon">
                <input type="text" placeholder="Search">
            </div>

            <div class="category-select">
                <span>Categories</span>
                <span class="chevron">▾</span>
            </div>
        </div>

        <div class="navbar-right">
            {{-- Sell button -> sellitempage.blade.php --}}
            <button
                class="btn-sell"
                onclick="window.location.href='{{ url('/sell-item') }}'">
                Sell
            </button>

            {{-- Heart icon -> likeitempage.blade.php --}}
            <button
                class="icon-button"
                aria-label="Favourites"
                onclick="window.location.href='{{ url('/likes') }}'">
                <img src="{{ asset('images/edusell-heart.png') }}" alt="Favourites">
            </button>

            {{-- Chat icon -> inboxpage.blade.php --}}
            <button
                class="icon-button"
                aria-label="Messages"
                onclick="window.location.href='{{ url('/inbox') }}'">
                <img src="{{ asset('images/edusell-chat.png') }}" alt="Chat">
            </button>

            {{-- Profile dropdown --}}
            <div class="profile-menu">
                <button class="icon-button" aria-label="Profile">
                    <img src="{{ asset('images/edusell-profile.png') }}" alt="Profile">
                </button>

                <div class="profile-dropdown">
                    {{-- My profile -> myprofilepage.blade.php --}}
                    <a href="{{ url('/my-profile') }}">My profile</a>

                    {{-- My listings -> listingpage.blade.php --}}
                    <a href="{{ url('/my-listings') }}">My listings</a>

                    {{-- Log out (interface only – wire to logout route later) --}}
                    <a href="#">Log out</a>
                </div>
            </div>
        </div>
    </header>

    {{-- PAGE TITLE --}}
    <section class="page-header">
        <h1>Edusell™ – Academic Goods, Student Hands.</h1>
    </section>

    {{-- PRODUCT GRID (static sample cards; replace with @foreach later) --}}
    <section class="products-section">
        <div class="product-grid">
            {{-- Card 1 --}}
            <article class="product-card">
                <div class="product-card-header">
                    <img src="{{ asset('images/sample-avatar-1.jpg') }}" class="avatar" alt="">
                    <span>Masyitah Ghozali</span>
                </div>

                <div class="product-image-wrapper">
                    <img src="{{ asset('images/sample-product-atomic-habits.jpg') }}" alt="Atomic Habits">
                </div>

                <div class="product-title">Atomic Habits</div>

                <div class="product-meta">
                    <div>
                        <div class="product-price">RM 35</div>
                        <div class="product-condition">Like new</div>
                    </div>
                    <button class="product-fav">
                        <img src="{{ asset('images/edusell-heart.png') }}" alt="Favourite">
                    </button>
                </div>
            </article>

            {{-- Card 2 --}}
            <article class="product-card">
                <div class="product-card-header">
                    <img src="{{ asset('images/sample-avatar-2.jpg') }}" class="avatar" alt="">
                    <span>Noor Fakhira</span>
                </div>

                <div class="product-image-wrapper">
                    <img src="{{ asset('images/sample-product-headphone.jpg') }}" alt="Headphone">
                </div>

                <div class="product-title">Edifier W820NB Headphone</div>

                <div class="product-meta">
                    <div>
                        <div class="product-price">RM 100</div>
                        <div class="product-condition">Lightly used</div>
                    </div>
                    <button class="product-fav">
                        <img src="{{ asset('images/edusell-heart.png') }}" alt="Favourite">
                    </button>
                </div>
            </article>

            {{-- Card 3 --}}
            <article class="product-card">
                <div class="product-card-header">
                    <img src="{{ asset('images/sample-avatar-1.jpg') }}" class="avatar" alt="">
                    <span>Masyitah Ghozali</span>
                </div>

                <div class="product-image-wrapper">
                    <img src="{{ asset('images/sample-product-atomic-habits.jpg') }}" alt="Atomic Habits">
                </div>

                <div class="product-title">Atomic Habits</div>

                <div class="product-meta">
                    <div>
                        <div class="product-price">RM 35</div>
                        <div class="product-condition">Like new</div>
                    </div>
                    <button class="product-fav">
                        <img src="{{ asset('images/edusell-heart.png') }}" alt="Favourite">
                    </button>
                </div>
            </article>

            {{-- add more <article class="product-card">…</article> as needed --}}
        </div>
    </section>

</div>
</body>
</html>
