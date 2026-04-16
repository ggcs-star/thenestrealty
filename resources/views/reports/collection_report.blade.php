@php
    $hideDashboard = true;
@endphp

@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 py-6">

            {{-- KPI Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-6">
                {{-- Total Demand --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center" style="background-color: rgba(170, 125, 49, 0.1);">
                            <i class="fas fa-file-invoice text-xl" style="color: #AA7D31;"></i>
                        </div>
                        <span class="px-3 py-1.5 text-xs font-medium rounded-full" style="background-color: rgba(170, 125, 49, 0.1); color: #AA7D31;">Total</span>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">₹ {{ amountToPoints($totalDemand) }}</h2>
                    <div class="flex items-center gap-2 text-sm">
                        <span class="text-gray-600">Total Demand</span>
                        <span class="px-2 py-0.5 bg-gray-100 text-gray-700 text-xs font-medium rounded-full">+12% vs last month</span>
                    </div>
                </div>

                {{-- Collected --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-green-50">
                            <i class="fas fa-check-circle text-xl text-green-600"></i>
                        </div>
                        <span class="px-3 py-1.5 text-xs font-medium rounded-full bg-green-100 text-green-700">Collected</span>
                    </div>
                    <h2 class="text-3xl font-bold text-green-600 mb-2">₹ {{ amountToPoints($totalCollection) }}</h2>
                    <div class="flex items-center gap-2 text-sm">
                        <span class="text-gray-600">Total Collected</span>
                        <span class="px-2 py-0.5 bg-gray-100 text-gray-700 text-xs font-medium rounded-full">+8% vs last month</span>
                    </div>
                </div>

                {{-- Overdue --}}
            

                {{-- Efficiency --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center" style="background-color: rgba(170, 125, 49, 0.1);">
                            <i class="fas fa-tachometer-alt text-xl" style="color: #AA7D31;"></i>
                        </div>
                        <span class="px-3 py-1.5 text-xs font-medium rounded-full" style="background-color: rgba(170, 125, 49, 0.1); color: #AA7D31;">Efficiency</span>
                    </div>
                    <h2 class="text-3xl font-bold mb-2" style="color: #AA7D31;">{{ $efficiency }}%</h2>
                    <div class="flex items-center gap-2 text-sm">
                        <span class="text-gray-600">Collection Rate</span>
                        <span class="px-2 py-0.5 bg-gray-100 text-gray-700 text-xs font-medium rounded-full">+5% vs target</span>
                    </div>
                </div>
            </div>

          {{-- Filters Card --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-6">
    <div class="flex flex-wrap items-center gap-3 mb-5">
        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0" style="background-color: rgba(170, 125, 49, 0.1);">
            <i class="fas fa-sliders-h" style="color: #AA7D31;"></i>
        </div>
        <div class="flex-1 min-w-0">
            <h3 class="font-semibold text-gray-800">Filters & Search</h3>
            <p class="text-gray-500 text-sm">Refine your collection data</p>
        </div>
        @if(request()->anyFilled(['search', 'status', 'from_date', 'to_date']))
            <div class="flex-shrink-0">
                <span class="px-4 py-2 text-sm font-medium rounded-full whitespace-nowrap" style="background-color: rgba(170, 125, 49, 0.1); color: #AA7D31;">
                    {{ $total }} Results Found
                </span>
            </div>
        @endif
    </div>

    <form method="GET" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
            {{-- Search --}}
            <div class="md:col-span-3">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Search</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" name="search" placeholder="Customer, Booking ID..." value="{{ request('search') }}"
                        class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:border-amber-500"
                        style="--tw-ring-color: rgba(170, 125, 49, 0.2);">
                </div>
            </div>

            {{-- Status Filter --}}
            <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Status</label>
                <select name="status"
                    class="w-full py-2.5 px-3 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:border-amber-500"
                    style="--tw-ring-color: rgba(170, 125, 49, 0.2);">
                    <option value="">All Status</option>
                    @foreach($statusCounts as $status)
                        <option value="{{ $status['id'] }}" {{ request('status') == $status['id'] ? 'selected' : '' }}>
                            {{ ucfirst($status['name']) }} ({{ $status['count'] }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Date Range --}}
            <div class="md:col-span-3">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Date Range</label>
                <div class="flex items-center gap-2">
                    <input type="date" name="from_date" value="{{ request('from_date') }}"
                        class="flex-1 min-w-0 py-2.5 px-3 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:border-amber-500"
                        style="--tw-ring-color: rgba(170, 125, 49, 0.2);">
                    <span class="text-gray-400 flex-shrink-0">—</span>
                    <input type="date" name="to_date" value="{{ request('to_date') }}"
                        class="flex-1 min-w-0 py-2.5 px-3 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:border-amber-500"
                        style="--tw-ring-color: rgba(170, 125, 49, 0.2);">
                </div>
            </div>

            {{-- Actions --}}
            <div class="md:col-span-4">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 hidden md:block">&nbsp;</label>
                <div class="flex flex-wrap sm:flex-nowrap gap-2">
                    <button type="submit"
                        class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 text-white text-sm font-medium rounded-lg hover:opacity-90 transition-all duration-200 shadow-sm whitespace-nowrap"
                        style="background-color: #AA7D31;">
                        <i class="fas fa-filter"></i> Apply Filters
                    </button>
                    <a href="{{ route('collections.report') }}"
                        class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-all duration-200 whitespace-nowrap">
                        <i class="fas fa-times"></i> Clear All
                    </a>
                </div>
            </div>
        </div>
    </form>

    {{-- Active Filters Tags --}}
    @if(request()->anyFilled(['search', 'status', 'from_date', 'to_date']))
        <div class="flex flex-wrap gap-2 mt-5 pt-4 border-t border-gray-100">
            @if(request('search'))
                <span class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium rounded-full border whitespace-nowrap"
                    style="background-color: rgba(170, 125, 49, 0.08); color: #7a5c24; border-color: rgba(170, 125, 49, 0.15);">
                    <i class="fas fa-search text-xs"></i>
                    <span class="max-w-[150px] truncate">Search: {{ request('search') }}</span>
                    <a href="{{ route('collections.report', request()->except('search')) }}" class="ml-1 hover:opacity-70 flex-shrink-0" style="color: #AA7D31;">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
            @endif
            @if(request('status'))
                @php $statusName = collect($statusCounts)->firstWhere('id', request('status'))['name'] ?? request('status'); @endphp
                <span class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium rounded-full border whitespace-nowrap"
                    style="background-color: rgba(170, 125, 49, 0.08); color: #7a5c24; border-color: rgba(170, 125, 49, 0.15);">
                    <i class="fas fa-tag text-xs"></i>
                    <span>Status: {{ ucfirst($statusName) }}</span>
                    <a href="{{ route('collections.report', request()->except('status')) }}" class="ml-1 hover:opacity-70 flex-shrink-0" style="color: #AA7D31;">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
            @endif
            @if(request('from_date') || request('to_date'))
                <span class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium rounded-full border whitespace-nowrap"
                    style="background-color: rgba(170, 125, 49, 0.08); color: #7a5c24; border-color: rgba(170, 125, 49, 0.15);">
                    <i class="fas fa-calendar text-xs"></i>
                    <span>Date: {{ request('from_date', 'Start') }} - {{ request('to_date', 'End') }}</span>
                    <a href="{{ route('collections.report', request()->except(['from_date', 'to_date'])) }}" class="ml-1 hover:opacity-70 flex-shrink-0" style="color: #AA7D31;">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
            @endif
        </div>
    @endif
</div>

            {{-- Chart & Collection Mode Split Row --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6">
                {{-- Monthly Chart --}}
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-1">Monthly Collection vs Demand</h4>
                            <p class="text-gray-500 text-sm">Track how much was demanded vs collected</p>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded" style="background-color: #AA7D31;"></span>
                                <span class="text-sm">Collected</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded bg-gray-400"></span>
                                <span class="text-sm">Demand</span>
                            </div>
                        </div>
                    </div>
                    <div style="height: 260px;">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>

                {{-- Collection Mode Split --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <div class="mb-4">
                        <h4 class="font-semibold text-gray-800 mb-1">Collection Mode</h4>
                        <p class="text-gray-500 text-sm">Distribution by payment method</p>
                    </div>
                    
                    @php
                        $modes = [
                            'Bank Transfer' => 'Transfer',
                            'Loan Disbursement' => 'Loan',
                            'Cash / Other' => 'Other'
                        ];
                        $totalMode = $modeGrandTotal;
                    @endphp

                    <div class="space-y-4">
                        @foreach($modes as $label => $key)
                            @php
                                $value = $modeTotals[$key] ?? 0;
                                $percent = $modePercentages[$key] ?? 0;
                            @endphp
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-medium text-gray-700">{{ $label }}</span>
                                    <span>
                                        <span class="font-bold" style="color: #AA7D31;">
                                            ₹ {{ amountToPoints($value) }}
                                        </span>
                                        <span class="text-gray-500 ml-1">({{ $percent }}%)</span>
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="h-2 rounded-full transition-all duration-500"
                                        style="width: {{ $percent }}%; background-color: #AA7D31;">
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{-- Total --}}
                        <div class="pt-3 border-t border-gray-200">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-800">Total Collection</span>
                                <span class="font-bold text-lg" style="color: #AA7D31;">
                                    ₹ {{ amountToPoints($totalMode) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Project Wise & Status Wise --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-6">
                
                {{-- Project Wise Collection --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-1">Project Wise Collection</h4>
                            <p class="text-gray-500 text-sm">Top performing projects</p>
                        </div>
                        <a href="#" class="text-sm font-medium hover:underline" style="color: #AA7D31;">
                            View All <i class="fas fa-arrow-right ml-1 text-xs"></i>
                        </a>
                    </div>
                    
                    @php
                        $projects = \App\Models\Project::with(['bookings.collection'])
                            ->get()
                            ->map(function ($project) {
                                $totalDemand = $project->bookings->sum('total_amount');
                                $collected = $project->bookings->flatMap->collection->sum('amount');
                                $efficiency = $totalDemand > 0 ? round(($collected / $totalDemand) * 100) : 0;
                                return [
                                    'name' => $project->name,
                                    'bookings' => $project->bookings->count(),
                                    'collected' => $collected,
                                    'efficiency' => $efficiency,
                                ];
                            })->sortByDesc('collected')->take(4);
                    @endphp
                    <div class="space-y-4">
                        @foreach($projects as $project)
                        @php
    $width = min($project['efficiency'], 100);
@endphp
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <div>
                                        <span class="font-medium text-gray-800">{{ $project['name'] }}</span>
                                        <span class="text-gray-500 text-sm ml-2">({{ $project['bookings'] }} bookings)</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="font-bold text-gray-800">₹ {{ amountToPoints($project['collected'] / 100000, 1) }}L</span>
                                        <span class="ml-2 px-2 py-1 text-xs font-medium rounded"
                                            style="background-color: rgba(170, 125, 49, 0.1); color: #AA7D31;">{{ $project['efficiency'] }}%</span>
                                    </div>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                    <div class="h-2 rounded-full transition-all duration-500"
                                        style="width: {{ $width }}%; background-color: #AA7D31;"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Status Wise Recovery --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                    <h4 class="font-semibold text-gray-800 mb-3">Status Wise Recovery</h4>
                    <p class="text-gray-500 text-sm mb-4">Collection distribution by payment status</p>
                    <div class="grid grid-cols-2 gap-3">
                        @php
                            $statusAmounts = [
                                'completed' => ['amount' => $totalCollection - ($overdueAmount + $totalCollection * 0.1), 'count' => 142, 'color' => 'success', 'icon' => 'check-circle', 'textColor' => 'text-green-600', 'bgColor' => 'bg-green-50'],
                                'partial' => ['amount' => $totalCollection * 0.1, 'count' => 24, 'color' => 'warning', 'icon' => 'clock', 'textColor' => 'text-yellow-600', 'bgColor' => 'bg-yellow-50'],
                                'upcoming' => ['amount' => $totalDemand * 0.05, 'count' => 18, 'color' => 'info', 'icon' => 'calendar', 'textColor' => 'text-blue-600', 'bgColor' => 'bg-blue-50'],
                            ];
                        @endphp
                        @foreach($statusAmounts as $status => $data)
                            <div class="border rounded-lg p-3" style="border-color: rgba(170, 125, 49, 0.15);">
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="fas fa-{{ $data['icon'] }} {{ $data['textColor'] }}"></i>
                                    <span class="text-gray-500 text-xs uppercase tracking-wider">{{ ucfirst($status) }}</span>
                                </div>
                                <h5 class="text-lg font-bold text-gray-800 mb-1">₹ {{ amountToPoints($data['amount']) }}</h5>
                                <span class="text-gray-500 text-sm">{{ $data['count'] }} receipts</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Detailed Collection Table --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-5 border-b border-gray-200">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-1">Detailed Collection Report</h4>
                            <p class="text-gray-500 text-sm">Comprehensive view of all collection transactions</p>
                        </div>
                      
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Receipt No</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Customer / Project</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Booking ID</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Demand</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Collected</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Balance</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Due Date</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($collections as $index => $item)
                                @php
                                    $booking = $item->booking;
                                    $demand = $booking->total_amount ?? 0;
                                    $balance = $demand - $item->amount;
                                    $statusClass = match ($item->status) {
                                        'completed' => 'bg-green-100 text-green-800',
                                        'partial' => 'bg-yellow-100 text-yellow-800',
                                        'overdue' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    };
                                @endphp
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-4 py-3">
                                        <span class="font-medium text-gray-800">RCPT-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-medium text-gray-800">{{ $item->customer->name ?? '-' }}</div>
                                        <small class="text-gray-500">{{ $booking->project->name ?? '-' }}</small>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded">{{ $booking->booking_id ?? '-' }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-700">₹ {{ amountToPoints($demand) }}</td>
                                    <td class="px-4 py-3 font-medium" style="color: #AA7D31;">₹ {{ amountToPoints($item->amount) }}</td>
                                    <td class="px-4 py-3 text-gray-700">₹ {{ amountToPoints(max(0, $balance)) }}</td>
                                    <td class="px-4 py-3 text-gray-600 text-sm">{{ $item->date ? $item->date->format('d M Y') : '-' }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full {{ $statusClass }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <button class="p-1.5 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded transition-colors duration-200" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="p-1.5 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded transition-colors duration-200" title="Download Receipt">
                                            <i class="fas fa-download"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-4 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fas fa-inbox text-5xl text-gray-300 mb-4"></i>
                                            <h5 class="text-lg font-medium text-gray-600 mb-1">No Collections Found</h5>
                                            <p class="text-gray-500 text-sm">Try adjusting your filters</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Table Footer with Pagination --}}
                <div class="px-5 py-4 border-t border-gray-200 bg-gray-50">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="text-sm text-gray-600">
                            Showing <span class="font-medium">{{ $collections->firstItem() ?? 0 }}</span> to
                            <span class="font-medium">{{ $collections->lastItem() ?? 0 }}</span> of
                            <span class="font-medium">{{ $total }}</span> records
                        </div>
                        @if($collections->hasPages())
                            <div>
                                {{ $collections->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart.js Script --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('monthlyChart').getContext('2d');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($monthNames) !!},
                    datasets: [
                        {
                            label: 'Collected',
                            data: {!! json_encode(array_values($monthly->toArray())) !!},
                            backgroundColor: '#AA7D31',
                            borderRadius: 8,
                            barPercentage: 0.65,
                            categoryPercentage: 0.85,
                        },
                        {
                            label: 'Demand',
                            data: {!! json_encode($demandMonthly ?? array_fill(0, count($monthNames), 0)) !!},
                            backgroundColor: '#CBD5E1',
                            borderRadius: 8,
                            barPercentage: 0.65,
                            categoryPercentage: 0.85,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1F2937',
                            titleColor: '#F9FAFB',
                            bodyColor: '#F3F4F6',
                            padding: 12,
                            cornerRadius: 8,
                            callbacks: {
                                label: function (context) {
                                    return context.dataset.label + ': ₹ ' + context.parsed.y.toLocaleString('en-IN');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#F1F5F9',
                                lineWidth: 1,
                            },
                            ticks: {
                                callback: function (value) {
                                    if (value >= 10000000) return '₹ ' + (value / 10000000).toFixed(1) + 'Cr';
                                    if (value >= 100000) return '₹ ' + (value / 100000).toFixed(1) + 'L';
                                    return '₹ ' + value.toLocaleString('en-IN');
                                },
                                font: { size: 11 }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 11 } }
                        }
                    }
                }
            });
        });
    </script>

    {{-- Custom Tailwind Extensions --}}
    <style>
        input:focus,
        select:focus {
            --tw-ring-color: rgba(170, 125, 49, 0.2) !important;
            --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
            --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);
            box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
            border-color: #AA7D31 !important;
        }

        .overflow-x-auto::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #F1F5F9;
            border-radius: 3px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #AA7D31;
            border-radius: 3px;
            opacity: 0.7;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #8B6B2E;
        }

        .pagination {
            display: flex;
            gap: 0.25rem;
        }

        .pagination .page-item {
            list-style: none;
        }

        .pagination .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 2rem;
            height: 2rem;
            padding: 0 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            color: #64748B;
            background: white;
            border: 1px solid #E5E7EB;
            transition: all 0.15s ease;
            text-decoration: none;
        }

        .pagination .page-link:hover {
            background: rgba(170, 125, 49, 0.1);
            color: #AA7D31;
            border-color: #AA7D31;
        }

        .pagination .active .page-link {
            background: #AA7D31;
            color: white;
            border-color: #AA7D31;
        }

        .pagination .disabled .page-link {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
@endsection