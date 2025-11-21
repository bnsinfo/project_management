<x-app-layout>

    <div class="max-w-3xl mx-auto">

        <div class="flex justify-between items-center mb-6 mt-6">
            <h2 class="text-2xl font-bold">Create Project</h2>

            <a href="{{ route('projects.index') }}"
               class="text-blue-600 hover:underline">
                ← Back to Projects
            </a>
        </div>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-600 rounded">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow rounded p-6">

            <form action="{{ route('projects.store') }}" method="POST">
                @csrf

                {{-- Client --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Client</label>

                    <select name="client_id"
                            class="w-full border-gray-300 rounded shadow-sm">
                        <option value="">Select Client</option>
                        @foreach($clients as $c)
                            <option value="{{ $c->id }}">
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Title --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title"
                           class="w-full border-gray-300 rounded shadow-sm"
                           required>
                </div>

                {{-- Description --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Description</label>
                    <textarea name="description"
                              class="w-full border-gray-300 rounded shadow-sm"
                              rows="4"></textarea>
                </div>

                {{-- Assign To --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Assign To</label>
                    <select name="assigned_to"
                            class="w-full border-gray-300 rounded shadow-sm">
                        <option value="">None</option>
                        @foreach($users as $u)
                            <option value="{{ $u->id }}">{{ $u->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Budget --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Budget (₹)</label>
                    <input type="number" step="0.01" name="boudget"
                           class="w-full border-gray-300 rounded shadow-sm">
                </div>

                {{-- Deadline --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Deadline</label>
                    <input type="date" name="deadline"
                           class="w-full border-gray-300 rounded shadow-sm">
                </div>

                {{-- Submit --}}
                <div class="mt-6">
                    <button
                        class="bg-green-600 px-6 py-2 rounded shadow hover:bg-green-700">
                        Create Project
                    </button>
                </div>

            </form>

        </div>

    </div>

</x-app-layout>
