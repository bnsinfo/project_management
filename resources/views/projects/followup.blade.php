<x-app-layout>

    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-xl p-6 mt-6">

        <h2 class="text-2xl font-bold mb-4 text-gray-800">
            Add Follow Up for: {{ $project->title }}
        </h2>

        <form method="POST" action="{{ route('projects.followup.store', $project->id) }}">
            @csrf

            <div class="mb-4">
                <label class="font-semibold">Heading</label>
                <input type="text" name="heading"
                       class="w-full border rounded p-2 mt-1" required>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Description</label>
                <textarea name="description" rows="5"
                          class="w-full border rounded p-2 mt-1"></textarea>
            </div>

            <div class="flex justify-end gap-3 mt-3">
                <a href="{{ route('projects.index') }}"
                   class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    Cancel
                </a>

                <button type="submit"
                        class="px-4 py-2 bg-blue-600 rounded hover:bg-blue-700">
                    Save Follow Up
                </button>
            </div>

        </form>

    </div>

</x-app-layout>
