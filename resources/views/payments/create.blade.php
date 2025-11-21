<x-app-layout>

    <div class="max-w-3xl mx-auto">

        {{-- PAGE HEADER --}}
        <div class="flex justify-between items-center mb-6 mt-6">
            <h2 class="text-2xl font-bold">
                Add {{ request('type') === 'paid' ? 'Paid Payment' : 'Received Payment' }}
            </h2>

            <a href="{{ route('payments.index') }}"
               class="text-blue-600 hover:underline">
                ← Back to Payments
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

            <form action="{{ route('payments.store') }}" method="POST">
                @csrf

                {{-- Hidden Payment Type --}}
                <input type="hidden"
                       name="payment_type"
                       value="{{ request('type', 'received') }}">

                {{-- Project --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Project <span class="text-red-500">*</span></label>

                    <select name="project_id"
                            class="w-full border-gray-300 rounded shadow-sm"
                            required>
                        <option value="">Select Project</option>
                        @foreach($projects as $p)
                            <option value="{{ $p->id }}">{{ $p->title }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Amount --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Amount (₹) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="amount"
                           class="w-full border-gray-300 rounded shadow-sm"
                           required>
                </div>

                {{-- Note --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Payment Note</label>
                    <textarea name="payment_note"
                              class="w-full border-gray-300 rounded shadow-sm"
                              rows="3"></textarea>
                </div>

                {{-- SUBMIT BUTTON --}}
                <div class="mt-6">

                    {{-- Button color and text changes based on type --}}
                    @if(request('type') === 'paid')
                        <button class="bg-blue-600 px-6 py-2 rounded shadow hover:bg-blue-700">
                            Save Paid Payment
                        </button>
                    @else
                        <button class="bg-green-600 px-6 py-2 rounded shadow hover:bg-green-700">
                            Save Received Payment
                        </button>
                    @endif

                </div>

            </form>

        </div>

    </div>

</x-app-layout>
