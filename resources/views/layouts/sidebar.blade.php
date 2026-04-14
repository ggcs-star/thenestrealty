{{-- ░░░ 1. HAMBURGER (show < 768 px) ░░░ --}} <header
    class="mt-[65px] sticky h-9/10 bg-gray-800 text-white flex items-start justify-between p-3 md:hidden z-10 w-16">
    <span class="font-semibold"></span>
    <button id="sidebarToggle" class="p-2 rounded focus:outline-none focus:ring-2 focus:ring-white"
        aria-label="Toggle sidebar" aria-expanded="false">
        <i class="fas fa-bars text-xl"></i>
    </button>
    </header>

    {{-- ░░░ 2. BACKDROP (mobile only) ░░░ --}}
    <div id="backdrop" class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm hidden md:hidden"></div>

    {{-- ░░░ 3. SIDEBAR ░░░ --}}
    <aside id="sidebar" class="relative top-[65px] left-0 z-10 w-64 bg-white text-black
              transform -translate-x-full transition-transform duration-300 ease-in-out
              md:fixed md:translate-x-0 md:flex md:flex-col md:shadow-lg
              h-[calc(100vh-60px)] overflow-y-auto">

        <div class="p-4">
            <ul class="space-y-3 text-sm leading-relaxed">

                {{-- █ Dashboard --}}
                @auth('web') 
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center justify-left gap-3 px-3 py-2 rounded transition {{ Request::is('dashboard') ? 'bg-[#AC7E2C] text-white' : 'hover:bg-[#AC7E2C] hover:text-white' }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                @endauth


                {{-- █ Generic Dropdown Item Template --}}
                @php
                $adminItems = [
                'Project Management' => [
                'id' => 'projectMenu',
                'icon' => 'fa-building',
                'links' => [
                ['Create Project', route('projects.create')],
                ['View Projects', route('projects.list')],
                ],
                ],
                'Customer Management' => [
                'id' => 'customerMenu',
                'icon' => 'fa-users',
                'links' => [
                ['Create Customer', route('customer.create')],
                ['View Customers', route('customer.list')],
                ],
                ],
                'Channel Partner' => [
                'id' => 'partnerMenu',
                'icon' => 'fa-handshake',
                'links' => [
                ['Create Partner', route('partner.create')],
                ['View Partner', route('partner.list')],
                ],
                ],
                'Commission' => [
                'id' => 'commissionMenu',
                'icon' => 'fa-percentage',
                'links' => [
                ['Create Commission', route('commission.create')],
                ['View Commissions', route('commission.list')],
                ],
                ],
                'Booking System' => [
                'id' => 'bookingMenu',
                'icon' => 'fa-book',
                'links' => [
                ['Create Booking', route('booking.create')],
                ['Manage Bookings', route('booking.list')],
                ],
                ],
                'Loan System' => [
                'id' => 'loanMenu',
                'icon' => 'fa-university',
                'links' => [
                ['Create Loan', route('loan.create')],
                ['Loan Tracking', route('loan.list')],
                ],
                ],
                'Collection System' => [
                'id' => 'collectionMenu',
                'icon' => 'fa-file-alt',
                'links' => [
                ['Create Collection', route('create-collection')],
                ['View Collection', route('collections.list')],
                ],
                ],
                // 'Document System' => [
                // 'id' => 'documentMenu',
                // 'icon' => 'fa-file-alt',
                // 'links' => [
                // ['Create Document', route('document.create')],
                // ['Document Builder', route('document.template')],
                // ],
                // ],
                'Employee Management' => [
                'id' => 'employeeMenu',
                'icon' => 'fa-user-tie',
                'links' => [
                ['Create Employee', route('employees.create')],
                ['View Employee', route('employees.index')],
                ['Assign Roles', route('employees.assignManager')],
                ],
                ],
                // 'System Settings' => [
                // 'id' => 'settingsMenu',
                // 'icon' => 'fa-cogs',
                // 'links' => [
                // ['Create Role', '#'],
                // ['Assign Role', '#'],
                // ],
                // ],
             

                ];
                $employeeItems = [
                'Dashboard' => ['icon' => 'fa-tachometer-alt', 'links' => [['Dashboard', route('employee.dashboard')]]],
                'Project Management' => [
                'id' => 'projectMenu',
                'icon' => 'fa-building',
                'links' => [
                ['Create Project', route('projects.create')],
                ['View Projects', route('projects.list')],
                ],
                ],

                'Customer Management' => [
                'id' => 'customerMenu',
                'icon' => 'fa-users',
                'links' => [
                ['Create Customer', route('customer.create')],
                ['View Customers', route('customer.list')],
                ],
                ],
                 'Channel Partner' => [
                'id' => 'partnerMenu',
                'icon' => 'fa-handshake',
                'links' => [
                ['Create Partner', route('partner.create')],
                ['View Partner', route('partner.list')],
                ],
                ],
                'Booking System' => [
                'id' => 'bookingMenu',
                'icon' => 'fa-book',
                'links' => [
                ['Create Booking', route('booking.create')],
                ['Manage Bookings', route('booking.list')],
                ],
                ],
                'Loan System' => [
                'id' => 'loanMenu',
                'icon' => 'fa-university',
                'links' => [
                ['Create Loan', route('loan.create')],
                ['Loan Tracking', route('loan.list')],
                ],
                ],
                  'Collection System' => [
                'id' => 'collectionMenu',
                'icon' => 'fa-file-alt',
                'links' => [
                ['Create Collection', route('create-collection')],
                ['View Collection', route('collections.list')],
                ],
                ],
                //  'Document System' => [
                // 'id' => 'documentMenu',
                // 'icon' => 'fa-file-alt',
                // 'links' => [
                // ['Create Document', route('document.create')],
                // ['Document Builder', route('document.template')],
                // ],
                // ],
                ];
                $items = auth('web')->check() ? $adminItems : $employeeItems;
                @endphp

                @foreach ($items as $title => $menu)
                @if(isset($menu['id']))
                {{-- Dropdown Menu --}}
                <li>
                    <button onclick="toggleDropdown('{{ $menu['id'] }}')"
class="w-full flex items-center justify-between px-3 py-2 rounded transition focus:outline-none
{{ Request::is(strtolower(str_replace(' ', '-', $title)).'*') ? 'bg-[#AC7E2C] text-white' : 'hover:bg-[#AC7E2C] hover:text-white' }}"                        <span class="flex items-center gap-3">
                            <i class="fas {{ $menu['icon'] }}"></i> {{ $title }}
                        </span>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200"></i>
                    </button>
                    <ul id="{{ $menu['id'] }}"
                        class="ml-6 mt-2 space-y-1 text-black hidden transition-all duration-300 ease-in-out">
                        @foreach ($menu['links'] as [$label, $url])
                        <li>
                            <a href="{{ $url }}"
class="block px-3 py-1.5 rounded transition
{{ request()->url() == $url ? 'bg-[#AC7E2C] text-white' : 'hover:bg-[#AC7E2C] hover:text-white' }}">
                                {{ $label }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                @else
                {{-- Single Link --}}
                <li>
                    <a href="{{ $menu['links'][0][1] }}"
                        class="flex items-center gap-3 px-3 py-2 rounded transition
{{ request()->url() == $menu['links'][0][1] ? 'bg-[#AC7E2C] text-white' : 'hover:bg-[#AC7E2C] hover:text-white' }}">
                        <i class="fas {{ $menu['icon'] }}"></i> {{ $title }}
                    </a>
                </li>
                @endif
                @endforeach


                {{-- █ Point System --}}
                 @auth('web') 
                <li>
                    <a href="{{ route('point-settings.index')}}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-[#AC7E2C] transition">
                        <i class="fas fa-coins"></i> Point System
                    </a>
                </li>
                @endauth

            </ul>
        </div>
    </aside>

    {{-- Main Content Wrapper --}}
    <div class="md:ml-64 mt-[85px] h-[calc(100vh-70px)] overflow-y-auto ml-16 md:ml-64">
        @yield('content')
    </div>

    {{-- ░░░ 4. JS SCRIPT ░░░ --}}
    <script>
        function toggleDropdown(id) {
            document.querySelectorAll('ul[id$="Menu"]').forEach(menu => {
                const icon = menu.previousElementSibling.querySelector('i.fas.fa-chevron-down');
                if (menu.id === id) {
                    menu.classList.toggle('hidden');
                    icon?.classList.toggle('rotate-180');
                } else {
                    menu.classList.add('hidden');
                    icon?.classList.remove('rotate-180');
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('sidebarToggle');
            const backdrop = document.getElementById('backdrop');

            const open = () => {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
                toggleBtn.setAttribute('aria-expanded', 'true');
            };

            const close = () => {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
                toggleBtn.setAttribute('aria-expanded', 'false');
            };

            toggleBtn?.addEventListener('click', () => {
                sidebar.classList.contains('-translate-x-full') ? open() : close();
            });

            backdrop?.addEventListener('click', close);
            document.addEventListener('keydown', e => {
                if (e.key === 'Escape' && !sidebar.classList.contains('-translate-x-full')) close();
            });
        });
    </script>

    {{-- ░░░ 5. STYLES / ICONS ░░░ --}}
    {{-- Add this in your main layout --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    {{-- Optional: Custom Scrollbar --}}
    <style>
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }
    </style>