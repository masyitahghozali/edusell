<x-app-layout :showSearch="false">
<div class="mx-auto max-w-4xl px-6 py-6">

    {{-- BACK --}}
    <button onclick="window.history.back()"
            class="mb-4 inline-flex items-center gap-2 text-sm text-slate-700">
        <img src="{{ asset('images/edusell-back.png') }}" class="h-5">
        Back
    </button>

    <h1 class="text-center text-xl font-semibold mb-4">
        {{ $otherUser->name }}
    </h1>

    <section class="rounded-2xl bg-white shadow-md flex flex-col h-[600px]">

        {{-- ITEM HEADER --}}
        <div class="border-b p-4 flex gap-3">
            <img src="{{ asset('storage/'.$item->item_image) }}"
                 class="h-12 w-12 rounded object-cover">
            <div>
                <div class="font-semibold">{{ $item->item_name }}</div>
                <div class="text-sm text-slate-500">
                    RM {{ number_format($item->item_price,2) }}
                </div>
            </div>
        </div>

        {{-- MESSAGES --}}
        <div class="flex-1 overflow-y-auto p-4 space-y-3 bg-slate-50">
            @forelse($messages as $msg)
                @if($msg->chat_by_id === auth()->id())
                    <div class="flex justify-end">
                        <div class="bg-slate-200 px-3 py-2 rounded-xl max-w-[70%]">
                            {{ $msg->chat_message }}
                        </div>
                    </div>
                @else
                    <div class="flex gap-2">
                        <img src="{{ $otherUser->user_profile_picture
                            ? asset('storage/'.$otherUser->user_profile_picture)
                            : asset('images/avatar-placeholder.png') }}"
                             class="h-8 w-8 rounded-full">
                        <div class="bg-white px-3 py-2 rounded-xl max-w-[70%]">
                            {{ $msg->chat_message }}
                        </div>
                    </div>
                @endif
            @empty
                <p class="text-center text-sm text-slate-500">
                    No messages yet. Say hi 👋
                </p>
            @endforelse
        </div>

        {{-- INPUT --}}
        <form method="POST"
              action="{{ route('chat.send', [$otherUser, $item]) }}"
              class="flex gap-2 p-4 border-t">
            @csrf
            <input name="chat_message"
                   required
                   class="flex-1 rounded-full border px-4 py-2"
                   placeholder="Type message...">
            <button type="submit"
                    class="bg-black text-white rounded-full px-4">
                Send
            </button>
        </form>

    </section>
</div>
</x-app-layout>
