{{-- resources/views/auth/editmyprofilepage.blade.php --}}
<x-app-layout :showSearch="false">
    <div class="mx-auto max-w-6xl px-6 lg:px-8 py-8">

        {{-- BACK ROW --}}
        <button type="button"
                onclick="window.history.back()"
                class="mb-6 inline-flex items-center gap-2 text-sm text-slate-700 hover:text-slate-900">
            <img src="{{ asset('images/edusell-back.png') }}" class="h-5" alt="Back">
            <span>Edit profile</span>
        </button>

        {{-- PAGE TITLE --}}
        <h1 class="text-center text-2xl font-semibold mb-8">
            Edit Profile
        </h1>

        {{-- MAIN LAYOUT: AVATAR + FORM --}}
        <div class="grid gap-6 md:grid-cols-[260px,1fr]">

            {{-- LEFT COLUMN: Avatar + change photo --}}
            <div class="rounded-2xl bg-white shadow-md p-6 flex flex-col items-center">

                {{-- Avatar block --}}
                <div class="relative h-32 w-32 rounded-full border-2 border-slate-200 overflow-hidden mb-4">
                    @if($user->user_profile_picture)
                        <img src="{{ asset('storage/'.$user->user_profile_picture) }}"
                             alt="Profile photo"
                             class="h-full w-full object-cover">
                    @else
                        <img src="{{ asset('images/avatar-placeholder.png') }}"
                             alt="Profile photo"
                             class="h-full w-full object-cover">
                    @endif

                    {{-- Change photo (file input visually) --}}
                    <label
                        class="absolute -right-1 -bottom-1 h-9 w-9 rounded-full bg-[#111827]
                               flex items-center justify-center shadow-md cursor-pointer">
                        <img src="{{ asset('storage/profile_pictures/'.$user->user_profile_picture) }}"
                         class="h-5 w-5" 
                         alt="Change">
                        <input type="file" name="user_profile_picture" class="hidden"
                               form="edit-profile-form" accept="image/*">
                    </label>
                </div>

                <div class="text-center space-y-1 mb-4">
                    <div class="text-sm font-semibold">Profile photo</div>
                    <p class="text-xs text-slate-500">
                        This photo is visible to buyers and sellers you interact with.
                    </p>
                </div>

                <div class="w-full border-t border-slate-100 pt-4 text-xs text-slate-500 text-center">
                    <p>You can update your details on the right and save when you are done.</p>
                </div>
            </div>

            {{-- RIGHT COLUMN: Edit form --}}
            <div class="rounded-2xl bg-white shadow-md p-6">
                <form id="edit-profile-form"
                      action="{{ route('myprofile.update') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div class="grid gap-4 sm:grid-cols-2">
                        {{-- Matric ID --}}
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">
                                Matric ID
                            </label>
                            <input type="text"
                                   name="user_matric_id"
                                   value="{{ old('user_matric_id', $user->user_matric_id) }}"
                                   class="w-full rounded-lg border border-slate-300 bg-[#FFFEFC]
                                          px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-slate-500">
                        </div>

                        {{-- Email (read only, no editing here) --}}
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">
                                Email address
                            </label>
                            <input type="email"
                                   value="{{ $user->email }}"
                                   readonly
                                   class="w-full rounded-lg border border-slate-200 bg-slate-50
                                          px-3 py-2 text-sm text-slate-500 cursor-not-allowed">
                        </div>

                        {{-- Full name --}}
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">
                                Full name
                            </label>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name', $user->name) }}"
                                   class="w-full rounded-lg border border-slate-300 bg-[#FFFEFC]
                                          px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-slate-500">
                        </div>

                        {{-- Contact number --}}
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">
                                Contact number
                            </label>
                            <input type="text"
                                   name="user_phone_num"
                                   value="{{ old('user_phone_num', $user->user_phone_num) }}"
                                   class="w-full rounded-lg border border-slate-300 bg-[#FFFEFC]
                                          px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-slate-500">
                        </div>

                        {{-- Programme (dropdown) --}}
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-600 mb-1">
                                Programme
                            </label>
                            <select
                                name="user_program"
                                class="w-full rounded-lg border border-slate-300 bg-[#FFFEFC]
                                       px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-slate-500">
                                <option value="" disabled {{ $user->user_program ? '' : 'selected' }}>
                                    Choose your programme
                                </option>

                                {{-- (Keep all your options here) --}}
                                <option
                                    value="Bachelor of Applied Science in Data Analytics with Honours"
                                    {{ old('user_program', $user->user_program) == 'Bachelor of Applied Science in Data Analytics with Honours' ? 'selected' : '' }}>
                                    Bachelor of Applied Science in Data Analytics with Honours
                                </option>
                                {{-- ... keep all the other <option> the same, just no change needed
                                     except add the value="" and selected check like above ... --}}
                            </select>
                        </div>

                        {{-- Faculty (dropdown) --}}
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">
                                Faculty
                            </label>
                            <select
                                name="user_faculty"
                                class="w-full rounded-lg border border-slate-300 bg-[#FFFEFC]
                                       px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-slate-500">
                                <option value="" disabled {{ $user->user_faculty ? '' : 'selected' }}>
                                    Choose faculty
                                </option>
                                <option value="Faculty of Chemical and Process Engineering Technology"
                                    {{ old('user_faculty', $user->user_faculty) == 'Faculty of Chemical and Process Engineering Technology' ? 'selected' : '' }}>
                                    Faculty of Chemical and Process Engineering Technology
                                </option>
                                <option value="Faculty of Civil Engineering Technology"
                                    {{ old('user_faculty', $user->user_faculty) == 'Faculty of Civil Engineering Technology' ? 'selected' : '' }}>
                                    Faculty of Civil Engineering Technology
                                </option>
                                <option value="Faculty of Electrical and Electronics Engineering Technology"
                                    {{ old('user_faculty', $user->user_faculty) == 'Faculty of Electrical and Electronics Engineering Technology' ? 'selected' : '' }}>
                                    Faculty of Electrical and Electronics Engineering Technology
                                </option>
                                <option value="Faculty of Manufacturing and Mechatronic Engineering Technology"
                                    {{ old('user_faculty', $user->user_faculty) == 'Faculty of Manufacturing and Mechatronic Engineering Technology' ? 'selected' : '' }}>
                                    Faculty of Manufacturing and Mechatronic Engineering Technology
                                </option>
                                <option value="Faculty of Mechanical and Automotive Engineering Technology"
                                    {{ old('user_faculty', $user->user_faculty) == 'Faculty of Mechanical and Automotive Engineering Technology' ? 'selected' : '' }}>
                                    Faculty of Mechanical and Automotive Engineering Technology
                                </option>
                                <option value="Centre for Mathematical Sciences"
                                    {{ old('user_faculty', $user->user_faculty) == 'Centre for Mathematical Sciences' ? 'selected' : '' }}>
                                    Centre for Mathematical Sciences
                                </option>
                                <option value="Faculty of Computing"
                                    {{ old('user_faculty', $user->user_faculty) == 'Faculty of Computing' ? 'selected' : '' }}>
                                    Faculty of Computing
                                </option>
                                <option value="Faculty of Industrial Sciences and Technology"
                                    {{ old('user_faculty', $user->user_faculty) == 'Faculty of Industrial Sciences and Technology' ? 'selected' : '' }}>
                                    Faculty of Industrial Sciences and Technology
                                </option>
                            </select>
                        </div>

                        {{-- Campus location --}}
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">
                                Campus location
                            </label>
                            <select
                                name="user_location"
                                class="w-full rounded-lg border border-slate-300 bg-[#FFFEFC]
                                       px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-slate-500">
                                <option value="Pekan, Pahang"
                                    {{ old('user_location', $user->user_location) == 'Pekan, Pahang' ? 'selected' : '' }}>
                                    Pekan, Pahang
                                </option>
                                <option value="Gambang, Pahang"
                                    {{ old('user_location', $user->user_location) == 'Gambang, Pahang' ? 'selected' : '' }}>
                                    Gambang, Pahang
                                </option>
                            </select>
                        </div>
                    </div>

                    {{-- About you (optional) – still just static text, no DB column yet --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">
                            About you (optional)
                        </label>
                        <textarea
                            class="w-full rounded-lg border border-slate-300 bg-[#FFFEFC]
                                   px-3 py-2 text-sm h-24 resize-none focus:outline-none focus:ring-1 focus:ring-slate-500"
                        >Final year student using EduSell to buy and sell academic items around campus.</textarea>
                    </div>

                    {{-- Save button --}}
                    <div class="pt-2 flex justify-end">
                        <button type="submit"
                                class="inline-flex items-center justify-center rounded-lg bg-[#111827]
                                       px-5 py-2.5 text-sm font-semibold text-white hover:bg-black transition">
                            Save profile
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
