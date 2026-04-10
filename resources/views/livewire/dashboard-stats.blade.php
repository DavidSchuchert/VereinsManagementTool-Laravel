<div wire:poll.30s x-data="{ activeTab: 'overview' }">
    {{-- Tab Navigation --}}
    <div class="mb-6 border-b border-gray-200">
        <nav class="flex -mb-px space-x-8" aria-label="Tabs">
            <button @click="activeTab = 'overview'" 
                    :class="{ 'border-blue-500 text-blue-600': activeTab === 'overview', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'overview' }"
                    class="px-1 py-4 text-sm font-medium border-b-2 whitespace-nowrap">
                Übersicht
            </button>
            <button @click="activeTab = 'members'" 
                    :class="{ 'border-blue-500 text-blue-600': activeTab === 'members', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'members' }"
                    class="px-1 py-4 text-sm font-medium border-b-2 whitespace-nowrap">
                Mitglieder & Ränge
            </button>
            <button @click="activeTab = 'financials'" 
                    :class="{ 'border-blue-500 text-blue-600': activeTab === 'financials', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'financials' }"
                    class="px-1 py-4 text-sm font-medium border-b-2 whitespace-nowrap">
                Finanzen
            </button>
        </nav>
    </div>

    {{-- Overview Tab --}}
    <div x-show="activeTab === 'overview'" class="space-y-6">
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            {{-- Total Members Card --}}
            <div class="overflow-hidden bg-white rounded-lg shadow">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Gesamtmitglieder</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">{{ $totalMembers }}</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Active Members Card --}}
            <div class="overflow-hidden bg-white rounded-lg shadow">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Aktive Mitglieder</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">{{ $activeMembers }}</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Income Card --}}
            <div class="overflow-hidden bg-white rounded-lg shadow">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Einnahmen</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">{{ number_format($totalIncome, 2, ',', '.') }} €</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Expense Card --}}
            <div class="overflow-hidden bg-white rounded-lg shadow">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Ausgaben</dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">{{ number_format($totalExpense, 2, ',', '.') }} €</div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            {{-- Latest Protocols --}}
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4 border-b pb-2">Neueste Protokolle</h3>
                <ul class="divide-y divide-gray-200">
                    @foreach($latestProtocols as $protocol)
                        <li class="py-3">
                            <div class="flex items-center space-x-4">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $protocol->titel }}</p>
                                    <p class="text-sm text-gray-500">{{ $protocol->created_at->format('d.m.Y') }}</p>
                                </div>
                                <div>
                                    <a href="{{ route('protokolle.index') }}" class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50">Ansehen</a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Latest Inventory --}}
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4 border-b pb-2">Neuestes Inventar</h3>
                <ul class="divide-y divide-gray-200">
                    @foreach($latestInventory as $item)
                        <li class="py-3">
                            <div class="flex items-center space-x-4">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $item->artikel }}</p>
                                    <p class="text-sm text-gray-500">Menge: {{ $item->menge }} | {{ $item->category->name ?? 'Keine Kategorie' }}</p>
                                </div>
                                <div>
                                    <a href="{{ route('inventar.index') }}" class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50">Details</a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    {{-- Members Tab with Chart --}}
    <div x-show="activeTab === 'members'" class="space-y-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-6">Mitgliederverteilung nach Rang</h3>
            <div x-data="{
                init() {
                    const options = {
                        series: [{
                            name: 'Mitglieder',
                            data: @js($memberRankData)
                        }],
                        chart: {
                            type: 'bar',
                            height: 350,
                            toolbar: { show: false }
                        },
                        plotOptions: {
                            bar: {
                                borderRadius: 4,
                                horizontal: true,
                            }
                        },
                        dataLabels: { enabled: false },
                        xaxis: {
                            categories: @js($memberRankLabels),
                        },
                        colors: ['#3B82F6']
                    };
                    const chart = new ApexCharts(this.$refs.memberChart, options);
                    chart.render();
                    
                    document.addEventListener('livewire:initialized', () => {
                        @this.on('refresh-charts', () => {
                            chart.updateOptions({
                                series: [{ data: @js($memberRankData) }],
                                xaxis: { categories: @js($memberRankLabels) }
                            });
                        });
                    });
                }
            }" class="w-full">
                <div x-ref="memberChart"></div>
            </div>
        </div>
    </div>

    {{-- Financials Tab with Chart --}}
    <div x-show="activeTab === 'financials'" class="space-y-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-6">Einnahmen vs. Ausgaben</h3>
            <div x-data="{
                init() {
                    const options = {
                        series: [@js($totalIncome), @js($totalExpense)],
                        chart: {
                            type: 'donut',
                            height: 350
                        },
                        labels: ['Einnahmen', 'Ausgaben'],
                        colors: ['#10B981', '#EF4444'],
                        legend: { position: 'bottom' }
                    };
                    const chart = new ApexCharts(this.$refs.financialChart, options);
                    chart.render();
                }
            }" class="w-full">
                <div x-ref="financialChart"></div>
            </div>
        </div>
    </div>
</div>
