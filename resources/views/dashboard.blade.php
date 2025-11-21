<x-app-layout>

    <h1 class="text-3xl font-bold mb-6 mt-6">Dashboard</h1>

    {{-- CARD TEMPLATE --}}
    @php
        $cardClass = "flex flex-col justify-center items-center 
                      min-w-[250px] flex-1 
                      p-4 rounded-xl shadow-md hover:shadow-lg 
                      transition-all text-center";
    @endphp



    {{-- ================================================= --}}
    {{-- ADMIN DASHBOARD                                    --}}
    {{-- ================================================= --}}
    @role('admin')

    <div class="flex flex-wrap gap-4">

        {{-- TOTAL PROJECTS --}}
        <div class="{{ $cardClass }} bg-white">
            <h2 class="text-lg font-semibold">Total Projects</h2>
            <p class="text-4xl font-bold mt-2">{{ $stats['total_projects'] }}</p>
        </div>

        {{-- TOTAL BUDGET --}}
        <div class="{{ $cardClass }} bg-purple-100">
            <h2 class="text-lg font-semibold text-purple-700">Total Budget</h2>
            <p class="text-4xl font-bold mt-2 text-purple-900">
                ₹{{ number_format($stats['total_budget'], 2) }}
            </p>
        </div>

        {{-- COMPLETED --}}
        <div class="{{ $cardClass }} bg-green-100">
            <h2 class="text-lg font-semibold text-green-700">Completed</h2>
            <p class="text-4xl font-bold mt-2 text-green-900">
                {{ $stats['completed_projects'] }}
            </p>
        </div>

        {{-- IN PROGRESS --}}
        <div class="{{ $cardClass }} bg-blue-100">
            <h2 class="text-lg font-semibold text-blue-700">In Progress</h2>
            <p class="text-4xl font-bold mt-2 text-blue-900">
                {{ $stats['in_progress'] }}
            </p>
        </div>

        {{-- STUCK --}}
        <div class="{{ $cardClass }} bg-red-100">
            <h2 class="text-lg font-semibold text-red-700">Stuck</h2>
            <p class="text-4xl font-bold mt-2 text-red-900">
                {{ $stats['stuck'] }}
            </p>
        </div>

        {{-- NOT STARTED --}}
        <div class="{{ $cardClass }} bg-yellow-100">
            <h2 class="text-lg font-semibold text-yellow-700">Not Started</h2>
            <p class="text-4xl font-bold mt-2 text-yellow-900">
                {{ $stats['not_started'] }}
            </p>
        </div>

        {{-- TOTAL RECEIVED --}}
        <div class="{{ $cardClass }} bg-white">
            <h2 class="text-lg font-semibold">Total Received</h2>
            <p class="text-4xl font-bold mt-2 text-green-700">
                ₹{{ number_format($stats['total_received'], 2) }}
            </p>
        </div>

        {{-- TOTAL PAID --}}
        <div class="{{ $cardClass }} bg-white">
            <h2 class="text-lg font-semibold">Total Paid</h2>
            <p class="text-4xl font-bold mt-2 text-red-700">
                ₹{{ number_format($stats['total_paid'], 2) }}
            </p>
        </div>

        {{-- BALANCE --}}
        <div class="{{ $cardClass }} bg-white">
            <h2 class="text-lg font-semibold">Balance Remaining</h2>
            <p class="text-4xl font-bold mt-2 text-blue-700">
                ₹{{ number_format($stats['total_received'] - $stats['total_paid'], 2) }}
            </p>
        </div>

    </div>


    {{-- CHART AREA --}}
    <div class="mt-10 bg-white p-4 rounded-xl shadow mt-4">
        <h2 class="text-xl font-bold mb-4">Overview Charts</h2>
        <p class="text-gray-600">Charts will be added here.</p>
    </div>

    @endrole



    {{-- ================================================= --}}
    {{-- USER DASHBOARD                                     --}}
    {{-- ================================================= --}}
    @role('user')

    <div class="flex flex-wrap gap-4">

        {{-- MY PROJECTS --}}
        <div class="{{ $cardClass }} bg-white">
            <h2 class="text-lg font-semibold">My Projects</h2>
            <p class="text-4xl font-bold mt-2">{{ $stats['total_my_projects'] }}</p>
        </div>

        {{-- USER BUDGET --}}
        <div class="{{ $cardClass }} bg-purple-100">
            <h2 class="text-lg font-semibold text-purple-700">My Total Budget</h2>
            <p class="text-4xl font-bold mt-2 text-purple-900">
                ₹{{ number_format($stats['total_user_budget'], 2) }}
            </p>
        </div>

        {{-- COMPLETED --}}
        <div class="{{ $cardClass }} bg-green-100">
            <h2 class="text-lg font-semibold text-green-700">Completed</h2>
            <p class="text-4xl font-bold mt-2 text-green-900">{{ $stats['my_completed'] }}</p>
        </div>

        {{-- IN PROGRESS --}}
        <div class="{{ $cardClass }} bg-blue-100">
            <h2 class="text-lg font-semibold text-blue-700">In Progress</h2>
            <p class="text-4xl font-bold mt-2 text-blue-900">{{ $stats['my_in_progress'] }}</p>
        </div>

        {{-- STUCK --}}
        <div class="{{ $cardClass }} bg-red-100">
            <h2 class="text-lg font-semibold text-red-700">Stuck</h2>
            <p class="text-4xl font-bold mt-2 text-red-900">{{ $stats['my_stuck'] }}</p>
        </div>

        {{-- NOT STARTED --}}
        <div class="{{ $cardClass }} bg-yellow-100">
            <h2 class="text-lg font-semibold text-yellow-700">Not Started</h2>
            <p class="text-4xl font-bold mt-2 text-yellow-900">{{ $stats['my_not_started'] }}</p>
        </div>

        {{-- USER RECEIVED --}}
        <div class="{{ $cardClass }} bg-white">
            <h2 class="text-lg font-semibold">My Received</h2>
            <p class="text-4xl font-bold mt-2 text-green-700">
                ₹{{ number_format($stats['my_received'], 2) }}
            </p>
        </div>

        {{-- USER PAID --}}
        <div class="{{ $cardClass }} bg-white">
            <h2 class="text-lg font-semibold">My Paid</h2>
            <p class="text-4xl font-bold mt-2 text-red-700">
                ₹{{ number_format($stats['my_paid'], 2) }}
            </p>
        </div>

        {{-- USER BALANCE --}}
        <div class="{{ $cardClass }} bg-white">
            <h2 class="text-lg font-semibold">My Balance</h2>
            <p class="text-4xl font-bold mt-2 text-blue-700">
                ₹{{ number_format($stats['my_received'] - $stats['my_paid'], 2) }}
            </p>
        </div>

    </div>

    @endrole


</x-app-layout>
