{{-- resources/views/auth/otherprofilepage.blade.php --}}
<x-app-layout :showSearch="false">
    <div class="mx-auto max-w-6xl px-6 lg:px-8 py-8" x-data="{ tab: 'listings' }">

        {{-- BACK ROW --}}
        <button type="button"
                onclick="window.history.back()"
                class="mb-6 inline-flex items-center gap-2 text-sm text-slate-700 hover:text-slate-900">
            <img src="{{ asset('images/edusell-back.png') }}" class="h-5" alt="Back">
            <span>Profile</span>
        </button>

        {{-- PAGE TITLE --}}
        <h1 class="text-center text-2xl font-semibold mb-8 text-slate-900">
            Profile
        </h1>

        {{-- TOP PROFILE CARD --}}
        <section class="mb-10 rounded-2xl bg-white shadow-md px-6 py-8 md:px-10 md:py-9">
            <div class="flex flex-col items-center gap-6">

                {{-- Avatar --}}
                <div class="h-32 w-32 rounded-full border-2 border-slate-200 overflow-hidden shadow-sm">
                    @if($user->user_profile_picture)
                        <img src="{{ asset('storage/'.$user->user_profile_picture) }}"
                             alt="User photo"
                             class="h-full w-full object-cover">
                    @else
                        <img src="{{ asset('images/avatar-placeholder.png') }}"
                             alt="User photo"
                             class="h-full w-full object-cover">
                    @endif
                </div>

                {{-- Name + Matric --}}
                <div class="text-center space-y-1">
                    <div class="text-xl font-semibold text-slate-900">
                        {{ $user->name ?? 'Student seller' }}
                    </div>
                    <div class="text-xs text-slate-500">
                        Matric ID • {{ $user->user_matric_id ?? 'Not set' }}
                    </div>
                </div>

                {{-- Info row --}}
                <div class="mt-4 w-full border-t border-slate-100 pt-6">
                    <div class="grid gap-6 sm:grid-cols-3 text-sm text-slate-800">

                        <div class="space-y-1">
                            <div class="text-[0.7rem] font-semibold text-slate-500 uppercase tracking-wide">
                                Matric ID
                            </div>
                            <div class="font-medium">
                                {{ $user->user_matric_id ?? 'Not set' }}
                            </div>
                        </div>

                        <div class="space-y-1 sm:border-l sm:border-slate-100 sm:pl-6">
                            <div class="text-[0.7rem] font-semibold text-slate-500 uppercase tracking-wide">
                                Faculty
                            </div>
                            <div class="font-medium">
                                {{ $user->user_faculty ?? 'Not set' }}
                            </div>
                        </div>

                        <div class="space-y-1 sm:border-l sm:border-slate-100 sm:pl-6">
                            <div class="text-[0.7rem] font-semibold text-slate-500 uppercase tracking-wide">
                                Campus
                            </div>
                            <div class="font-medium">
                                {{ $user->user_location ?? 'Not set' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- TABS --}}
        <div class="border-b border-slate-200 mb-6 flex items-center justify-center gap-10 text-sm">
            <button type="button"
                    @click="tab = 'listings'"
                    :class="tab === 'listings'
                            ? 'pb-2 border-b-2 border-slate-900 font-semibold text-slate-900'
                            : 'pb-2 text-slate-500 hover:text-slate-800'">
                Listings
            </button>

            <button type="button"
                    @click="tab = 'ratings'"
                    :class="tab === 'ratings'
                            ? 'pb-2 border-b-2 border-slate-900 font-semibold text-slate-900'
                            : 'pb-2 text-slate-500 hover:text-slate-800'">
                Ratings
            </button>
        </div>

        {{-- LISTINGS TAB --}}
        <section x-show="tab === 'listings'" x-cloak>
            @if($items->isEmpty())
                <p class="text-sm text-slate-500 text-center">
                    This user has no active listings yet.
                </p>
            @else
                <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3">
                    @foreach($items as $item)
                        <article class="rounded-2xl bg-white shadow-md overflow-hidden flex flex-col">
                            <a href="{{ route('itemdetailpage', $item) }}" class="block">

                                @if($item->item_image)
                                    <img src="{{ asset('storage/'.$item->item_image) }}"
                                         class="w-full h-40 object-cover"
                                         alt="{{ $item->item_name }}">
                                @else
                                    <div class="w-full h-40 flex items-center justify-center bg-slate-100 text-xs text-slate-400">
                                        No photo
                                    </div>
                                @endif

                                <div class="p-4 flex-1 flex flex-col gap-3">
                                    <div class="flex items-start justify-between gap-2">
                                        <div>
                                            <h2 class="text-sm font-semibold text-slate-900">
                                                {{ $item->item_name }}
                                            </h2>
                                            <div class="mt-1 text-sm">
                                                <span class="font-bold text-slate-900">
                                                    RM {{ number_format($item->item_price, 2) }}
                                                </span>
                                                <span class="ml-2 text-xs text-slate-500">
                                                    {{ $item->item_condition }}
                                                </span>
                                            </div>
                                        </div>

                                        <span class="inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-[0.7rem] text-slate-600">
                                            {{ $item->item_category }}
                                        </span>
                                    </div>

                                    <p class="text-[0.7rem] text-slate-500">
                                        Listed • {{ $item->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>

        {{-- RATINGS TAB (still static UI for now) --}}
        <section x-show="tab === 'ratings'" x-cloak>
            <div class="space-y-4">
                <p class="text-sm text-slate-500 text-center">
                    Ratings feature is not implemented yet.
                </p>
            </div>
        </section>
    </div>
</x-app-layout>
