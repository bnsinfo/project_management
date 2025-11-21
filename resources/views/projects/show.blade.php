<x-app-layout>

    {{-- PAGE HEADER --}}
    <div class="flex justify-between items-center mb-6 mt-6">
        <h2 class="text-2xl font-bold">{{ $project->title }}</h2>

        <a href="{{ route('projects.index') }}"
            class="px-3 py-2 text-blue-600 border border-blue-300 rounded hover:bg-blue-100">
            ← Back
        </a>
    </div>


    {{-- TOP TWO-COLUMN LAYOUT --}}
    <div class="flex">

        {{-- LEFT: PROJECT DETAILS --}}
        <div class="bg-white shadow rounded-lg p-6" style="width: 50%;">

            <h3 class="text-xl font-semibold mb-4">Project Details</h3>

            <p class="text-gray-700 mb-4 leading-relaxed">
                {{ $project->description ?? 'No description provided.' }}
            </p>

            <div class="space-y-3">

                <p>
                    <strong class="text-gray-700">Client:</strong>
                    <span class="text-gray-900">
                        {{ optional($project->client)->name ?? 'No Client Assigned' }}
                    </span>
                </p>

                <p>
                    <strong class="text-gray-700">Assigned To:</strong>
                    <span class="text-gray-900">
                        {{ optional($project->assignedUser)->name ?? 'Unassigned' }}
                    </span>
                </p>

                <p>
                    <strong class="text-gray-700">Status:</strong>
                    <span class="capitalize text-gray-900">
                        {{ str_replace('_', ' ', $project->status) }}
                    </span>
                </p>

                <p>
                    <strong class="text-gray-700">Budget:</strong>
                    <span class="text-gray-900">
                        ₹{{ number_format($project->boudget, 2) }}
                    </span>
                </p>

                <p>
                    <strong class="text-gray-700">Deadline:</strong>
                    <span class="text-gray-900">
                        {{ $project->deadline ? \Carbon\Carbon::parse($project->deadline)->format('d M Y') : 'No deadline' }}
                    </span>
                </p>

            </div>

            @can('project.update')
                <div class="mt-6">
                    <a href="{{ route('projects.edit', $project) }}"
                        class="inline-block bg-yellow-500 px-5 py-2 rounded shadow hover:bg-yellow-600">
                        Edit Project
                    </a>
                </div>
            @endcan

        </div>


        {{-- CLIENT DETAILS CARD --}}
        <div class="bg-white shadow rounded-lg p-6" style="width: 50%;">

            <h3 class="text-xl font-semibold mb-4">Client Details</h3>

            @if ($project->client)
                <div class="space-y-3">

                    <p>
                        <strong class="text-gray-700">Name:</strong>
                        <span class="text-gray-900">{{ $project->client->name }}</span>
                    </p>

                    <p>
                        <strong class="text-gray-700">Email:</strong>
                        <span class="text-gray-900">{{ $project->client->email ?? '—' }}</span>
                    </p>

                    <p>
                        <strong class="text-gray-700">Phone:</strong>
                        <span class="text-gray-900">{{ $project->client->phone ?? '—' }}</span>
                    </p>

                    <p>
                        <strong class="text-gray-700">Company:</strong>
                        <span class="text-gray-900">{{ $project->client->company ?? '—' }}</span>
                    </p>

                    <p>
                        <strong class="text-gray-700">GST:</strong>
                        <span class="text-gray-900">{{ $project->client->gst ?? '—' }}</span>
                    </p>

                    <p>
                        <strong class="text-gray-700">Address:</strong>
                        <span class="text-gray-900">{{ $project->client->address ?? '—' }}</span>
                    </p>

                    <p>
                        <strong class="text-gray-700">Notes:</strong>
                        <span class="text-gray-900">{{ $project->client->notes ?? '—' }}</span>
                    </p>

                    <p>
                        <strong class="text-gray-700">Client Since:</strong>
                        <span class="text-gray-900">
                            {{ $project->client->created_at ? $project->client->created_at->format('d M Y') : '—' }}
                        </span>
                    </p>

                </div>
            @else
                <p class="text-gray-500">No client assigned.</p>
            @endif

        </div>


        
        
    </div>
    
    {{-- RIGHT: CLIENT DETAILS THEN PAYMENTS --}}
    <div class="space-y-6">



        {{-- PAYMENTS LIST WITH TABS (UNTOUCHED) --}}
        @can('payment.view')
            <div class="bg-white shadow rounded-lg p-6">

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold">Payments</h3>

                    @can('payment.create')
                        <a href="{{ route('payments.create') }}"
                            class="px-3 py-2 bg-green-600 text-white rounded shadow hover:bg-green-700">
                            + Add Payment
                        </a>
                    @endcan
                </div>

                {{-- TOTALS --}}
                @php
                    $totalReceived = $project->payments->where('payment_type', 'received')->sum('amount');
                    $totalPaid = $project->payments->where('payment_type', 'paid')->sum('amount');
                    $netBalance = $totalReceived - $totalPaid;
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 flex">

                    <div class="p-4 bg-green-100 border border-green-300 rounded">
                        <p class="text-sm text-gray-600 font-semibold">Total Received</p>
                        <p class="text-xl font-bold text-green-700">₹{{ number_format($totalReceived, 2) }}</p>
                    </div>

                    <div class="p-4 bg-red-100 border border-red-300 rounded">
                        <p class="text-sm text-gray-600 font-semibold">Total Paid</p>
                        <p class="text-xl font-bold text-red-700">₹{{ number_format($totalPaid, 2) }}</p>
                    </div>

                    <div class="p-4 bg-blue-100 border border-blue-300 rounded">
                        <p class="text-sm text-gray-600 font-semibold">Net Balance</p>
                        <p class="text-xl font-bold text-blue-700">₹{{ number_format($netBalance, 2) }}</p>
                    </div>

                </div>


                {{-- TABS --}}
                <div class="flex gap-6 mb-4 border-b pb-2">

                    <a href="?payment_tab=received"
                        class="inline-block bg-yellow-500 px-5 py-2 rounded shadow hover:bg-yellow-600
            {{ request('payment_tab') !== 'paid' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500' }}">
                        Received Payments
                    </a>

                    <a href="?payment_tab=paid"
                        class="inline-block bg-yellow-500 px-5 py-2 rounded shadow hover:bg-yellow-600
            {{ request('payment_tab') === 'paid' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500' }}">
                        Paid Payments
                    </a>

                </div>


                {{-- FILTER PAYMENTS --}}
                @php
                    $filteredPayments = $project->payments->filter(function ($payment) {
                        return request('payment_tab') === 'paid'
                            ? $payment->payment_type === 'paid'
                            : $payment->payment_type === 'received';
                    });
                @endphp


                {{-- SHOW TABLE --}}
                @if ($filteredPayments->isEmpty())
                    <p class="text-gray-500">
                        No {{ request('payment_tab') === 'paid' ? 'paid' : 'received' }} payments found.
                    </p>
                @else
                    <table class="w-full border">
                        <thead>
                            <tr class="bg-gray-100 text-left">
                                <th class="p-2 border">Amount</th>
                                <th class="p-2 border">Note</th>
                                <th class="p-2 border">Type</th>
                                <th class="p-2 border">Date</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($filteredPayments as $pay)
                                <tr>
                                    <td class="p-2 border">
                                        ₹{{ number_format($pay->amount, 2) }}
                                    </td>

                                    <td class="p-2 border">
                                        {{ $pay->payment_note ?? '-' }}
                                    </td>

                                    <td class="p-2 border">
                                        @if ($pay->payment_type === 'received')
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
                                        {{ $pay->created_at->format('d M Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

            </div>
        @endcan

    </div>


    {{-- FOLLOW UP SECTION --}}
    @if (!$followUps->isEmpty())
        <div class="bg-white shadow rounded-lg p-6 mt-6">

            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Follow Ups</h3>

                <a href="{{ route('projects.followup.add', $project->id) }}"
                    class="px-3 py-2 bg-blue-600 rounded hover:bg-blue-700 shadow text-white">
                    + Add Follow Up
                </a>
            </div>

            <div class="space-y-4">
                @foreach ($followUps as $f)
                    <div class="border rounded-lg p-4 bg-gray-50 mt-4">

                        <h4 class="font-bold text-lg">{{ $f->heading }}</h4>

                        @if ($f->description)
                            <p class="text-gray-700 mt-2 leading-relaxed">{{ $f->description }}</p>
                        @endif

                        <p class="text-sm text-gray-500 mt-3">
                            Added by:
                            <strong>{{ $f->user->name ?? 'Unknown' }}</strong>
                            •
                            {{ $f->created_at->format('d M Y h:i A') }}
                        </p>

                    </div>
                @endforeach
            </div>

        </div>
    @endif

</x-app-layout>
