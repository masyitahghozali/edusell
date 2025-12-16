{{-- resources/views/components/app-layout.blade.php --}}
@props(['showSearch' => false])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- This controls the text in the browser tab (change APP_NAME in .env to "EduSell" too) --}}
    <title>{{ config('app.name', 'EduSell') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-[#F9F9F7] overflow-y-scroll">
<div class="min-h-screen flex flex-col">

    {{-- TOP BAR (fixed) --}}
    <header class="bg-[#242C37] text-white shadow fixed top-0 left-0 right-0 z-50">
        <div class="mx-auto max-w-6xl flex items-center justify-between px-6 lg:px-8 py-3">

            {{-- LEFT: EduSell logo + text (click -> homepage/dashboard) --}}
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/edusell-logo.png') }}" class="h-8" alt="EduSell logo">
                <img src="{{ asset('images/edusell-text.png') }}" class="h-6" alt="EduSell text">
            </a>

            {{-- CENTER: Search + Categories (only if $showSearch === true) --}}
            @if($showSearch)
                @php
                    $currentCategory = request('category');
                    $categoryLabel = match ($currentCategory) {
                        'Books'        => 'Books',
                        'Stationaries' => 'Stationaries',
                        'Electronics'  => 'Electronics',
                        'Others'       => 'Others',
                        default        => 'All',
                    };
                @endphp

                <div class="flex-1 flex items-center justify-center gap-3 mx-4">

                    {{-- SEARCH BOX --}}
                    <form
                        action="{{ route('homepage') }}"
                        method="GET"
                        class="flex items-center w-full max-w-md rounded-full bg-[#303744] px-3 h-9"
                    >
                        <img src="{{ asset('images/edusell-search.png') }}"
                             class="h-4 w-4 mr-2 opacity-80"
                             alt="Search">

                        <input
                            type="text"
                            name="q"
                            placeholder="Search"
                            value="{{ request('q') }}"
                            class="w-full bg-transparent border-none text-sm text-slate-100
                                   placeholder:text-slate-400 focus:outline-none focus:ring-0"
                        >

                        {{-- keep selected category when searching --}}
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                    </form>

                    {{-- CATEGORIES DROPDOWN --}}
                    <x-dropdown align="left" width="40">
                        <x-slot name="trigger">
                            <button
                                type="button"
                                class="inline-flex items-center justify-center gap-1 rounded-full border border-[#4B5563]
                                       bg-[#303744] px-3 h-9 text-xs font-medium text-slate-100
                                       hover:bg-[#394250] transition"
                            >
                                <span>{{ $categoryLabel }}</span>
                                <span class="text-[0.65rem]">▼</span>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            {{-- All --}}
                            <x-dropdown-link
                                href="{{ route('homepage', ['q' => request('q')]) }}">
                                All
                            </x-dropdown-link>

                            {{-- Books --}}
                            <x-dropdown-link
                                href="{{ route('homepage', ['q' => request('q'), 'category' => 'Books']) }}">
                                Books
                            </x-dropdown-link>

                            {{-- Stationaries --}}
                            <x-dropdown-link
                                href="{{ route('homepage', ['q' => request('q'), 'category' => 'Stationaries']) }}">
                                Stationaries
                            </x-dropdown-link>

                            {{-- Electronics --}}
                            <x-dropdown-link
                                href="{{ route('homepage', ['q' => request('q'), 'category' => 'Electronics']) }}">
                                Electronics
                            </x-dropdown-link>

                            {{-- Others --}}
                            <x-dropdown-link
                                href="{{ route('homepage', ['q' => request('q'), 'category' => 'Others']) }}">
                                Others
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
            @else
                {{-- keep spacing so right side doesn’t jump when search is hidden --}}
                <div class="flex-1"></div>
            @endif

            {{-- RIGHT: Sell / Like / Inbox / Profile --}}
            <div class="flex items-center gap-2">

                {{-- Sell --}}
                <a href="{{ route('sellitempage') }}"
                   class="inline-flex items-center justify-center rounded-full bg-[#374151]
                          px-5 h-9 text-xs font-semibold text-white hover:bg-[#425067] transition">
                    Sell
                </a>

                {{-- Likes --}}
                <a href="{{ route('likeitempage') }}"
                   class="inline-flex h-9 w-9 items-center justify-center rounded-full
                          bg-[#303744] hover:bg-[#394250] transition">
                    <img src="{{ asset('images/edusell-heart.png') }}" class="h-4 w-4" alt="Liked">
                </a>

                {{-- Inbox / Chat list --}}
                <a href="{{ route('inboxpage') }}"
                   class="inline-flex h-9 w-9 items-center justify-center rounded-full
                          bg-[#303744] hover:bg-[#394250] transition">
                    <img src="{{ asset('images/edusell-chat.png') }}" class="h-4 w-4" alt="Chat">
                </a>

                {{-- Profile dropdown --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button type="button"
                                class="inline-flex h-9 w-9 items-center justify-center rounded-full
                                       bg-[#303744] hover:bg-[#394250] transition">
                            <img src="{{ asset('images/edusell-profile.png') }}" class="h-5 w-5" alt="Profile">
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('myprofilepage')">
                            {{ __('My profile') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('listingpage')">
                            {{ __('My listings') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link href="{{ route('logout') }}"
                                             onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </header>

    {{-- MAIN PAGE CONTENT (pushed down so it doesn’t hide behind fixed header) --}}
    <main class="flex-1 pt-16">
        {{ $slot }}
    </main>
</div>
</body>
</html>
