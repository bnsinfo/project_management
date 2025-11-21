<x-app-layout>

    <div class="flex justify-between items-center mb-6 mt-6">
        <h2 class="text-2xl font-bold">View / Edit Project</h2>

        <a href="{{ route('projects.index') }}"
           class="text-blue-600 hover:underline">
            ← Back to Projects
        </a>
    </div>

    <div class="bg-white shadow rounded p-6 max-w-3xl">

        {{-- Only show form if user can update --}}
        @can('project.update')

            <form action="{{ route('projects.update', $project) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Client --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Client</label>
                    <select name="client_id"
                            class="w-full border-gray-300 rounded shadow-sm">

                        <option value="">Select Client</option>

                        @foreach($clients as $c)
                            <option value="{{ $c->id }}"
                                {{ $project->client_id == $c->id ? 'selected' : '' }}>
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Title --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Title</label>
                    <input
                        type="text"
                        name="title"
                        value="{{ $project->title }}"
                        class="w-full border-gray-300 rounded shadow-sm"
                        required
                    >
                </div>

                {{-- Description --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Description</label>
                    <textarea
                        name="description"
                        rows="4"
                        class="w-full border-gray-300 rounded shadow-sm"
                    >{{ $project->description }}</textarea>
                </div>

                {{-- Assign To --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Assign To</label>
                    <select name="assigned_to" class="w-full border-gray-300 rounded shadow-sm">
                        <option value="">None</option>
                        @foreach($users as $u)
                            <option value="{{ $u->id }}"
                                {{ $u->id == $project->assigned_to ? 'selected' : '' }}>
                                {{ $u->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Status --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Status</label>
                    <select name="status" class="w-full border-gray-300 rounded shadow-sm">
                        <option value="not_started"   {{ $project->status == 'not_started' ? 'selected' : '' }}>Not Started</option>
                        <option value="in_progress"   {{ $project->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="stuck"         {{ $project->status == 'stuck' ? 'selected' : '' }}>Stuck</option>
                        <option value="completed"     {{ $project->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

                {{-- Budget --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Budget</label>
                    <input
                        type="number"
                        step="0.01"
                        name="boudget"
                        value="{{ $project->boudget }}"
                        class="w-full border-gray-300 rounded shadow-sm"
                    >
                </div>

                {{-- Deadline --}}
                <div class="mb-6">
                    <label class="block font-medium mb-1">Deadline</label>
                    <input
                        type="date"
                        name="deadline"
                        value="{{ $project->deadline }}"
                        class="w-full border-gray-300 rounded shadow-sm"
                    >
                </div>

                {{-- Submit --}}
                <button class="bg-yellow-600 px-6 py-2 rounded shadow hover:bg-yellow-700">
                    Update Project
                </button>

            </form>

        @else

            {{-- Read-only view for normal users --}}
            <p class="mb-4 text-gray-700">{{ $project->description ?? 'No description' }}</p>

            {{-- Client --}}
            <p class="mb-2"><strong>Client:</strong> {{ optional($project->client)->name ?? 'No client' }}</p>

            <p class="mb-2"><strong>Assigned To:</strong> {{ optional($project->assignedUser)->name ?? 'Unassigned' }}</p>

            <p class="mb-2"><strong>Status:</strong> {{ str_replace('_', ' ', $project->status) }}</p>

            {{-- Budget --}}
            <p class="mb-2"><strong>Budget:</strong> ₹{{ number_format($project->boudget, 2) }}</p>

            <p class="mb-6"><strong>Deadline:</strong> {{ $project->deadline ?? 'No deadline' }}</p>

        @endcan

    </div>

</x-app-layout>
