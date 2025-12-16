{{-- resources/views/auth/myprofilepage.blade.php --}}
<x-app-layout :showSearch="false">
    <div class="mx-auto max-w-6xl px-6 lg:px-8 py-8">

        {{-- BACK ROW --}}
        <button type="button"
                onclick="window.history.back()"
                class="mb-6 inline-flex items-center gap-2 text-sm text-slate-700 hover:text-slate-900">
            <img src="{{ asset('images/edusell-back.png') }}" class="h-5" alt="Back">
            <span>My profile</span>
        </button>

        {{-- PAGE TITLE --}}
        <h1 class="text-center text-2xl font-semibold mb-8">
            My Profile
        </h1>

        {{-- MAIN LAYOUT: AVATAR + INFO --}}
        <div class="grid gap-6 md:grid-cols-[260px,1fr]">

            {{-- LEFT COLUMN: Avatar + basic info + edit --}}
            <div class="rounded-2xl bg-white shadow-md p-6 flex flex-col items-center">

                {{-- Avatar --}}
                <div class="h-32 w-32 rounded-full border-2 border-slate-200 overflow-hidden mb-4">
                    @if($user->user_profile_picture)
                        <img src="{{ asset('storage/profile_pictures/'.$user->user_profile_picture) }}"
                             alt="Profile photo"
                             class="h-full w-full object-cover">
                    @else
                        {{-- fallback image --}}
                        <img src="{{ asset('images/avatar-placeholder.png') }}"
                             alt="Profile photo"
                             class="h-full w-full object-cover">
                    @endif
                </div>

                {{-- Name / Program / Campus+Faculty --}}
                <div class="text-center space-y-1 mb-4">
                    <div class="text-lg font-semibold">
                        {{ $user->name }}
                    </div>

                    @if($user->user_program)
                        <div class="text-xs text-slate-500">
                            {{ $user->user_program }}
                        </div>
                    @endif

                    @if($user->user_faculty || $user->user_location)
                        <div
                            class="inline-flex items-center px-3 py-1 rounded-full bg-slate-100 text-[0.7rem] text-slate-600 mt-1">
                            {{ $user->user_faculty ?? '–' }}
                            @if($user->user_location)
                                <span class="mx-1">•</span> {{ $user->user_location }}
                            @endif
                        </div>
                    @endif
                </div>

                {{-- Small summary box --}}
                <div class="w-full mt-2 border-t border-slate-100 pt-4 text-xs text-slate-500 text-center">
                    <p>Profile information is shared with buyers and sellers you chat with.</p>
                </div>

                {{-- Edit button --}}
                <button type="button"
                        onclick="window.location.href='{{ route('editmyprofilepage') }}'"
                        class="mt-5 w-full rounded-lg bg-[#1F2937] py-2.5 text-sm font-semibold text-white hover:bg-[#111827] transition">
                    Edit profile
                </button>
            </div>

            {{-- RIGHT COLUMN: Details grid --}}
            <div class="rounded-2xl bg-white shadow-md p-6 space-y-5">

                <div>
                    <h2 class="text-sm font-semibold text-slate-700 mb-3">
                        Account details
                    </h2>

                    <div class="grid gap-4 sm:grid-cols-2">

                        <div>
                            <div class="text-xs uppercase tracking-wide text-slate-500 mb-1">
                                Matric ID
                            </div>
                            <div class="text-sm font-medium text-slate-800">
                                {{ $user->user_matric_id ?? 'Not set' }}
                            </div>
                        </div>

                        <div>
                            <div class="text-xs uppercase tracking-wide text-slate-500 mb-1">
                                Email address
                            </div>
                            <div class="text-sm font-medium text-slate-800 break-all">
                                {{ $user->email }}
                            </div>
                        </div>

                        <div>
                            <div class="text-xs uppercase tracking-wide text-slate-500 mb-1">
                                Full name
                            </div>
                            <div class="text-sm font-medium text-slate-800">
                                {{ $user->name }}
                            </div>
                        </div>

                        <div>
                            <div class="text-xs uppercase tracking-wide text-slate-500 mb-1">
                                Contact number
                            </div>
                            <div class="text-sm font-medium text-slate-800">
                                {{ $user->user_phone_num ?? 'Not set' }}
                            </div>
                        </div>

                        <div>
                            <div class="text-xs uppercase tracking-wide text-slate-500 mb-1">
                                Program
                            </div>
                            <div class="text-sm font-medium text-slate-800">
                                {{ $user->user_program ?? 'Not set' }}
                            </div>
                        </div>

                        <div>
                            <div class="text-xs uppercase tracking-wide text-slate-500 mb-1">
                                Faculty
                            </div>
                            <div class="text-sm font-medium text-slate-800">
                                {{ $user->user_faculty ?? 'Not set' }}
                            </div>
                        </div>

                        <div>
                            <div class="text-xs uppercase tracking-wide text-slate-500 mb-1">
                                Campus location
                            </div>
                            <div class="text-sm font-medium text-slate-800">
                                {{ $user->user_location ?? 'Not set' }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Optional extra section --}}
                <div class="border-t border-slate-100 pt-4">
                    <h2 class="text-sm font-semibold text-slate-700 mb-2">
                        About
                    </h2>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Final year student using EduSell to buy and sell academic items around campus.
                        You can update this short description in the edit profile page.
                    </p>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
