<div wire:poll.30s x-data="{ activeTab: 'overview' }" class="animate-fade-in">
    {{-- Tab Navigation --}}
    <div class="mb-8">
        <div class="sm:hidden">
            <select x-model="activeTab" class="block w-full input-premium">
                <option value="overview">Übersicht</option>
                <option value="members">Mitglieder & Ränge</option>
                <option value="financials">Finanzen</option>
            </select>
        </div>
        <div class="hidden sm:block">
            <nav class="flex space-x-2" aria-label="Tabs">
                <button @click="activeTab = 'overview'" 
                        :class="activeTab === 'overview' ? 'bg-white text-gray-900 shadow-sm border-gray-200' : 'text-gray-500 hover:text-gray-700 hover:bg-white/60 border-transparent'"
                        class="px-5 py-2.5 text-sm font-medium rounded-xl border transition-all duration-300">
                    Übersicht
                </button>
                <button @click="activeTab = 'members'" 
                        :class="activeTab === 'members' ? 'bg-white text-gray-900 shadow-sm border-gray-200' : 'text-gray-500 hover:text-gray-700 hover:bg-white/60 border-transparent'"
                        class="px-5 py-2.5 text-sm font-medium rounded-xl border transition-all duration-300">
                    Mitglieder & Ränge
                </button>
                <button @click="activeTab = 'financials'" 
                        :class="activeTab === 'financials' ? 'bg-white text-gray-900 shadow-sm border-gray-200' : 'text-gray-500 hover:text-gray-700 hover:bg-white/60 border-transparent'"
                        class="px-5 py-2.5 text-sm font-medium rounded-xl border transition-all duration-300">
                    Finanzen
                </button>
            </nav>
        </div>
    </div>

    {{-- Overview Tab --}}
    <div x-show="activeTab === 'overview'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-8">
        
        {{-- KPI Cards --}}
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            {{-- Total Members Card --}}
            <div class="card-premium p-6 relative overflow-hidden group">
                <div class="absolute top-0 right-0 -mr-6 -mt-6 w-24 h-24 rounded-full bg-blue-50 opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="flex items-center gap-5 relative z-10">
                    <div class="flex-shrink-0 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl p-4 shadow-lg shadow-blue-500/30">
                        <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Gesamtmitglieder</p>
                        <p class="text-3xl font-heading font-bold text-gray-900">{{ $totalMembers }}</p>
                    </div>
                </div>
            </div>

            {{-- Active Members Card --}}
            <div class="card-premium p-6 relative overflow-hidden group">
                <div class="absolute top-0 right-0 -mr-6 -mt-6 w-24 h-24 rounded-full bg-emerald-50 opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="flex items-center gap-5 relative z-10">
                    <div class="flex-shrink-0 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-2xl p-4 shadow-lg shadow-emerald-500/30">
                        <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Aktive Mitglieder</p>
                        <p class="text-3xl font-heading font-bold text-gray-900">{{ $activeMembers }}</p>
                    </div>
                </div>
            </div>

            {{-- Total Income Card --}}
            <div class="card-premium p-6 relative overflow-hidden group">
                <div class="absolute top-0 right-0 -mr-6 -mt-6 w-24 h-24 rounded-full bg-indigo-50 opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="flex items-center gap-5 relative z-10">
                    <div class="flex-shrink-0 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl p-4 shadow-lg shadow-indigo-500/30">
                        <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Einnahmen</p>
                        <p class="text-3xl font-heading font-bold text-gray-900">{{ number_format($totalIncome, 2, ',', '.') }} €</p>
                    </div>
                </div>
            </div>

            {{-- Total Expense Card --}}
            <div class="card-premium p-6 relative overflow-hidden group">
                <div class="absolute top-0 right-0 -mr-6 -mt-6 w-24 h-24 rounded-full bg-rose-50 opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="flex items-center gap-5 relative z-10">
                    <div class="flex-shrink-0 bg-gradient-to-br from-rose-400 to-rose-600 rounded-2xl p-4 shadow-lg shadow-rose-500/30">
                        <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Ausgaben</p>
                        <p class="text-3xl font-heading font-bold text-gray-900">{{ number_format($totalExpense, 2, ',', '.') }} €</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Lists Section --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            {{-- Latest Protocols --}}
            <div class="card-premium flex flex-col">
                <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 rounded-t-2xl">
                    <h3 class="text-lg font-heading font-semibold text-gray-900">Neueste Protokolle</h3>
                    <a href="{{ route('protokolle.index') }}" class="text-sm font-medium text-accent-600 hover:text-accent-800">Alle anzeigen &rarr;</a>
                </div>
                <div class="p-2">
                    <ul class="divide-y divide-gray-100/60">
                        @forelse($latestProtocols as $protocol)
                            <li class="py-3 px-4 hover:bg-gray-50/80 rounded-xl transition-colors">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div class="p-2 bg-indigo-50 rounded-lg text-indigo-500">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $protocol->title }}</p>
                                            <p class="text-xs text-gray-500 mt-0.5">{{ $protocol->created_at->format('d.m.Y H:i') }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('protokolle.index') }}" class="btn-secondary py-1.5 px-3 text-xs">Ansehen</a>
                                </div>
                            </li>
                        @empty
                            <li class="py-6 text-center text-gray-500 text-sm">Keine Protokolle vorhanden.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            {{-- Latest Inventory --}}
            <div class="card-premium flex flex-col">
                <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50 rounded-t-2xl">
                    <h3 class="text-lg font-heading font-semibold text-gray-900">Neuestes Inventar</h3>
                    <a href="{{ route('inventar.index') }}" class="text-sm font-medium text-accent-600 hover:text-accent-800">Alle anzeigen &rarr;</a>
                </div>
                <div class="p-2">
                    <ul class="divide-y divide-gray-100/60">
                        @forelse($latestInventory as $item)
                            <li class="py-3 px-4 hover:bg-gray-50/80 rounded-xl transition-colors">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div class="p-2 bg-emerald-50 rounded-lg text-emerald-500">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $item->artikel }}</p>
                                            <div class="flex items-center gap-2 mt-0.5">
                                                <span class="text-xs font-medium text-gray-500">{{ $item->menge }} Stk.</span>
                                                <span class="text-gray-300">&bull;</span>
                                                <span class="badge-accent !py-0 !px-1.5 text-[10px]">{{ $item->category->name ?? 'Keine Kategorie' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('inventar.index') }}" class="btn-secondary py-1.5 px-3 text-xs">Details</a>
                                </div>
                            </li>
                        @empty
                            <li class="py-6 text-center text-gray-500 text-sm">Kein Inventar vorhanden.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Members Tab with Chart --}}
    <div x-show="activeTab === 'members'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
        <div class="card-premium p-8 max-w-3xl mx-auto">
            <h3 class="text-xl font-heading font-semibold text-gray-900 mb-6 text-center">Mitgliederverteilung nach Rang</h3>
            <div x-data="{
                init() {
                    const options = {
                        series: @js($memberRankData),
                        chart: {
                            type: 'donut',
                            height: 400,
                            fontFamily: 'Inter, sans-serif'
                        },
                        labels: @js($memberRankLabels),
                        stroke: { width: 0 },
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: '70%',
                                    labels: {
                                        show: true,
                                        name: { fontSize: '14px', color: '#6b7280' },
                                        value: {
                                            fontSize: '28px',
                                            fontWeight: 700,
                                            color: '#111827',
                                            formatter: function (val) { return val + ' Mitglieder' }
                                        },
                                        total: {
                                            show: true,
                                            label: 'Gesamt',
                                            formatter: function (w) {
                                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0) + ' Mitglieder';
                                            }
                                        }
                                    }
                                }
                            }
                        },
                        legend: { position: 'bottom', offsetY: 10 }
                    };
                    const chart = new ApexCharts(this.$refs.memberChart, options);
                    chart.render();
                    
                    document.addEventListener('livewire:initialized', () => {
                        @this.on('refresh-charts', () => {
                            chart.updateOptions({
                                series: @js($memberRankData),
                                labels: @js($memberRankLabels)
                            });
                        });
                    });
                }
            }" class="w-full">
                <div x-ref="memberChart" class="-ml-4"></div>
            </div>
        </div>
    </div>

    {{-- Financials Tab with Chart --}}
    <div x-show="activeTab === 'financials'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
        <div class="card-premium p-8 max-w-3xl mx-auto">
            <div class="text-center mb-8">
                <h3 class="text-xl font-heading font-semibold text-gray-900">Einnahmen vs. Ausgaben</h3>
                <p class="text-sm text-gray-500 mt-1">Gesamter Zeitraum (Alle Jahre)</p>
            </div>
            <div x-data="{
                init() {
                    const options = {
                        series: [@js((float)$totalIncome), @js((float)$totalExpense)],
                        chart: {
                            type: 'donut',
                            height: 420,
                            fontFamily: 'Inter, sans-serif'
                        },
                        labels: ['Einnahmen', 'Ausgaben'],
                        colors: ['#10B981', '#F43F5E'],
                        stroke: { width: 0 },
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: '70%',
                                    labels: {
                                        show: true,
                                        name: { fontSize: '14px', color: '#6b7280' },
                                        value: {
                                            fontSize: '28px',
                                            fontWeight: 700,
                                            color: '#111827',
                                            formatter: function (val) { return val + ' €' }
                                        },
                                        total: {
                                            show: true,
                                            label: 'Saldo',
                                            formatter: function (w) {
                                                const total = w.globals.seriesTotals[0] - w.globals.seriesTotals[1];
                                                return total.toFixed(2) + ' €';
                                            }
                                        }
                                    }
                                }
                            }
                        },
                        legend: { position: 'bottom', offsetY: 0, padding: { top: 20 } }
                    };
                    const chart = new ApexCharts(this.$refs.financialChart, options);
                    chart.render();
                }
            }" class="w-full flex justify-center pb-4">
                <div x-ref="financialChart"></div>
            </div>
        </div>
    </div>
</div>
