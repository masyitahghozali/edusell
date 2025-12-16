{{-- resources/views/auth/likeitempage.blade.php --}}
<x-app-layout :showSearch="false">
    <div class="mx-auto max-w-6xl px-6 lg:px-8 py-8">

        {{-- BACK ROW --}}
        <button type="button"
                onclick="window.history.back()"
                class="mb-6 inline-flex items-center gap-2 text-sm text-slate-700 hover:text-slate-900">
            <img src="{{ asset('images/edusell-back.png') }}" class="h-5" alt="Back">
            <span>Likes</span>
        </button>

        {{-- PAGE TITLE --}}
        <h1 class="text-xl font-semibold mb-5 text-slate-800">
            Items you liked
        </h1>

        @if($items->isEmpty())
            <p class="text-sm text-slate-500">
                You haven’t liked any items yet. Tap the heart icon on an item to save it here.
            </p>
        @else
            {{-- LIKES GRID --}}
            <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3">
                @foreach($items as $item)
                    <article class="rounded-2xl bg-white shadow-md p-4 flex flex-col">

                        <a href="{{ route('itemdetailpage', $item) }}" class="block flex-1 flex flex-col">

                            <div class="flex items-center gap-2 mb-3">
                                <div class="h-7 w-7 rounded-full overflow-hidden bg-slate-200">
                                    @if($item->user && $item->user->user_profile_picture)
                                        <img src="{{ asset('storage/'.$item->user->user_profile_picture) }}"
                                             class="h-full w-full object-cover" alt="">
                                    @else
                                        <img src="{{ asset('images/avatar-placeholder.png') }}"
                                             class="h-full w-full object-cover" alt="">
                                    @endif
                                </div>
                                <span class="text-xs text-slate-600">
                                    {{ $item->user?->name ?? 'Student' }}
                                </span>
                            </div>

                            <img src="{{ asset('storage/'.$item->item_image) }}"
                                 class="w-full h-48 rounded-xl object-cover mb-3" alt="{{ $item->item_name }}">

                            <div class="text-sm font-semibold">{{ $item->item_name }}</div>
                            <div class="text-xs font-bold mt-1">RM {{ number_format($item->item_price, 2) }}</div>
                            <div class="text-xs text-slate-500">{{ $item->item_condition }}</div>
                        </a>

                        <div class="mt-2 flex justify-end">
                            <img src="{{ asset('images/edusell-heart.png') }}" class="h-4" alt="liked">
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
