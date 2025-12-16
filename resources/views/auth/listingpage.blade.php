{{-- resources/views/auth/listingpage.blade.php --}}
<x-app-layout :showSearch="false">
    <div class="mx-auto max-w-6xl px-6 lg:px-8 py-8">
        <button type="button"
                onclick="window.history.back()"
                class="mb-6 inline-flex items-center gap-2 text-sm text-slate-700 hover:text-slate-900">
            <img src="{{ asset('images/edusell-back.png') }}" class="h-5" alt="Back">
            <span>My listings</span>
        </button>

        <h1 class="text-xl font-semibold mb-5 text-slate-800">
            My Listings
        </h1>

        @if(session('success'))
            <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 px-4 py-2 text-xs text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if($items->isEmpty())
            <p class="text-sm text-slate-500">
                You haven’t listed any items yet. Click “Sell” in the top bar to add one.
            </p>
        @else
            <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3">
                @foreach($items as $item)
                    <article class="rounded-2xl bg-white shadow-md overflow-hidden flex flex-col">

                        {{-- Image --}}
                        @if($item->item_image)
                            <img src="{{ asset('storage/'.$item->item_image) }}"
                                 class="w-full h-40 object-cover"
                                 alt="{{ $item->item_name }}">
                        @else
                            <img src="{{ asset('images/sample-placeholder.jpg') }}"
                                 class="w-full h-40 object-cover"
                                 alt="No image">
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

                            <div class="mt-1 grid grid-cols-1 gap-2 text-[0.7rem] text-slate-500">
                                <div class="flex items-center justify-between">
                                    <span>Condition</span>
                                    <span class="font-medium text-slate-800">{{ $item->item_condition }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Last updated</span>
                                    <span class="font-medium text-slate-800">{{ $item->updated_at->diffForHumans() }}</span>
                                </div>
                            </div>

                            <hr class="border-slate-100 my-1">

                            <div class="mt-auto flex flex-col gap-2">
                                <div class="flex items-center gap-2">
                                    <span class="text-[0.7rem] font-medium text-slate-500">
                                        Status
                                    </span>
                                    <select disabled
                                        class="flex-1 rounded-lg border border-slate-300 bg-[#FFFEFC] px-3 py-1.5 text-xs text-slate-800">
                                        <option value="available" {{ $item->item_status=='available' ? 'selected' : '' }}>
                                            Available
                                        </option>
                                        <option value="reserved" {{ $item->item_status=='reserved' ? 'selected' : '' }}>
                                            Reserved
                                        </option>
                                        <option value="sold" {{ $item->item_status=='sold' ? 'selected' : '' }}>
                                            Sold
                                        </option>
                                    </select>
                                </div>

                                <div class="flex gap-2">
                                    <a href="{{ route('items.edit', $item->item_id) }}"
                                       class="flex-1 inline-flex items-center justify-center rounded-lg bg-[#1F2937] px-3 py-1.5 text-xs font-semibold text-white hover:bg-[#111827] transition">
                                        Edit
                                    </a>

                                    <form action="{{ route('items.destroy', $item->item_id) }}"
                                          method="POST"
                                          class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-full inline-flex items-center justify-center rounded-lg border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 transition"
                                                onclick="return confirm('Delete this item?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
