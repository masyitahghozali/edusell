{{-- resources/views/auth/homepage.blade.php --}}
<x-app-layout :showSearch="true">
    <div class="mx-auto max-w-6xl px-6 lg:px-8 py-8">
        <h1 class="text-center text-2xl font-semibold mb-5">
            EduSell™ – Academic Goods, Student Hands.
        </h1>

        {{-- NO ITEMS MESSAGE --}}
        @if($items->isEmpty())
            <p class="text-sm text-slate-500 text-center">
                No items found. Try changing your search or category.
            </p>
        @else
            {{-- Product grid --}}
            <section class="grid gap-6 sm:grid-cols-2 md:grid-cols-3">
                @foreach($items as $item)
                    @php
                        $isLiked = in_array($item->item_id, $likedItemIds ?? []);
                    @endphp

                    <article
                        class="flex flex-col rounded-2xl bg-[#FFFEFC] border border-[#EDEDEB] p-3 shadow-sm">

                        {{-- Make the whole middle part clickable --}}
                        <a href="{{ route('itemdetailpage', $item) }}" class="block">

                            {{-- Seller row --}}
                            <div class="mb-2 flex items-center gap-2">
                                <div class="h-7 w-7 rounded-full overflow-hidden bg-slate-200">
                                    @if($item->user && $item->user->user_profile_picture)
                                        <img src="{{ asset('storage/'.$item->user->user_profile_picture) }}"
                                             alt="Seller avatar"
                                             class="h-full w-full object-cover">
                                    @else
                                        <img src="{{ asset('images/avatar-placeholder.png') }}"
                                             alt="Seller avatar"
                                             class="h-full w-full object-cover">
                                    @endif
                                </div>
                                <div class="text-xs text-slate-600">
                                    {{ $item->user?->name ?? 'Student' }}
                                </div>
                            </div>

                            {{-- Item image --}}
                            <div class="mb-2 h-52 rounded-xl overflow-hidden bg-[#F3F4F6] flex items-center justify-center">
                                @if($item->item_image)
                                    <img src="{{ asset('storage/'.$item->item_image) }}"
                                         alt="{{ $item->item_name }}"
                                         class="h-full w-full object-cover">
                                @else
                                    <span class="text-[0.8rem] text-slate-400">
                                        Item photo will appear here
                                    </span>
                                @endif
                            </div>

                            {{-- Item title --}}
                            <div class="text-sm font-semibold mb-0.5">
                                {{ $item->item_name }}
                            </div>

                            {{-- Price --}}
                            <div class="text-xs mb-0.5">
                                <span class="font-bold">RM {{ number_format($item->item_price, 2) }}</span>
                            </div>

                            {{-- Condition --}}
                            <div class="text-[0.75rem] text-slate-500">
                                {{ $item->item_condition }}
                            </div>
                        </a>

                        {{-- Footer row (time + like) --}}
                        <div class="mt-2 flex items-center justify-between text-[0.7rem] text-slate-400">
                            <span>{{ $item->updated_at->diffForHumans() }}</span>

                            <form method="POST" action="{{ route('items.toggle-like', $item) }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center justify-center">
                                    <img
                                        src="{{ $isLiked
                                                ? asset('images/edusell-heart.png')
                                                : asset('images/edusell-heart-half.png') }}"
                                        class="h-4 w-4"
                                        alt="Like">
                                </button>
                            </form>
                        </div>
                    </article>
                @endforeach
            </section>
        @endif
    </div>
</x-app-layout>
