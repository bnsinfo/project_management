<x-app-layout>

<div x-data="{ open: false }" >

    {{-- PAGE HEADER --}}
    <div class="flex justify-between items-center mb-6 mt-6">
        <h2 class="text-2xl font-bold">Payments</h2>
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif


    {{-- ===================== --}}
    {{-- PAYMENT TYPE BUTTONS  --}}
    {{-- ===================== --}}
    <div class="flex items-center gap-3 mb-6">

        {{-- RECEIVED BUTTON --}}
        <a href="{{ route('payments.index', ['type' => 'received']) }}"
           class="px-4 py-2 rounded shadow 
           {{ request('type') === 'paid' 
                ? 'border border-gray-400 text-gray-700 hover:bg-gray-100' 
                : 'bg-blue-600 hover:bg-blue-700' }}">
            Received Payments
        </a>

        {{-- PAID BUTTON --}}
        <a href="{{ route('payments.index', ['type' => 'paid']) }}"
           class="px-4 py-2 rounded shadow
           {{ request('type') === 'paid'
                ? 'bg-blue-600 hover:bg-blue-700' 
                : 'border border-gray-400 text-gray-700 hover:bg-gray-100' }}">
            Paid Payments
        </a>

        {{-- ADD PAYMENT BUTTON (Opens Modal) --}}
        <button @click="open = true"
            class="ml-auto px-4 py-2 bg-black rounded shadow hover:bg-gray-900 text-white">
            + Add Payment
        </button>

    </div>


    {{-- ===================== --}}
    {{-- PAYMENTS TABLE        --}}
    {{-- ===================== --}}
    <div class="bg-white shadow rounded p-4">

        <table class="w-full border">
            <thead>
                <tr class="bg-gray-100 text-left" style="text-align: left;">
                    <th class="p-2 border">#</th>
                    <th class="p-2 border">Project</th>
                    <th class="p-2 border">Amount (₹)</th>
                    <th class="p-2 border">Note</th>
                    <th class="p-2 border">Type</th>
                    <th class="p-2 border">Date</th>
                    <th class="p-2 border">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($payments as $key => $payment)
                    <tr>
                        <td class="p-2 border">{{ $key + 1 }}</td>

                        <td class="p-2 border">
                            {{ $payment->project->title ?? '-' }}
                        </td>

                        <td class="p-2 border">
                            ₹{{ number_format($payment->amount, 2) }}
                        </td>

                        <td class="p-2 border">
                            {{ $payment->payment_note ?? '-' }}
                        </td>

                        {{-- TYPE BADGE --}}
                        <td class="p-2 border">
                            @if($payment->payment_type === 'received')
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-sm">
                                    Received
                                </span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-sm">
                                    Paid
                                </span>
                            @endif
                        </td>

                        <td class="p-2 border">
                            {{ $payment->created_at->format('d M, Y') }}
                        </td>

                        <td class="p-2 border">
                            <a href="{{ route('payments.edit', $payment->id) }}"
                               class="text-blue-600 hover:underline">
                                Edit
                            </a>

                            <form action="{{ route('payments.destroy', $payment->id) }}"
                                  method="POST"
                                  class="inline-block ml-2"
                                  onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="7" class="text-center p-4 text-gray-500">
                            No payments found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>


        {{-- PAGINATION --}}
        <div class="mt-4">
            {{ $payments->links() }}
        </div>
    </div>



    {{-- ===================== --}}
    {{-- PAYMENT TYPE MODAL    --}}
    {{-- ===================== --}}
    <div x-show="open"
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
         x-transition>

        <div class="bg-white rounded-lg p-6 shadow-lg w-full max-w-md"
             @click.away="open = false" style="max-width: 600px;">

            <h2 class="text-xl font-semibold mb-4">Choose Payment Type</h2>

            <p class="text-gray-600 mb-6">Select which type of payment you want to create.</p>

            <div class="flex justify-between gap-3">

                {{-- Received Payment --}}
                <a href="{{ route('payments.create', ['type' => 'received']) }}"
                   class="px-4 py-2 rounded shadow bg-blue-600 hover:bg-blue-700">
                    Create Received Payment
                </a>

                {{-- Paid Payment --}}
                <a href="{{ route('payments.create', ['type' => 'paid']) }}"
                   class="px-4 py-2 rounded shadow bg-blue-600 hover:bg-blue-700">
                    Create Paid Payment
                </a>

            </div>

            <button @click="open = false"
                    class="mt-6 w-full border border-gray-400 text-gray-700 py-2 rounded hover:bg-gray-100">
                Cancel
            </button>
        </div>

    </div>

</div>

</x-app-layout>
