<div class="h-screen sticky top-0 text-white transition-all duration-300 flex flex-col shadow-xl"
    :class="sidebarOpen ? 'w-72' : 'w-24'" style="background-color: #1f2937;"> {{-- <-- CHANGED HERE --}}

    {{-- HEADER --}}
    <div class="w-full px-4 sm:px-6 lg:px-8 flex justify-between h-16 items-center">
        <span class="" x-show="sidebarOpen" x-transition>
            App Menu
        </span>

        <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded hover:bg-white/10 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>


    {{-- NAVIGATION --}}
    <nav class="flex-1 p-4 space-y-2">

        {{-- Sidebar Link Component --}}
        @php
            function sidebar_link($route, $label, $icon)
            {
                return '
                <a href="' .
                    $route .
                    '"
                   class="group relative flex items-center gap-4 p-4 rounded-xl hover:bg-white/10 transition-colors"
                   :class="sidebarOpen ? \'justify-start\' : \'justify-center\'"
                >
                    <span class="h-6 w-6"> ' .
                    $icon .
                    ' </span>

                    <span x-show="sidebarOpen" x-transition class="text-sm font-medium">
                        ' .
                    $label .
                    '
                    </span>

                    <span x-show="!sidebarOpen"
                          class="absolute left-full ml-3 px-3 py-1 text-sm rounded bg-gray-900 text-white opacity-0 group-hover:opacity-100 transition whitespace-nowrap">
                        ' .
                    $label .
                    '
                    </span>
                </a>
                ';
            }
        @endphp


        {{-- Dashboard --}}
        {!! sidebar_link(
            route('dashboard'),
            'Dashboard',
            '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6m-6 6H7m6 0v-6m0 6h6"/>
                                            </svg>',
        ) !!}



        {{-- ADMIN SECTION --}}
        @role('admin')
            @can('project.view')
                {!! sidebar_link(
                    route('projects.index'),
                    'Manage Projects',
                    '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                                                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                                              stroke-width="2"
                                                                                              d="M3 7h18M3 12h18M3 17h18"/>
                                                                                    </svg>',
                ) !!}
            @endcan

            @can('payments.manage')
                {!! sidebar_link(
                    '/payments',
                    'Payments',
                    '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                                                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                                              stroke-width="2"
                                                                                              d="M12 8c-1.657 0-3 1.343-3 3 0 1.104.597 2.074 1.5 2.598V16h3v-2.402A3.003 3.003 0 0015 11c0-1.657-1.343-3-3-3z"/>
                                                                                    </svg>',
                ) !!}
            @endcan

            @can('clients.manage')
                {!! sidebar_link(
                    '/clients',
                    'Clients',
                    '<svg xmlns="http://www.w3.org/2000/svg" 
                                                            fill="none" viewBox="0 0 24 24" 
                                                            stroke="currentColor" class="h-6 w-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                                  d="M17 20v-2a4 4 0 00-3-3.87M9 20v-2a4 4 0 013-3.87M15 11a3 3 0 11-6 0 
                                                                     3 3 0 016 0zm6 8v-2a4 4 0 00-3-3.87M6 11a3 3 0 110-6 3 3 0 010 6zm0 3a4 4 0 00-4 4v2" />
                                                        </svg>',
                ) !!}
            @endcan
        @endrole



        {{-- USER SECTION --}}
        @role('user')
            {!! sidebar_link(
                route('projects.index'),
                'My Projects',
                '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                          stroke-width="2" d="M9 12h6m-3-3v6"/>
                                                                </svg>',
            ) !!}

            {!! sidebar_link(
                '#',
                'My Tasks',
                '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                          stroke-width="2" d="M8 7v8m4-5v5m4-3v3"/>
                                                                </svg>',
            ) !!}
        @endrole

    </nav>

</div>
