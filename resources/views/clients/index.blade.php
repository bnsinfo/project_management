<x-app-layout>

    <div class="flex justify-between items-center mb-6 mt-6">
        <h2 class="text-3xl font-bold">Clients</h2>

        <a href="{{ route('clients.create') }}"
            class="px-6 py-2 bg-black rounded-lg shadow hover:bg-gray-900 transition text-white">
            + Add Client
        </a>
    </div>

    <div class="bg-white shadow-lg rounded-xl p-6">

        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <div class="p-4 mb-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border-collapse" style="text-align: left;">
            <thead>
                <tr class="bg-black text-white">
                    <th class="px-4 py-3 text-left">#</th>
                    <th class="px-4 py-3 text-left">Name</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Phone</th>
                    <th class="px-4 py-3 text-left">Company</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($clients as $index => $client)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $index + 1 }}</td>
                        <td class="px-4 py-3">{{ $client->name }}</td>
                        <td class="px-4 py-3">{{ $client->email ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $client->phone ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $client->company ?? '—' }}</td>

                        <td class="px-4 py-3 flex gap-2">

                            <a href="{{ route('clients.show', $client->id) }}"
                                class="px-3 py-1 bg-blue-600 rounded hover:bg-blue-700 transition text-white">
                                View
                            </a>

                            <a href="{{ route('clients.edit', $client->id) }}"
                                class="px-3 py-1 bg-black rounded hover:bg-gray-900 transition text-white">
                                Edit
                            </a>

                            <form action="{{ route('clients.destroy', $client->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Delete this client?');">
                                @csrf
                                @method('DELETE')

                                <button class="px-3 py-1 bg-red-600 rounded hover:bg-red-700 transition text-white">
                                    Delete
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center p-4 text-gray-500">No clients found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $clients->links() }}
        </div>

    </div>

</x-app-layout>
