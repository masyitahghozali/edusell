{{-- resources/views/auth/editmyprofilepage.blade.php --}}
<x-app-layout :showSearch="false">
    <div class="mx-auto max-w-6xl px-6 lg:px-8 py-8">

        {{-- BACK --}}
        <button type="button"
                onclick="window.history.back()"
                class="mb-6 inline-flex items-center gap-2 text-sm text-slate-700 hover:text-slate-900">
            <img src="{{ asset('images/edusell-back.png') }}" class="h-5" alt="Back">
            <span>Edit profile</span>
        </button>

        <h1 class="text-center text-2xl font-semibold mb-8">
            Edit Profile
        </h1>

        <div class="grid gap-6 md:grid-cols-[260px,1fr]">

            {{-- LEFT --}}
            <div class="rounded-2xl bg-white shadow-md p-6 flex flex-col items-center">
                <div class="relative h-32 w-32 rounded-full border-2 border-slate-200 overflow-hidden mb-4">
                    @if($user->user_profile_picture)
                        <img src="{{ asset('storage/'.$user->user_profile_picture) }}"
                             class="h-full w-full object-cover">
                    @else
                        <img src="{{ asset('images/avatar-placeholder.png') }}"
                             class="h-full w-full object-cover">
                    @endif
                </div>

                <div class="text-center text-xs text-slate-500">
                    Visible to buyers and sellers you interact with.
                </div>
            </div>

            {{-- RIGHT --}}
            <div class="rounded-2xl bg-white shadow-md p-6">
                <form action="{{ route('myprofile.update') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div class="grid gap-4 sm:grid-cols-2">

                        {{-- Matric --}}
                        <div>
                            <label class="text-xs font-semibold text-slate-600 mb-1 block">Matric ID</label>
                            <input type="text" name="user_matric_id"
                                   value="{{ old('user_matric_id', $user->user_matric_id) }}"
                                   class="w-full rounded-lg border px-3 py-2 text-sm">
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="text-xs font-semibold text-slate-600 mb-1 block">Email</label>
                            <input type="email" value="{{ $user->email }}" readonly
                                   class="w-full rounded-lg border bg-slate-50 px-3 py-2 text-sm">
                        </div>

                        {{-- Name --}}
                        <div>
                            <label class="text-xs font-semibold text-slate-600 mb-1 block">Full name</label>
                            <input type="text" name="name"
                                   value="{{ old('name', $user->name) }}"
                                   class="w-full rounded-lg border px-3 py-2 text-sm">
                        </div>

                        {{-- Contact --}}
                        <div>
                            <label class="text-xs font-semibold text-slate-600 mb-1 block">Contact number</label>
                            <input type="text" name="user_phone_num"
                                   value="{{ old('user_phone_num', $user->user_phone_num) }}"
                                   class="w-full rounded-lg border px-3 py-2 text-sm">
                        </div>

                        {{-- PROGRAMME (SEARCHABLE + SCROLLABLE) --}}
                        <div class="sm:col-span-2 relative">
                            <label class="text-xs font-semibold text-slate-600 mb-1 block">
                                Programme
                            </label>

                            <input type="text"
                                   id="programmeInput"
                                   name="user_program"
                                   value="{{ old('user_program', $user->user_program) }}"
                                   placeholder="List of Programme"
                                   autocomplete="off"
                                   class="w-full rounded-lg border px-3 py-2 text-sm">

                            <div id="programmeDropdown"
                                 class="absolute z-20 mt-1 w-full max-h-44 overflow-y-auto
                                        rounded-lg border bg-white shadow-md hidden">

                                @php
                                    $programmes = [
                                         // Diploma
                                        'Diploma in Civil Engineering',
                                        'Diploma in Chemical Engineering',
                                        'Diploma in Mechanical Engineering',
                                        'Diploma in Electrical and Electronics Engineering',
                                        'Diploma in Manufacturing Engineering Technology',
                                        'Diploma in Computer Science',
                                        'Diploma in Industrial Sciences',
                                        'Diploma in Occupational Safety And Health',

                                         // Bachelor
                                        'Bachelor of Automotive Engineering with Honours',
                                        'Bachelor of Mechatronics Engineering with Honours',
                                        'Bachelor of Electrical Engineering (Electronics) with Honours',
                                        'Bachelor of Business Engineering With Honours',
                                        'Bachelor of Civil Engineering with Honours',
                                        'Bachelor of Chemical Engineering with Honours',
                                        'Bachelor of Electrical Engineering with Honours',
                                        'Bachelor of Manufacturing Engineering with Honours',
                                        'B.Eng (Hons.) Mechatronics Engineering',
                                        'Bachelor of Mechanical Engineering with Honours',
                                        'Bachelor of Chemical Engineering Technology With Hons.',
                                        'Bachelor of Manufacturing Engineering Technology (Pharmaceutical) With Hons.',
                                        'Bachelor of Mechanical Engineering Technology (Petroleum ) With Honours',
                                        'Bachelor of Civil Engineering Technology (Building) With Honours',
                                        'Bachelor of Engineering Technology (Infrastructure Management) With Hons.',
                                        'Bachelor of Engineering Technology (Energy & Environmental) With Hons.',                                        
                                        'Bachelor of Mechanical Engineering Technology (Automotive) with Honours',
                                        'Bachelor of Mechanical Engineering Technology (Oil and Gas) with Honours', 
                                        'Bachelor of Mechanical Engineering Technology (Design and Analysis) with Honours',
                                        'Bachelor of Mechatronic Engineering Technology (Robotics) with Honours',
                                        'Bachelor of Manufacturing Engineering Technology (Industrial Automation) with Honours',
                                        'Bachelor of Manufacturing Engineering Technology (Advanced Manufacturing) with Honours',
                                        'Bachelor of Electronics Engineering Technology (Computer System ) With Honours',
                                        'Bachelor of Electrical Engineering Technology (Energy) with Honours',
                                        'Bachelor of Applied Science in Industrial Biotechnology with Honours',
                                        'Bachelor of Applied Science in Industrial Chemistry with Honours',
                                        'Bachelor of Applied Science in Material Technology with Honours',
                                        'Bachelor of Applied Science in Data Analytics with Honours',
                                        'Bachelor of Occupational Safety & Health With Honours',
                                        'Bachelor of Computer Science Artificial Intelligencey with Honours',
                                        'Bachelor of Computer Science (Software Engineering) with Honours',
                                        'Bachelor of Computer Science (Cyber Security) with Honours',
                                        'Bachelor of Computer Science (Multimedia Software) with Honours',
                                        'Bachelor of Computer Science (Computer Systems & Networking) with Honours',
                                        'Bachelor of Financial Technology with Honours',
                                        'Bachelor of Business Analytics with Honours', 
                                        'Bachelor of Project Management with Honours',
                                        'Bachelor of Industrial Technology Management with Honours',
                                        'Bachelor in Cyber Defence Technology with Honours',
                                        'Bachelor of Technology in Facilities Management with Honours',
                                        'Bachelor of Technology in Building Construction with Honours',
                                        'Bachelor of Technology in Automotive with Honours',
                                        'Bachelor of Technology in Industrial Electronic Automation with Honours',
                                        'Bachelor of Technology in Electrical System Maintenance with Honours',
                                        'Bachelor of Technology in Oil & Gas Facilities Maintenance with Honours',
                                        'Bachelor of Technology in Industrial Machining with Honours',
                                        'Bachelor of Technology in Welding with Honours',

                                         // Postgraduate
                                        'Master of Science',
                                        'Master of Chemical Engineering with Entrepreneurship',
                                        'Master of Science (Process Plant Operation)',
                                        'Master of Science in Mining with Mineral Technology',
                                        'Master of Petroleum Engineering',
                                        'Master of Mechanical Engineering',
                                        'Master of Industrial Engineering',
                                        'Master of Mechatronic Engineering',
                                        'Master of Electrical Engineering (Sustainable Energy)',
                                        'Master of Science in Digital Transformation',
                                        'Master of Science in Artificial Intelligence',
                                        'Master of Science in Cyber Security',
                                        'Master of Science Occupational Safety and Health',
                                        'Master of Business Administration',
                                        'Master of Project Management',
                                        'Master of Science in Technology-Integrated Language Studies',
                                        'Master of Science (Industrial Mathematics)',
                                        'Master of Science in Chemical Analytics',
                                        'Doctor of Philosophy',
                                    ];
                                @endphp

                                @foreach($programmes as $programme)
                                    <div class="programme-option px-3 py-2 text-sm cursor-pointer hover:bg-slate-100">
                                        {{ $programme }}
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- FACULTY (SEARCHABLE + SCROLLABLE) --}}
                        <div class="relative">
                            <label class="text-xs font-semibold text-slate-600 mb-1 block">
                                Faculty
                            </label>

                            <input type="text"
                                id="facultyInput"
                                name="user_faculty"
                                value="{{ old('user_faculty', $user->user_faculty) }}"
                                placeholder="Choose faculty"
                                autocomplete="off"
                                class="w-full rounded-lg border px-3 py-2 text-sm">

                            <div id="facultyDropdown"
                                class="absolute z-20 mt-1 w-full max-h-44 overflow-y-auto
                                    rounded-lg border bg-white shadow-md hidden">

                                @php
                                    $faculties = [
                                        'Faculty of Mechanical and Automotive Engineering Technology',
                                        'Faculty of Manufacturing and Mechatronic Engineering Technology',
                                        'Faculty of Electrical and Electronics Engineering Technology',
                                        'Faculty of Industrial Management',
                                        'Faculty of Civil Engineering Technology',
                                        'Faculty of Chemical and Process Engineering Technology',
                                        'Centre for Mathematical Sciences',
                                        'Faculty of Computing',
                                        'Faculty of Industrial Sciences and Technology',
                                        'Centre for Human Sciences',
                                        'Centre for Modern Languages',
                                    ];
                                @endphp

                                @foreach($faculties as $faculty)
                                    <div class="faculty-option px-3 py-2 text-sm cursor-pointer hover:bg-slate-100">
                                        {{ $faculty }}
                                    </div>
                                @endforeach
                            </div>
                        </div>


                        {{-- Campus --}}
                        <div>
                            <label class="text-xs font-semibold text-slate-600 mb-1 block">Campus location</label>
                            <select name="user_location"
                                    class="w-full rounded-lg border px-3 py-2 text-sm">
                                <option value="Pekan, Pahang">Pekan, Pahang</option>
                                <option value="Gambang, Pahang">Gambang, Pahang</option>
                            </select>
                        </div>
                    </div>

                    {{-- About --}}
                    <div>
                        <label class="text-xs font-semibold text-slate-600 mb-1 block">
                            About you (optional)
                        </label>

                        <textarea
                            name="user_about"
                            class="w-full rounded-lg border px-3 py-2 text-sm h-24 resize-none"
                            placeholder="Tell others a little about yourself (optional)"
                        >{{ old('user_about', $user->user_about) }}</textarea>
                    </div>


                    {{-- Save --}}
                    <div class="flex justify-end pt-2">
                        <button type="submit"
                                class="rounded-lg bg-[#111827] px-5 py-2.5 text-sm font-semibold text-white">
                            Save profile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- PROGRAMME DROPDOWN SCRIPT --}}
    <script>
        const input = document.getElementById('programmeInput');
        const dropdown = document.getElementById('programmeDropdown');
        const options = dropdown.querySelectorAll('.programme-option');

        input.addEventListener('focus', () => dropdown.classList.remove('hidden'));

        input.addEventListener('input', () => {
            const value = input.value.toLowerCase();
            let visible = 0;

            options.forEach(option => {
                if (option.textContent.toLowerCase().includes(value)) {
                    option.style.display = 'block';
                    visible++;
                } else {
                    option.style.display = 'none';
                }
            });

            dropdown.classList.toggle('hidden', visible === 0);
        });

        options.forEach(option => {
            option.addEventListener('click', () => {
                input.value = option.textContent.trim();
                dropdown.classList.add('hidden');
            });
        });

        document.addEventListener('click', e => {
            if (!input.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>

    {{-- FACULTY DROPDOWN SCRIPT --}}
    <script>
        const facultyInput = document.getElementById('facultyInput');
        const facultyDropdown = document.getElementById('facultyDropdown');
        const facultyOptions = facultyDropdown.querySelectorAll('.faculty-option');

        facultyInput.addEventListener('focus', () => facultyDropdown.classList.remove('hidden'));

        facultyInput.addEventListener('input', () => {
            const value = facultyInput.value.toLowerCase();
            let visible = 0;

            facultyOptions.forEach(option => {
                if (option.textContent.toLowerCase().includes(value)) {
                    option.style.display = 'block';
                    visible++;
                } else {
                    option.style.display = 'none';
                }
            });

            facultyDropdown.classList.toggle('hidden', visible === 0);
        });

        facultyOptions.forEach(option => {
            option.addEventListener('click', () => {
                facultyInput.value = option.textContent.trim();
                facultyDropdown.classList.add('hidden');
            });
        });

        document.addEventListener('click', e => {
            if (!facultyInput.contains(e.target) && !facultyDropdown.contains(e.target)) {
                facultyDropdown.classList.add('hidden');
            }
        });
    </script>

</x-app-layout>
