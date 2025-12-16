{{-- resources/views/auth/itemdetailpage.blade.php --}}
<x-app-layout :showSearch="false">
    <div class="mx-auto max-w-6xl px-6 lg:px-8 py-8">

        {{-- BACK ROW --}}
        <button type="button"
                onclick="window.history.back()"
                class="mb-6 inline-flex items-center gap-2 text-sm text-slate-700 hover:text-slate-900">
            <img src="{{ asset('images/edusell-back.png') }}" class="h-5" alt="Back">
            <span>Item details</span>
        </button>

        {{-- 2-COLUMN LAYOUT --}}
        <div class="grid gap-8 lg:grid-cols-[minmax(0,2fr),minmax(260px,1fr)]">

            {{-- LEFT: ITEM PHOTOS + DETAILS --}}
            <section class="rounded-2xl bg-white shadow-md p-5 lg:p-6 space-y-6">

                {{-- Main photo --}}
                <div class="rounded-xl overflow-hidden bg-slate-100 flex items-center justify-center h-64 md:h-72">
                    @if($item->item_image)
                        <img src="{{ asset('storage/'.$item->item_image) }}"
                             alt="{{ $item->item_name }}"
                             class="h-full w-full object-cover">
                    @else
                        <span class="text-sm text-slate-400">
                            Item photo will appear here
                        </span>
                    @endif
                </div>

                {{-- Title + price --}}
                <div class="space-y-1">
                    <h2 class="text-lg font-semibold text-slate-900">
                        {{ $item->item_name }}
                    </h2>

                    <div class="text-base font-bold text-slate-900">
                        RM {{ number_format($item->item_price, 2) }}
                    </div>
                </div>

                {{-- DETAILS BOXES --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">

                    {{-- Category --}}
                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                        <div class="text-[0.7rem] font-medium tracking-wide text-slate-500 uppercase">
                            Category
                        </div>
                        <div class="mt-1 text-sm font-semibold text-slate-900">
                            {{ $item->item_category }}
                        </div>
                    </div>

                    {{-- Condition --}}
                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                        <div class="text-[0.7rem] font-medium tracking-wide text-slate-500 uppercase">
                            Condition
                        </div>
                        <div class="mt-1 text-sm font-semibold text-slate-900">
                            {{ $item->item_condition }}
                        </div>
                    </div>

                    {{-- Status --}}
                    @php
                        $statusColorBox = match($item->item_status) {
                            'available' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
                            'reserved'  => 'border-amber-200 bg-amber-50 text-amber-700',
                            'sold'      => 'border-slate-200 bg-slate-50 text-slate-700',
                            default     => 'border-slate-200 bg-slate-50 text-slate-700',
                        };
                    @endphp

                    <div class="rounded-xl border px-4 py-3 {{ $statusColorBox }}">
                        <div class="text-[0.7rem] font-medium tracking-wide uppercase">
                            Status
                        </div>
                        <div class="mt-1 text-sm font-semibold">
                            {{ ucfirst($item->item_status) }}
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                <div class="space-y-2">
                    <h3 class="text-sm font-semibold text-slate-800">Description</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        {{ $item->item_description ?? 'No description provided.' }}
                    </p>
                </div>

            </section>

            {{-- RIGHT: SELLER INFO + ACTIONS --}}
            <section class="space-y-4">

                {{-- Seller info --}}
                <div class="rounded-2xl bg-white shadow-md p-6 flex flex-col items-center text-center gap-4">

                    <div class="h-20 w-20 rounded-full overflow-hidden border-2 border-slate-200">
                        @if($item->user && $item->user->user_profile_picture)
                            <img src="{{ asset('storage/'.$item->user->user_profile_picture) }}"
                                 class="h-full w-full object-cover"
                                 alt="Seller photo">
                        @else
                            <img src="{{ asset('images/avatar-placeholder.png') }}"
                                 class="h-full w-full object-cover"
                                 alt="Seller photo">
                        @endif
                    </div>

                    <div class="space-y-0.5">
                        <div class="text-base font-semibold text-slate-900">
                            {{ $item->user?->name ?? 'Student seller' }}
                        </div>
                        <div class="text-xs text-slate-500">
                            {{ $item->user?->user_faculty ?? 'Faculty not set' }}
                        </div>
                    </div>

                    <hr class="w-full border-slate-200">

                    <div class="space-y-2 text-xs text-slate-600 leading-relaxed">
                        <p class="font-semibold text-slate-800">⚠ Important</p>
                        <p>All payments are made during meet-up, and returns depend on the seller.</p>
                        <p>EduSell does not support online payments or delivery.</p>
                        <p>Always meet in a safe, public place.</p>
                    </div>

                    {{-- Check account --}}
                    @if($item->user)
                        <a href="{{ route('otherprofilepage', $item->user) }}"
                           class="w-full min-w-[150px] inline-flex items-center justify-center rounded-xl
                                  bg-[#B91C1C] py-2.5 text-sm font-semibold text-white hover:bg-[#991B1B] transition">
                            Check account
                        </a>
                    @endif
                </div>

                {{-- Chat + favourite --}}
                <div class="rounded-2xl bg-white shadow-md p-5 space-y-4 flex flex-col items-center text-center">

                    {{-- Only show Chat seller if the viewer is not the seller --}}
                    @if($item->user && $item->user->id !== auth()->id())
                        {{-- Route has only {user}; "item" becomes ?item=ID --}}
                        <a href="{{ route('chatpage', ['user' => $item->user->id, 'item' => $item->id]) }}"
                           class="w-full min-w-[150px] inline-flex items-center justify-center rounded-xl bg-[#111827]
                                  py-2.5 text-sm font-semibold text-white hover:bg-black transition">
                            Chat seller
                        </a>
                    @endif

                    <button type="button"
                            class="inline-flex items-center gap-2 text-amber-400 text-sm font-medium hover:text-amber-500">
                        <span class="text-xl leading-none">♡</span>
                        <span>Add to favourites</span>
                    </button>

                    <p class="text-[0.7rem] text-slate-500">p/s: first come, first serve.</p>
                </div>

            </section>

        </div>
    </div>
</x-app-layout>
