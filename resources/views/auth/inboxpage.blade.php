{{-- resources/views/auth/inboxpage.blade.php --}}
<x-app-layout :showSearch="false">
    <div class="mx-auto max-w-6xl px-6 lg:px-8 py-8">

        {{-- BACK --}}
        <button type="button"
                onclick="window.history.back()"
                class="mb-6 inline-flex items-center gap-2 text-sm text-slate-700 hover:text-slate-900">
            <img src="{{ asset('images/edusell-back.png') }}" class="h-5" alt="Back">
            <span>Inbox</span>
        </button>

        <div class="rounded-2xl bg-white shadow-md divide-y">

            @forelse($threads as $otherUserId => $messages)
                @php
                    $last = $messages->first();
                    $other = $last->chat_by_id == $currentId ? $last->sender : $last->receiver;
                    $isSold = $last->item && $last->item->item_status === 'sold';
                @endphp

                <a href="{{ route('chatpage', ['item' => $last->item_id, 'user' => $other->id]) }}"
                   class="flex items-center justify-between px-5 py-4 hover:bg-slate-50 transition">

                    <div class="flex items-center gap-3">

                        {{-- Avatar --}}
                        <div class="h-11 w-11 rounded-full overflow-hidden bg-slate-200 flex-shrink-0">
                            @if($other->user_profile_picture)
                                <img src="{{ asset('storage/'.$other->user_profile_picture) }}"
                                     class="h-full w-full object-cover">
                            @else
                                <img src="{{ asset('images/avatar-placeholder.png') }}"
                                     class="h-full w-full object-cover">
                            @endif
                        </div>

                        {{-- Name + last message --}}
                        <div class="text-sm">
                            <div class="font-semibold text-slate-900">
                                {{ $other->name }}
                            </div>
                            <div class="text-xs text-slate-500 truncate max-w-[220px]">
                                {{ $last->chat_message }}
                            </div>
                        </div>
                    </div>

                    {{-- Time + status --}}
                    <div class="flex flex-col items-end gap-1">
                        <span class="text-[0.7rem] text-slate-400">
                            {{ $last->created_at->diffForHumans() }}
                        </span>

                        @if($isSold)
                            <span class="px-3 py-1 text-xs font-semibold rounded-lg bg-black text-white">
                                sold
                            </span>
                        @endif
                    </div>

                </a>
            @empty
                <div class="px-5 py-6 text-sm text-slate-500 text-center">
                    No chats yet. Start by opening an item and tapping “Chat seller”.
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
