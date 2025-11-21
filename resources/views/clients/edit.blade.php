<x-app-layout>

    <div class="max-w-3xl mx-auto">

        <div class="flex justify-between items-center mb-6 mt-6">
            <h2 class="text-3xl font-bold">Edit Client</h2>

            <a href="{{ route('clients.index') }}" class="text-blue-600 hover:underline">
                ← Back to Clients
            </a>
        </div>

        {{-- ERRORS --}}
        @if ($errors->any())
            <div class="p-4 bg-red-100 text-red-700 rounded mb-4">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow rounded-xl p-6">

            <form action="{{ route('clients.update', $client->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- NAME --}}
                <div class="mb-4">
                    <label class="font-medium">Client Name *</label>
                    <input type="text" name="name" value="{{ $client->name }}" required
                        class="w-full border-gray-300 rounded mt-2 px-3 py-2 shadow-sm">
                </div>

                {{-- EMAIL --}}
                <div class="mb-4">
                    <label class="font-medium">Email</label>
                    <input type="email" name="email" value="{{ $client->email }}"
                        class="w-full border-gray-300 rounded mt-2 px-3 py-2 shadow-sm">
                </div>

                {{-- PHONE --}}
                <div class="mb-4">
                    <label class="font-medium">Phone</label>
                    <input type="text" name="phone" value="{{ $client->phone }}"
                        class="w-full border-gray-300 rounded mt-2 px-3 py-2 shadow-sm">
                </div>

                {{-- COMPANY --}}
                <div class="mb-4">
                    <label class="font-medium">Company</label>
                    <input type="text" name="company" value="{{ $client->company }}"
                        class="w-full border-gray-300 rounded mt-2 px-3 py-2 shadow-sm">
                </div>

                {{-- ADDRESS --}}
                <div class="mb-4">
                    <label class="font-medium">Address</label>
                    <textarea name="address" rows="3"
                        class="w-full border-gray-300 rounded mt-2 px-3 py-2 shadow-sm">{{ $client->address }}</textarea>
                </div>

                <button class="px-6 py-2 bg-green-600 rounded hover:bg-green-700">
                    Update Client
                </button>

            </form>

        </div>

    </div>

</x-app-layout>
