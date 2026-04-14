@auth('web')
    @php
        $totalPartners = \App\Models\ChannelPartner::count();
        $totalProject = \App\Models\Project::count();
        $totalBooking = \App\Models\Booking::count();
        $totalCollection = \App\Models\Collection::count();
        $totalCommission = \App\Models\Commission::count();
        $totalEmployees = \App\Models\Employee::count();

        $allFollowUps = \App\Models\Collection::with('booking')->orderBy('date', 'desc')->get();

        $today = \Carbon\Carbon::today();

        $todayFollowUps = $allFollowUps
            ->filter(fn($item) => \Carbon\Carbon::parse($item->date)->isSameDay($today))
            ->take(3);

        $historyFollowUps = $allFollowUps
            ->filter(fn($item) => \Carbon\Carbon::parse($item->date)->lt($today))
            ->take(3);

        $recentFollowUps = $allFollowUps->take(3);

        $latestBooking = \App\Models\Booking::with('booking')->orderBy('booking_date')->get();

        $todayBooking = $latestBooking
            ->filter(fn($item) => \Carbon\Carbon::parse($item->booking_date)->isSameDay($today))
            ->take(3);
    @endphp

<!-- Responsive Dashboard Section -->
<div class="flex-1 p-4 sm:p-6 min-h-full">
    <!-- Breadcrumb -->
    <nav class="text-sm mb-6">
        <a href="#" class="text-blue-500 hover:underline">Home</a> /
        <span class="font-semibold">Dashboard</span>
    </nav>

    <!-- Stat Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-5 mb-10 pt-6">

    <!-- CARD 1 -->
    <div class="rounded-2xl p-5 text-gray-800 shadow-sm hover:shadow-md transition bg-gradient-to-br from-yellow-50 to-yellow-100 border border-yellow-200">
        <div class="text-3xl font-bold text-yellow-700">{{ $totalPartners }}</div>
        <div class="text-sm text-gray-600">Total Partners</div>

        <a href="{{ route('partner.list') }}">
            <div class="mt-3 text-sm font-semibold text-yellow-700 hover:underline">
                View Details →
            </div>
        </a>
    </div>

    <!-- CARD 2 -->
    <div class="rounded-2xl p-5 text-gray-800 shadow-sm hover:shadow-md transition bg-gradient-to-br from-green-50 to-green-100 border border-green-200">
        <div class="text-3xl font-bold text-green-700">{{ $totalProject }}</div>
        <div class="text-sm text-gray-600">Projects</div>

        <a href="{{ route('projects.list') }}">
            <div class="mt-3 text-sm font-semibold text-green-700 hover:underline">
                View Details →
            </div>
        </a>
    </div>

    <!-- CARD 3 -->
    <div class="rounded-2xl p-5 text-gray-800 shadow-sm hover:shadow-md transition bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200">
        <div class="text-3xl font-bold text-purple-700">{{$totalBooking}}</div>
        <div class="text-sm text-gray-600">Bookings</div>

        <a href="{{ route('bookings.list') }}">
            <div class="mt-3 text-sm font-semibold text-purple-700 hover:underline">
                View Details →
            </div>
        </a>
    </div>

    <!-- CARD 4 -->
    <div class="rounded-2xl p-5 text-gray-800 shadow-sm hover:shadow-md transition bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200">
        <div class="text-3xl font-bold text-blue-700">{{$totalCollection}}</div>
        <div class="text-sm text-gray-600">Collections</div>

        <a href="{{ route('collections.list') }}">
            <div class="mt-3 text-sm font-semibold text-blue-700 hover:underline">
                View Details →
            </div>
        </a>
    </div>

    <!-- CARD 5 -->
    <div class="rounded-2xl p-5 text-gray-800 shadow-sm hover:shadow-md transition bg-gradient-to-br from-orange-50 to-orange-100 border border-orange-200">
        <div class="text-3xl font-bold text-orange-700">{{$totalCommission}}</div>
        <div class="text-sm text-gray-600">Commission</div>

        <a href="{{ route('commissions.list') }}">
            <div class="mt-3 text-sm font-semibold text-orange-700 hover:underline">
                View Details →
            </div>
        </a>
    </div>

    <!-- CARD 6 -->
    <div class="rounded-2xl p-5 text-gray-800 shadow-sm hover:shadow-md transition bg-gradient-to-br from-red-50 to-red-100 border border-red-200">
        <div class="text-3xl font-bold text-red-700">{{$totalEmployees}}</div>
        <div class="text-sm text-gray-600">Employees</div>

        <a href="{{ route('employees.index') }}">
            <div class="mt-3 text-sm font-semibold text-red-700 hover:underline">
                View Details →
            </div>
        </a>
    </div>

