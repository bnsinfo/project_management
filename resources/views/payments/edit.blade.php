<x-app-layout>

    <div class="max-w-3xl mx-auto">

        <div class="flex justify-between items-center mb-6 mt-6">
            <h2 class="text-2xl font-bold">Edit Payment</h2>

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

            <form action="{{ route('payments.update', $payment->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Project --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Project <span class="text-red-500">*</span></label>

                    <select name="project_id"
                            class="w-full border-gray-300 rounded shadow-sm"
                            required>
                        @foreach($projects as $p)
                            <option value="{{ $p->id }}"
                                    {{ $payment->project_id == $p->id ? 'selected' : '' }}>
                                {{ $p->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Amount --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Amount (₹) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="amount"
                           class="w-full border-gray-300 rounded shadow-sm"
                           value="{{ $payment->amount }}"
                           required>
                </div>

                {{-- Note --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Payment Note</label>
                    <textarea name="payment_note"
                              class="w-full border-gray-300 rounded shadow-sm"
                              rows="3">{{ $payment->payment_note }}</textarea>
                </div>

                <div class="mt-6">
                    <button
                        class="bg-blue-600 px-6 py-2 rounded shadow hover:bg-blue-700">
                        Update Payment
                    </button>
                </div>

            </form>

        </div>

    </div>

</x-app-layout>
