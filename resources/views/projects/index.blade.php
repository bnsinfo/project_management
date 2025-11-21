<x-app-layout>

    {{-- PAGE HEADER --}}
    <div class="flex justify-between items-center mb-6 mt-6">
        <h2 class="text-3xl font-bold text-gray-800">Projects</h2>

        @can('project.create')
            <a href="{{ route('projects.create') }}"
                class="px-6 py-2 bg-black font-semibold rounded-lg shadow hover:bg-gray-900 transition text-white">
                + New Project
            </a>
        @endcan
    </div>

    {{-- TABLE WRAPPER --}}
    <div class="bg-white shadow-lg rounded-xl p-6">

        <table class="w-full border-collapse" style="text-align: left;">
            <thead>
                <tr class="bg-black border-b text-white">
                    <th class="px-4 py-3 font-semibold">S.No</th>
                    <th class="px-4 py-3 font-semibold">Title</th>
                    <th class="px-4 py-3 font-semibold">Assigned To</th>
                    <th class="px-4 py-3 font-semibold">Status</th>
                    <th class="px-4 py-3 font-semibold">Deadline</th>
                    <th class="px-4 py-3 font-semibold">Created At</th>
                    <th class="px-4 py-3 font-semibold">Follow Up</th>
                    <th class="px-4 py-3 font-semibold w-48">Actions</th>

                    {{-- NEW STATUS DROPDOWN COLUMN --}}
                    <th class="px-4 py-3 font-semibold">Change Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($projects as $p)
                    <tr class="border-b hover:bg-gray-50 transition">

                        {{-- SERIAL --}}
                        <td class="px-4 py-3 text-gray-800">{{ $loop->iteration }}</td>

                        <td class="px-4 py-3 text-gray-800">{{ $p->title }}</td>

                        {{-- ASSIGNED --}}
                        <td class="px-4 py-3 text-gray-700">{{ optional($p->assignedUser)->name ?? '—' }}</td>

                        {{-- STATUS (DISPLAY ONLY) --}}
                        <td class="px-4 py-3 capitalize text-gray-700">{{ str_replace('_', ' ', $p->status) }}</td>

                        {{-- DEADLINE --}}
                        <td class="px-4 py-3 text-gray-700">{{ $p->deadline }}</td>

                        {{-- CREATED AT --}}
                        <td class="px-4 py-3 text-gray-700">
                            {{ $p->created_at->format('d M Y h:i A') }}
                        </td>

                        {{-- FOLLOW-UP BUTTON --}}
                        <td class="px-4 py-3">
                            <a href="{{ route('projects.followup.add', $p->id) }}"
                                class="bg-blue-600  px-3 py-2 rounded-md hover:bg-blue-700 transition flex justify-start items-center">

                                {{-- - ICON HERE - --}}
                                <!-- Replace below with your selected SVG -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 " fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M7 8h10M7 12h6m-4 8l-4-4H6a2 2 0 01-2-2V7a2 2 0 012-2h12a2 2 0 012 2v7a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>

                            </a>
                        </td>


                        {{-- ACTION BUTTONS --}}
                        <td class="px-4 py-3">
                            <div class="grid grid-cols-1 gap-2 flex">

                                <a href="{{ route('projects.show', $p) }}"
                                    class="w-full flex justify-center items-center px-4 py-2 rounded-md bg-black hover:bg-gray-900 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>

                                @can('project.update')
                                    <a href="{{ route('projects.edit', $p) }}"
                                        class="w-full flex justify-center items-center px-4 py-2 rounded-md bg-black hover:bg-gray-900 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M18.5 2.5l3 3L12 15l-4 1 1-4L18.5 2.5z" />
                                        </svg>
                                    </a>
                                @endcan

                                @can('project.delete')
                                    <form action="{{ route('projects.destroy', $p) }}" method="POST"
                                        onsubmit="return confirm('Delete this project?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="w-full flex justify-center items-center px-4 py-2 rounded-md bg-black hover:bg-gray-900 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 7h6m2 0h-2m-8 0h2m3-3h2a2 2 0 012 2h-8a2 2 0 012-2z" />
                                            </svg>
                                        </button>
                                    </form>
                                @endcan

                            </div>
                        </td>

                        {{-- NEW STATUS DROPDOWN (AT END) --}}
                        <td class="px-4 py-3">
                            <form action="{{ route('projects.updateStatus', $p->id) }}" method="POST">
                                @csrf

                                <select name="status" onchange="this.form.submit()"
                                    class="border-gray-300 rounded px-2 py-1 text-sm capitalize w-full">

                                    <option value="not_started" {{ $p->status === 'not_started' ? 'selected' : '' }}>
                                        Not Started
                                    </option>

                                    <option value="in_progress" {{ $p->status === 'in_progress' ? 'selected' : '' }}>
                                        In Progress
                                    </option>

                                    <option value="stuck" {{ $p->status === 'stuck' ? 'selected' : '' }}>
                                        Stuck
                                    </option>

                                    <option value="completed" {{ $p->status === 'completed' ? 'selected' : '' }}>
                                        Completed
                                    </option>

                                </select>
                            </form>
                        </td>

                    </tr>
                @endforeach
            </tbody>

        </table>

        {{-- PAGINATION --}}
        <div class="mt-6">
            {{ $projects->links() }}
        </div>

    </div>

</x-app-layout>