</div>

    <!-- Follow-up Status Section -->
    <div class="mb-4">
        <h2 class="text-xl font-bold text-gray-800">Collection Followup</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Today's Follow-ups -->
        <div class="bg-white rounded shadow p-4 flex flex-col h-full min-h-[340px]">
            <h3 class="text-lg font-semibold mb-3 text-gray-700">Today's Follow-ups</h3>

            <div class="space-y-3 flex-grow">
                @forelse($todayFollowUps as $item)
                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                        <div>
                            <p class="font-medium">{{ ucfirst($item->mode) }}</p>
                            <p class="text-sm text-gray-500">
                                Amount: ₹{{ number_format($item->amount) }}<br>
                                {{-- Booking ID: {{ $item->bookings->booking_id ?? 'N/A' }} --}}
                                Booking ID: {{ $item->booking->booking_id ?? 'N/A' }}

                            </p>
                        </div>
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">Due Today</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No follow-ups today</p>
                @endforelse
            </div>

            {{-- <a href="{{ route('collections.list') }}">
                <h5 class="text-center py-2 mt-auto text-blue-600 hover:underline cursor-pointer">View All</h5>
            </a> --}}

            <a href="{{ route('collections.list', ['filter' => 'today']) }}" class="group flex justify-center mt-2">
                <div class="relative inline-block">
                    <h5
                        class="text-center py-2 mt-auto text-white bg-[#AC7E2C] hover:bg-[#8C651F] cursor-pointer rounded-md px-4 group-hover:text-white">
                        View All
                    </h5>
                </div>
            </a>




        </div>


        <!-- Follow-ups History -->
        <div class="bg-white rounded shadow p-4 flex flex-col h-full min-h-[340px]">
            <h3 class="text-lg font-semibold mb-3 text-gray-700">Backlog Follow up</h3>

            <div class="space-y-3 flex-grow">
                @forelse($historyFollowUps as $item)
                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                        <div>
                            <p class="font-medium">{{ ucfirst($item->mode) }}</p>
                            <p class="text-sm text-gray-500 leading-snug">
                                Amount: ₹{{ number_format($item->amount) }}<br>
                                Booking ID:
                                @if ($item->booking && $item->booking->booking_id)
                                    {{ $item->booking->booking_id }}
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($item->date)->diffForHumans() }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No backlog follow-ups</p>
                @endforelse
            </div>

            <a href="{{ route('collections.list', ['filter' => 'backlog']) }}" class="group flex justify-center mt-2">
                <div class="relative inline-block">
                    <h5
                        class="text-center py-2 mt-auto text-white bg-[#AC7E2C] hover:bg-[#8C651F] cursor-pointer rounded-md px-4 group-hover:text-white">
                        View All
                    </h5>
                </div>
            </a>


        </div>



        <!-- Recent Follow-ups -->
        <div class="bg-white rounded shadow p-4 flex flex-col h-full min-h-[340px]">
            <h3 class="text-lg font-semibold mb-3 text-gray-700">Upcoming Follow up</h3>
            <div class="space-y-3">
                @foreach($recentFollowUps as $item)
                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                        <div>
                            <p class="font-medium">{{ ucfirst($item->mode) }}</p>
                            <p class="text-sm text-gray-500">
                                Date: {{ \Carbon\Carbon::parse($item->date)->format('d M Y') }}<br>
                                Booking ID: {{ $item->booking->booking_id ?? 'N/A' }}
                            </p>
                        </div>
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                            ₹{{ number_format($item->amount) }}
                        </span>
                    </div>
                @endforeach
            </div>
            <a href="{{ route('collections.list', ['filter' => 'upcoming']) }}" class="group flex justify-center mt-2">
                <div class="relative inline-block">
                    <h5
                        class="text-center py-2 mt-auto text-white bg-[#AC7E2C] hover:bg-[#8C651F] cursor-pointer rounded-md px-4 group-hover:text-white">
                        View All
                    </h5>
                </div>
            </a>

        </div>

        <!-- Complete Follow-up -->
        <div class="bg-white rounded shadow p-4 flex flex-col h-full min-h-[340px]">
            <h3 class="text-lg font-semibold mb-3 text-gray-700">Complete Follow up</h3>
            <div class="space-y-3">
                @foreach($recentFollowUps as $item)
                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                        <div>
                            <p class="font-medium">{{ ucfirst($item->mode) }}</p>
                            <p class="text-sm text-gray-500">
                                Date: {{ \Carbon\Carbon::parse($item->date)->format('d M Y') }}<br>
                                Booking ID: {{ $item->booking->booking_id ?? 'N/A' }}
                            </p>
                        </div>
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                            ₹{{ number_format($item->amount) }}
                        </span>
                    </div>
                @endforeach
            </div>
