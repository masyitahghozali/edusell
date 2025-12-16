{{-- resources/views/auth/chatpage.blade.php --}}
<x-app-layout :showSearch="false">
    <div class="mx-auto max-w-6xl px-6 lg:px-8 py-8">

        <button type="button"
                onclick="window.history.back()"
                class="mb-4 inline-flex items-center gap-2 text-sm text-slate-700 hover:text-slate-900">
            <img src="{{ asset('images/edusell-back.png') }}" class="h-5" alt="Back">
            <span>Back</span>
        </button>

        {{-- Chat header --}}
        <h1 class="text-center text-2xl font-semibold mb-5">
            {{ $otherUser->name }}
        </h1>

        <section class="rounded-2xl bg-white shadow-md flex flex-col h-[520px] md:h-[560px]">

            {{-- Item pill --}}
            <div class="px-4 pt-4 pb-3 flex justify-center">
                <div class="inline-flex items-center gap-3 rounded-2xl bg-slate-50 border border-slate-200 px-4 py-3">
                    <div class="h-12 w-12 rounded-lg overflow-hidden bg-slate-200 flex-shrink-0">
                        @if($item->item_image)
                            <img src="{{ asset('storage/'.$item->item_image) }}"
                                 alt="{{ $item->item_name }}"
                                 class="h-full w-full object-cover">
                        @else
                            <div class="h-full w-full flex items-center justify-center text-[0.7rem] text-slate-400">
                                No image
                            </div>
                        @endif
                    </div>
                    <div class="text-xs md:text-sm">
                        <div class="font-semibold text-slate-900">
                            {{ $item->item_name }}
                        </div>
                        <div class="mt-0.5 text-[0.8rem] text-slate-600">
                            RM {{ number_format($item->item_price, 2) }}
                        </div>
                    </div>
                </div>
            </div>

            <hr class="border-slate-200">

            {{-- Messages --}}
            <div class="flex-1 overflow-y-auto px-4 py-4 space-y-4 bg-slate-50/60">
                @php $currentId = auth()->id(); @endphp

                @forelse($messages as $message)
                    @if($message->chat_by_id === $currentId)
                        {{-- My message (right) --}}
                        <div class="flex justify-end">
                            <div class="max-w-[70%] rounded-2xl bg-slate-100 px-3 py-2 text-xs md:text-sm text-slate-800">
                                {{ $message->chat_message }}
                                <div class="mt-1 text-[0.65rem] text-slate-400 text-right">
                                    {{ $message->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- Other user message (left) --}}
                        <div class="flex items-end gap-2">
                            <div class="h-9 w-9 rounded-full overflow-hidden bg-slate-200 flex-shrink-0">
                                @if($otherUser->user_profile_picture)
                                    <img src="{{ asset('storage/'.$otherUser->user_profile_picture) }}"
                                         alt="Avatar"
                                         class="h-full w-full object-cover">
                                @else
                                    <img src="{{ asset('images/avatar-placeholder.png') }}"
                                         alt="Avatar"
                                         class="h-full w-full object-cover">
                                @endif
                            </div>

                            <div class="max-w-[70%] rounded-2xl bg-white border border-slate-200 px-3 py-2 text-xs md:text-sm text-slate-800">
                                {{ $message->chat_message }}
                                <div class="mt-1 text-[0.65rem] text-slate-400">
                                    {{ $message->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    <p class="text-xs text-slate-500 text-center">
                        No messages yet. Say hi!
                    </p>
                @endforelse
            </div>

            {{-- Input bar --}}
            <div class="border-t border-slate-200 px-4 py-3 bg-white">
                <form action="{{ route('chat.send', ['user' => $otherUser->id, 'item' => $item->id]) }}"
                      method="POST"
                      class="flex items-center gap-3">
                    @csrf

                    <div class="flex-1">
                        <input type="text"
                               name="chat_message"
                               placeholder="Type here..."
                               class="w-full rounded-full border border-slate-300 bg-[#F9FAFB] px-4 py-2 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-slate-300 focus:border-slate-400">
                    </div>

                    <button type="submit"
                            class="inline-flex items-center justify-center rounded-full bg-[#111827]
                                   px-4 py-2 text-xs font-semibold text-white hover:bg-black transition">
                        Send
                    </button>
                </form>
            </div>
        </section>
    </div>
</x-app-layout>
