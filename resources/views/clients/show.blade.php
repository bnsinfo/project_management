<x-app-layout>

    <div class="max-w-3xl mx-auto">

        <div class="flex justify-between items-center mb-6 mt-6">
            <h2 class="text-3xl font-bold">Client Details</h2>

            <a href="{{ route('clients.index') }}" class="text-blue-600 hover:underline">
                ← Back to Clients
            </a>
        </div>

        <div class="bg-white shadow rounded-xl p-6">

            <p class="mb-3"><strong>Name:</strong> {{ $client->name }}</p>
            <p class="mb-3"><strong>Email:</strong> {{ $client->email ?? '—' }}</p>
            <p class="mb-3"><strong>Phone:</strong> {{ $client->phone ?? '—' }}</p>
            <p class="mb-3"><strong>Company:</strong> {{ $client->company ?? '—' }}</p>
            <p class="mb-3"><strong>Address:</strong><br> {{ $client->address ?? '—' }}</p>

        </div>

    </div>

</x-app-layout>
