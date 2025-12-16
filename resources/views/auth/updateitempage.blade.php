<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EduSell – Sell an item</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background-color: #F5F5F5;
            color: #111827;
        }

        .page-wrapper { min-height: 100vh; }

        /* NAVBAR (same style as dashboard) */
        .navbar {
            background-color: #111827;
            color: #FFFFFF;
            padding: 0.7rem 3.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            min-width: 170px;
        }

        .navbar-left img.logo { height: 40px; }
        .navbar-left img.logo-text { height: 26px; }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn-sell-nav {
            padding: 0.55rem 1.2rem;
            border-radius: 999px;
            border: none;
            background-color: #1F2937;
            color: #E5E7EB;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-sell-nav.active {
            background-color: #374151;
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
        .profile-menu { position: relative; }
        .profile-dropdown {
            position: absolute;
            right: 0;
            top: 115%;
            background-color: #FFFFFF;
            color: #111827;
            border-radius: 0.75rem;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.25);
            padding: 0.4rem 0;
            min-width: 160px;
            display: none;
            z-index: 30;
        }
        .profile-dropdown a {
            display: block;
            padding: 0.55rem 0.95rem;
            font-size: 0.9rem;
            text-decoration: none;
            color: inherit;
        }
        .profile-dropdown a:hover { background-color: #F3F4F6; }
        .profile-menu:hover .profile-dropdown { display: block; }

        /* CONTENT LAYOUT */
        .content {
            padding: 1.5rem 3.5rem 2.5rem 3.5rem;
        }

        .top-row {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .back-btn {
            width: 38px;
            height: 38px;
            border-radius: 999px;
            border: 1px solid #D1D5DB;
            background-color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1.2rem;
        }

        .page-title {
            font-size: 1.4rem;
            font-weight: 700;
        }

        .sell-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.1fr) minmax(0, 1.2fr);
            gap: 1.5rem;
        }

        .card {
            background-color: #FFFFFF;
            border-radius: 1rem;
            padding: 1.2rem 1.4rem;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        }

        /* PHOTO PANEL */
        .photo-drop {
            border-radius: 0.8rem;
            background-color: #F9FAFB;
            border: 1px solid #E5E7EB;
            height: 220px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .photo-button {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            border-radius: 0.8rem;
            padding: 0.8rem 1.5rem;
            background-color: #111827;
            border: none;
            cursor: pointer;
            color: #F9FAFB;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .photo-button img {
            height: 22px;
            width: 22px;
        }

        .photo-caption {
            font-size: 0.8rem;
            color: #6B7280;
            text-align: center;
        }

        .photo-thumbs {
            display: flex;
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .photo-thumbs img {
            width: 145px;
            height: 185px;
            border-radius: 0.75rem;
            object-fit: cover;
        }

        /* FORM SIDE */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.9rem 1rem;
            margin-bottom: 1.2rem;
        }

        .form-group { display: flex; flex-direction: column; gap: 0.2rem; }

        .form-group.full { grid-column: 1 / -1; }

        label {
            font-size: 0.85rem;
            color: #4B5563;
        }

        input[type="text"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 0.6rem 0.8rem;
            border-radius: 0.6rem;
            border: 1px solid #E5E7EB;
            background-color: #FFFEFC;
            font-size: 0.9rem;
            resize: vertical;
        }

        textarea { min-height: 80px; }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #111827;
            box-shadow: 0 0 0 1px #11182710;
        }

        .btn-primary {
            display: block;
            width: 220px;
            margin: 0.4rem auto 0 auto;
            border-radius: 0.7rem;
            border: none;
            padding: 0.7rem 1.2rem;
            background-color: #111827;
            color: #F9FAFB;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
        }

        /* RESPONSIVE */
        @media (max-width: 960px) {
            .navbar { padding: 0.7rem 1.2rem; }
            .content { padding: 1.2rem; }
            .sell-grid { grid-template-columns: minmax(0, 1fr); }
        }
    </style>
</head>
<body>
<div class="page-wrapper">

    {{-- NAVBAR --}}
    <header class="navbar">
        <div class="navbar-left">
            <img src="{{ asset('images/edusell-logo.png') }}" class="logo" alt="EduSell logo">
            <img src="{{ asset('images/edusell-text.png') }}" class="logo-text" alt="EduSell">
        </div>

        <div class="navbar-right">
            <button class="btn-sell-nav active">Sell</button>

            <button class="icon-button" aria-label="Favourites">
                <img src="{{ asset('images/edusell-heart.png') }}" alt="Heart">
            </button>

            <button class="icon-button" aria-label="Chat">
                <img src="{{ asset('images/edusell-chat.png') }}" alt="Chat">
            </button>

            <div class="profile-menu">
                <button class="icon-button" aria-label="Profile">
                    <img src="{{ asset('images/edusell-profile.png') }}" alt="Profile">
                </button>
                <div class="profile-dropdown">
                    <a href="#">My profile</a>
                    <a href="#">Log out</a>
                </div>
            </div>
        </div>
    </header>

    {{-- CONTENT --}}
    <main class="content">

        <div class="top-row">
            <button class="back-btn" onclick="history.back()">&#8592;</button>
            <div class="page-title">Sell an item</div>
        </div>

        <div class="sell-grid">

            {{-- LEFT: PHOTOS --}}
            <section class="card">
                <div class="photo-drop">
                    <button type="button" class="photo-button">
                        <img src="{{ asset('images/edusell-photo.png') }}" alt="Upload photo">
                        <span>Select Photos</span>
                    </button>
                    <div class="photo-caption">( minimum 2 photos )</div>
                </div>

                <div class="photo-thumbs">
                    <img src="{{ asset('images/sample-atomic-front.jpg') }}" alt="Preview 1">
                    <img src="{{ asset('images/sample-atomic-back.jpg') }}" alt="Preview 2">
                </div>
            </section>

            {{-- RIGHT: FORM --}}
            <section class="card">
                <form>
                    <div class="form-grid">
                        <div class="form-group full">
                            <label for="name">Name</label>
                            <input id="name" type="text" placeholder="">
                        </div>

                        <div class="form-group">
                            <label for="price">Price (RM)</label>
                            <input id="price" type="number" min="0" step="1">
                        </div>

                        <div class="form-group">
                            <label for="condition">Condition</label>
                            <select id="condition">
                                <option value="" selected disabled>Choose condition</option>
                                <option>Brand new</option>
                                <option>Like new</option>
                                <option>Good</option>
                                <option>Fair</option>
                                <option>Heavily used</option>
                            </select>
                        </div>

                        <div class="form-group full">
                            <label for="category">Category</label>
                            <select id="category">
                                <option value="" selected disabled>Choose category</option>
                                <option>Books &amp; Notes</option>
                                <option>Electronics</option>
                                <option>Stationery</option>
                                <option>Clothing</option>
                                <option>Others</option>
                            </select>
                        </div>

                        <div class="form-group full">
                            <label for="description">Description</label>
                            <textarea id="description"></textarea>
                        </div>

                        <div class="form-group full">
                            <label for="status">Status</label>
                            <select id="status">
                                <option value="" selected disabled>Choose status</option>
                                <option>Available</option>
                                <option>Reserved</option>
                                <option>Sold</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary">Sell item</button>
                </form>
            </section>

        </div>
    </main>

</div>
</body>
</html>