<a href="{{ route('collections.list', ['filter' => 'complete']) }}" class="group flex justify-center mt-2">
                <div class="relative inline-block">
                    <h5
                        class="text-center py-2 mt-auto text-white bg-[#AC7E2C] hover:bg-[#8C651F] cursor-pointer rounded-md px-4 group-hover:text-white">
                        View All
                    </h5>
                </div>
            </a>

        </div>
    </div>
    <!-- Booking Reports Section -->
    <div class="mb-4">
        <h2 class="text-xl font-bold text-gray-800">Booking Followup</h2>
    </div>

    <!-- Grid Container for Both Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-8">
        <!-- Latest Bookings -->
        <div class="bg-white rounded shadow p-4">
            <h3 class="text-lg font-semibold mb-3 text-gray-700">Latest Bookings</h3>
            <div class="space-y-3">
                @forelse ($todayBooking as $booking)
                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                        <div class="flex flex-col">

                            <div>
                                <p class="text-md font-semibold text-black">Booking ID: {{ $booking->booking_id ?? 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Booking Date: {{ $booking->booking_date ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Followup Date: {{ $booking->followup_date ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <span class="flex flex-col text-sm px-4 text-gray-500">
                            <span class="px-2 py-1 ">
                                Unit Name: {{ $booking->unit_name ?? 'N/A' }}
                            </span>
                            <span class="px-2 py-1 ">
                                Unit Size: {{ $booking->unit_size ?? 'N/A' }} {{ $booking->unit_unit ?? 'N/A' }}
                            </span>
                        </span>
                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                            ₹{{ number_format($booking->total_amount ?? 0, 2) }}
                        </span>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">No bookings today.</p>
                @endforelse
            </div>
        </div>

        <!-- Booking Pipeline -->
        <div class="bg-white rounded shadow p-4">
            <h3 class="text-lg font-semibold mb-3 text-gray-700">Booking Pipeline</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                    <div>
                        <p class="font-medium">Royal Heights</p>
                        <p class="text-sm text-gray-500">Client: Sarah Parker</p>
                    </div>
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">In Progress</span>
                </div>
                <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                    <div>
                        <p class="font-medium">Ocean View</p>
                        <p class="text-sm text-gray-500">Client: Mike Johnson</p>
                    </div>
                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm">Pending</span>
                </div>
                <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                    <div>
                        <p class="font-medium">City Center</p>
                        <p class="text-sm text-gray-500">Client: Emma Davis</p>
                    </div>
                    <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-sm">Under Review</span>
                </div>
            </div>
        </div>
    </div>


    <!-- Reports Section -->
    <div class="mb-4">
        <h2 class="text-xl font-bold text-gray-800">Reports</h2>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-8">
        <!-- Partner Chart -->
        <div class="bg-white rounded shadow p-4">
            <h3 class="text-lg font-semibold mb-3 text-gray-700">Partners</h3>
            <div class="relative h-48">
                <canvas id="partnerChart"></canvas>
            </div>
        </div>

        <!-- Collection Chart -->
        <div class="bg-white rounded shadow p-4">
            <h3 class="text-lg font-semibold mb-3 text-gray-700">Collections</h3>
            <div class="relative h-48">
                <canvas id="revenueDistributionChart"></canvas>
            </div>
        </div>

        <!-- Commission Chart -->
        <div class="bg-white rounded shadow p-4">
            <h3 class="text-lg font-semibold mb-3 text-gray-700">Commission</h3>
            <div class="relative h-48">
                <canvas id="projectStatusChart"></canvas>
            </div>
        </div>

        <!-- Today's Report -->
        <div class="bg-white rounded shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Today's Report</h2>
            <div class="relative h-56">
                <canvas id="pieChart"></canvas>
            </div>
            <div class="mt-6 space-y-2 text-sm">
                <div class="flex justify-between">
                    <span>Total Booking</span><span>₹0</span>
                </div>
                <div class="flex justify-between">
                    <span>Total Projects</span><span>₹0</span>
                </div>
                <div class="flex justify-between">
                    <span>Cash Received</span><span>₹0</span>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Charts Section -->
    <div class="hidden grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 bg-white rounded shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Monthly Progress Report</h2>
            <div class="flex flex-col sm:flex-row sm:items-center gap-2 mb-4">
                <input type="text" class="border border-gray-300 rounded px-4 py-2 w-full sm:w-48" value="April 2025"
                    readonly />
                <button class="bg-[#AC7E2C] hover:bg-[#8C651F] text-white px-4 py-2 rounded w-full sm:w-auto">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <div class="relative h-64 sm:h-80">
                <canvas id="barChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Today's Report</h2>
            <div class="relative h-56">
                <canvas id="pieChart"></canvas>
            </div>
            <div class="mt-6 space-y-2 text-sm">
                <div class="flex justify-between">
                    <span>Total Booking</span><span>₹0</span>
                </div>
                <div class="flex justify-between">
                    <span>Total Projects</span><span>₹0</span>
                </div>
                <div class="flex justify-between">
                    <span>Cash Received</span><span>₹0</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart JS Script -->
<script>
    // ---- Bar Chart ----
    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: [
                'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
            ],
            datasets: [{
                label: 'Monthly Sales (₹)',
                backgroundColor: '#60A5FA',
                borderRadius: 4,
                data: [
                    12000, 15000, 10000, 18000, 14000, 16000,
                    19000, 18500, 18000, 22000, 21000, 23000
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => `₹${value}`
                    }
                }
            }
        }
    });

    // ---- Pie Chart ----
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: ['Total Booking', 'Total Projects', 'Cash Received'],
            datasets: [{
                data: [20, 10, 70],
                backgroundColor: ['#5BC0BE', '#FF6B6B', '#FFE066']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Partner Chart
    const partnerCtx = document.getElementById('partnerChart').getContext('2d');
    new Chart(partnerCtx, {
        type: 'pie',
        data: {
            labels: ['Total Partner', 'Partner Approved', 'Pending Partner'],
            datasets: [{
                data: [30, 25, 20, 25],
                backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Collection Chart
    const revenueDistributionCtx = document.getElementById('revenueDistributionChart').getContext('2d');
    new Chart(revenueDistributionCtx, {
        type: 'pie',
        data: {
            labels: ['Pending', 'Received'],
            datasets: [{
                data: [70, 30],
                backgroundColor: ['#EF4444', '#10B981']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Commission Chart
    const projectStatusCtx = document.getElementById('projectStatusChart').getContext('2d');
    new Chart(projectStatusCtx, {
        type: 'pie',
        data: {
            labels: ['Pending', 'Received'],
            datasets: [{
                data: [8, 20],
                backgroundColor: ['#EF4444', '#10B981']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endauth
