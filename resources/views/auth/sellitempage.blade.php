{{-- resources/views/auth/sellitempage.blade.php --}}
<x-app-layout :showSearch="false">
    <div class="mx-auto max-w-6xl px-6 lg:px-8 py-8">

        <button type="button"
                onclick="window.history.back()"
                class="mb-6 inline-flex items-center gap-2 text-sm text-slate-700 hover:text-slate-900">
            <img src="{{ asset('images/edusell-back.png') }}" class="h-5" alt="Back">
            <span>Sell an item</span>
        </button>

        {{-- errors --}}
        @if($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 border border-red-200 px-4 py-2 text-xs text-red-700">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- success message --}}
        @if(session('success'))
            <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 px-4 py-2 text-xs text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid gap-6 md:grid-cols-2">

                {{-- LEFT: photo upload --}}
                <div class="rounded-xl bg-white shadow-md p-6">

                    <label class="border-2 border-dashed border-slate-300 rounded-xl h-48
                                  flex flex-col items-center justify-center gap-3 cursor-pointer">
                        <img src="{{ asset('images/edusell-photo.png') }}" class="h-9" alt="Upload">
                        <span class="px-5 py-2 rounded-lg bg-[#1E293B] text-white text-sm">
                            Select photo
                        </span>
                        <input type="file" name="item_image" class="hidden" accept="image/*">
                    </label>

                    <p class="mt-3 text-xs text-center text-slate-500">
                        Upload a clear photo of your item.
                    </p>
                </div>

                {{-- RIGHT: fields --}}
                <div class="rounded-xl bg-white shadow-md p-6 space-y-4">

                    <div>
                        <label class="block text-sm font-medium mb-1">Name</label>
                        <input type="text" name="item_name"
                               value="{{ old('item_name') }}"
                               class="w-full rounded-lg border border-slate-300 bg-[#FFFEFC] px-3 py-2 text-sm">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Price (RM)</label>
                            <input type="number" step="0.01" name="item_price"
                                   value="{{ old('item_price') }}"
                                   class="w-full rounded-lg border border-slate-300 bg-[#FFFEFC] px-3 py-2 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Condition</label>
                            <select name="item_condition"
                                    class="w-full rounded-lg border border-slate-300 bg-[#FFFEFC] px-3 py-2 text-sm">
                                <option value="Like new"      {{ old('item_condition')=='Like new' ? 'selected' : '' }}>Like new</option>
                                <option value="Used"          {{ old('item_condition')=='Used' ? 'selected' : '' }}>Used</option>
                                <option value="Good condition"{{ old('item_condition')=='Good condition' ? 'selected' : '' }}>Good condition</option>
                                <option value="Fair"          {{ old('item_condition')=='Fair' ? 'selected' : '' }}>Fair</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Category</label>
                        <select name="item_category"
                                class="w-full rounded-lg border border-slate-300 bg-[#FFFEFC] px-3 py-2 text-sm">
                            <option value="Books"        {{ old('item_category')=='Books' ? 'selected' : '' }}>Books</option>
                            <option value="Electronics"  {{ old('item_category')=='Electronics' ? 'selected' : '' }}>Electronics</option>
                            <option value="Stationery"   {{ old('item_category')=='Stationery' ? 'selected' : '' }}>Stationery</option>
                            <option value="Others"       {{ old('item_category')=='Others' ? 'selected' : '' }}>Others</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Description</label>
                        <textarea name="item_description"
                                  class="w-full rounded-lg border border-slate-300 bg-[#FFFEFC] px-3 py-2 text-sm h-28 resize-none">{{ old('item_description') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Status</label>
                            <select name="item_status"
                                class="w-full rounded-lg border border-slate-300 bg-[#FFFEFC] px-3 py-2 text-sm">
                                <option value="available" {{ old('item_status')=='available' ? 'selected' : '' }}>Available</option>
                                <option value="reserved"  {{ old('item_status')=='reserved' ? 'selected' : '' }}>Reserved</option>
                                <option value="sold"      {{ old('item_status')=='sold' ? 'selected' : '' }}>Sold</option>
                            </select>
                    </div>


                    <button tSype="submit"
                            class="mt-2 w-full rounded-lg bg-[#1F2937] py-2.5 text-sm font-semibold text-white hover:bg-[#111827] transition">
                        Sell item
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
