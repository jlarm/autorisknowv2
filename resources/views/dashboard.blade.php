<x-layouts.app :title="__('Dashboard')">
    <div
        x-data="{
            stats: {
                pageviews: 0,
                visits: 0,
                uniques: 0,
                avg_duration: 0,
                bounce_rate: 0,
                current_visitors: 0,
                chart_data: [],
                top_pages: [],
                top_referrers: [],
                device_types: [],
                browsers: [],
                countries: [],
                events: [],
            },
            loading: true,
            error: false,
            async fetchStats() {
                try {
                    const response = await fetch('{{ route('analytics.stats') }}');
                    if (!response.ok) throw new Error('Failed to fetch stats');
                    this.stats = await response.json();
                    this.loading = false;
                    this.$nextTick(() => this.renderChart());
                } catch (error) {
                    console.error('Failed to fetch analytics:', error);
                    this.error = true;
                    this.loading = false;
                }
            },
            renderChart() {
                if (!this.stats.chart_data || this.stats.chart_data.length === 0) return;
                if (!this.$refs.chart) return;

                const ctx = this.$refs.chart.getContext('2d');

                // Create gradient
                const gradientPageviews = ctx.createLinearGradient(0, 0, 0, 300);
                gradientPageviews.addColorStop(0, 'rgba(99, 102, 241, 0.3)');
                gradientPageviews.addColorStop(1, 'rgba(99, 102, 241, 0.0)');

                const gradientVisits = ctx.createLinearGradient(0, 0, 0, 300);
                gradientVisits.addColorStop(0, 'rgba(168, 85, 247, 0.3)');
                gradientVisits.addColorStop(1, 'rgba(168, 85, 247, 0.0)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: this.stats.chart_data.map(d => new Date(d.date).toLocaleDateString('en-US', { month: 'short', day: 'numeric' })),
                        datasets: [
                            {
                                label: 'Pageviews',
                                data: this.stats.chart_data.map(d => d.pageviews),
                                borderColor: 'rgb(99, 102, 241)',
                                backgroundColor: gradientPageviews,
                                fill: true,
                                tension: 0.4,
                                borderWidth: 2,
                            },
                            {
                                label: 'Visits',
                                data: this.stats.chart_data.map(d => d.visits),
                                borderColor: 'rgb(168, 85, 247)',
                                backgroundColor: gradientVisits,
                                fill: true,
                                tension: 0.4,
                                borderWidth: 2,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'index',
                        },
                        plugins: {
                            legend: {
                                display: false,
                            },
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.05)',
                                },
                                ticks: {
                                    color: 'rgb(161, 161, 170)',
                                }
                            },
                            x: {
                                grid: {
                                    display: false,
                                },
                                ticks: {
                                    color: 'rgb(161, 161, 170)',
                                }
                            }
                        }
                    }
                });
            },
            formatDuration(seconds) {
                const minutes = Math.floor(seconds / 60);
                const secs = seconds % 60;
                return `${String(minutes).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
            },
            formatNumber(num) {
                if (num >= 1000) {
                    return (num / 1000).toFixed(1) + 'k';
                }
                return num.toString();
            }
        }"
        x-init="fetchStats()"
        class="flex h-full w-full flex-1 flex-col gap-6"
    >
        {{-- Stats Overview --}}
        <flux:card class="!bg-zinc-900 !border-zinc-800">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                {{-- Realtime --}}
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <div x-show="!loading" class="text-3xl font-semibold text-white" x-text="stats.current_visitors"></div>
                        <div x-show="loading" class="animate-pulse bg-zinc-700 h-8 w-12 rounded"></div>
                        <span x-show="!loading && stats.current_visitors > 0" class="flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                    </div>
                    <div class="text-xs text-zinc-400">Realtime</div>
                </div>

                {{-- People (Unique Visitors) --}}
                <div>
                    <div x-show="!loading" class="text-3xl font-semibold text-white mb-1" x-text="formatNumber(stats.uniques)"></div>
                    <div x-show="loading" class="animate-pulse bg-zinc-700 h-8 w-16 rounded mb-1"></div>
                    <div class="text-xs text-zinc-400">People</div>
                </div>

                {{-- Views --}}
                <div>
                    <div x-show="!loading" class="text-3xl font-semibold text-white mb-1" x-text="formatNumber(stats.pageviews)"></div>
                    <div x-show="loading" class="animate-pulse bg-zinc-700 h-8 w-16 rounded mb-1"></div>
                    <div class="text-xs text-zinc-400">Views</div>
                </div>

                {{-- Avg time on site --}}
                <div>
                    <div x-show="!loading" class="text-3xl font-semibold text-white mb-1" x-text="formatDuration(stats.avg_duration)"></div>
                    <div x-show="loading" class="animate-pulse bg-zinc-700 h-8 w-16 rounded mb-1"></div>
                    <div class="text-xs text-zinc-400">Avg time on site</div>
                </div>

                {{-- Bounce rate --}}
                <div>
                    <div x-show="!loading" class="text-3xl font-semibold text-white mb-1" x-text="Math.round(stats.bounce_rate) + '%'"></div>
                    <div x-show="loading" class="animate-pulse bg-zinc-700 h-8 w-16 rounded mb-1"></div>
                    <div class="text-xs text-zinc-400">Bounce rate</div>
                </div>

                {{-- Visits --}}
                <div>
                    <div x-show="!loading" class="text-3xl font-semibold text-white mb-1" x-text="formatNumber(stats.visits)"></div>
                    <div x-show="loading" class="animate-pulse bg-zinc-700 h-8 w-16 rounded mb-1"></div>
                    <div class="text-xs text-zinc-400">Visits</div>
                </div>
            </div>
        </flux:card>

        {{-- Chart --}}
        <flux:card class="!bg-white dark:!bg-zinc-900 !border-zinc-200 dark:!border-zinc-800">
            <div x-show="!loading && stats.chart_data.length > 0" class="h-80">
                <canvas x-ref="chart" class="w-full h-full"></canvas>
            </div>

            <div x-show="loading" class="h-80 flex items-center justify-center">
                <div class="text-zinc-400">Loading chart data...</div>
            </div>

            <div x-show="!loading && stats.chart_data.length === 0" class="h-80 flex items-center justify-center">
                <div class="text-zinc-400">No chart data available</div>
            </div>
        </flux:card>

        {{-- Events Table --}}
        <flux:card>
            <flux:heading size="lg" class="mb-4">Events</flux:heading>

            <flux:table>
                <flux:table.columns>
                    <flux:table.column>Event</flux:table.column>
                    <flux:table.column class="text-right">Uniques</flux:table.column>
                    <flux:table.column class="text-right">Completions</flux:table.column>
                    <flux:table.column class="text-right">Conv. Rate</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    <template x-if="loading">
                        <flux:table.row>
                            <flux:table.cell colspan="4">
                                <div class="animate-pulse flex space-x-4">
                                    <div class="flex-1 space-y-3 py-1">
                                        <div class="h-4 bg-zinc-200 dark:bg-zinc-700 rounded"></div>
                                        <div class="h-4 bg-zinc-200 dark:bg-zinc-700 rounded"></div>
                                        <div class="h-4 bg-zinc-200 dark:bg-zinc-700 rounded"></div>
                                    </div>
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                    </template>

                    <template x-for="event in stats.events" :key="event.event_name">
                        <flux:table.row>
                            <flux:table.cell>
                                <span class="font-medium" x-text="event.event_name"></span>
                            </flux:table.cell>
                            <flux:table.cell class="text-right font-mono text-sm" x-text="formatNumber(event.uniques)"></flux:table.cell>
                            <flux:table.cell class="text-right font-mono text-sm" x-text="formatNumber(event.completions)"></flux:table.cell>
                            <flux:table.cell class="text-right font-mono text-sm" x-text="event.conversion_rate + '%'"></flux:table.cell>
                        </flux:table.row>
                    </template>

                    <template x-if="!loading && stats.events.length === 0">
                        <flux:table.row>
                            <flux:table.cell colspan="4" class="text-center text-zinc-400">
                                No event data available
                            </flux:table.cell>
                        </flux:table.row>
                    </template>
                </flux:table.rows>
            </flux:table>
        </flux:card>

        {{-- Tables --}}
        <div class="grid lg:grid-cols-6 gap-6">
            {{-- Top Pages --}}
            <flux:card class="col-span-4">
                <flux:heading size="lg" class="mb-4">Pages</flux:heading>

                <flux:table>
                    <flux:table.columns>
                        <flux:table.column>Page</flux:table.column>
                        <flux:table.column class="text-right">Entries</flux:table.column>
                        <flux:table.column class="text-right">Visitors</flux:table.column>
                        <flux:table.column class="text-right">Views</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        <template x-if="loading">
                            <flux:table.row>
                                <flux:table.cell colspan="4">
                                    <div class="animate-pulse flex space-x-4">
                                        <div class="flex-1 space-y-3 py-1">
                                            <div class="h-4 bg-zinc-200 dark:bg-zinc-700 rounded"></div>
                                            <div class="h-4 bg-zinc-200 dark:bg-zinc-700 rounded"></div>
                                            <div class="h-4 bg-zinc-200 dark:bg-zinc-700 rounded"></div>
                                        </div>
                                    </div>
                                </flux:table.cell>
                            </flux:table.row>
                        </template>

                        <template x-for="page in stats.top_pages" :key="page.pathname">
                            <flux:table.row>
                                <flux:table.cell>
                                    <span class="font-mono text-sm truncate block max-w-md" x-text="page.pathname || '/'" :title="page.pathname || '/'"></span>
                                </flux:table.cell>
                                <flux:table.cell class="text-right font-mono text-sm" x-text="formatNumber(page.uniques)"></flux:table.cell>
                                <flux:table.cell class="text-right font-mono text-sm" x-text="formatNumber(page.visits)"></flux:table.cell>
                                <flux:table.cell class="text-right font-mono text-sm" x-text="formatNumber(page.pageviews)"></flux:table.cell>
                            </flux:table.row>
                        </template>

                        <template x-if="!loading && stats.top_pages.length === 0">
                            <flux:table.row>
                                <flux:table.cell colspan="4" class="text-center text-zinc-400">
                                    No page data available
                                </flux:table.cell>
                            </flux:table.row>
                        </template>
                    </flux:table.rows>
                </flux:table>
            </flux:card>

            {{-- Top Referrers --}}
            <flux:card class="col-span-2">
                <flux:heading size="lg" class="mb-4">Referrers</flux:heading>

                <flux:table>
                    <flux:table.columns>
                        <flux:table.column>Source</flux:table.column>
                        <flux:table.column class="text-right">Visitors</flux:table.column>
                        <flux:table.column class="text-right">Views</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        <template x-if="loading">
                            <flux:table.row>
                                <flux:table.cell colspan="3">
                                    <div class="animate-pulse flex space-x-4">
                                        <div class="flex-1 space-y-3 py-1">
                                            <div class="h-4 bg-zinc-200 dark:bg-zinc-700 rounded"></div>
                                            <div class="h-4 bg-zinc-200 dark:bg-zinc-700 rounded"></div>
                                            <div class="h-4 bg-zinc-200 dark:bg-zinc-700 rounded"></div>
                                        </div>
                                    </div>
                                </flux:table.cell>
                            </flux:table.row>
                        </template>

                        <template x-for="referrer in stats.top_referrers" :key="referrer.referrer_hostname">
                            <flux:table.row>
                                <flux:table.cell>
                                    <span class="font-medium" x-text="referrer.referrer_hostname || 'Direct / Unknown'"></span>
                                </flux:table.cell>
                                <flux:table.cell class="text-right font-mono text-sm" x-text="formatNumber(referrer.visits)"></flux:table.cell>
                                <flux:table.cell class="text-right font-mono text-sm" x-text="formatNumber(referrer.pageviews)"></flux:table.cell>
                            </flux:table.row>
                        </template>

                        <template x-if="!loading && stats.top_referrers.length === 0">
                            <flux:table.row>
                                <flux:table.cell colspan="3" class="text-center text-zinc-400">
                                    No referrer data available
                                </flux:table.cell>
                            </flux:table.row>
                        </template>
                    </flux:table.rows>
                </flux:table>
            </flux:card>
        </div>

        {{-- Device Types, Browsers, Countries --}}
        <div class="grid lg:grid-cols-3 gap-6">
            {{-- Device Types --}}
            <flux:card>
                <flux:heading size="lg" class="mb-4">Device Types</flux:heading>

                <flux:table>
                    <flux:table.columns>
                        <flux:table.column>Type</flux:table.column>
                        <flux:table.column class="text-right">Visitors</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        <template x-if="loading">
                            <flux:table.row>
                                <flux:table.cell colspan="2">
                                    <div class="animate-pulse flex space-x-4">
                                        <div class="flex-1 space-y-3 py-1">
                                            <div class="h-4 bg-zinc-200 dark:bg-zinc-700 rounded"></div>
                                            <div class="h-4 bg-zinc-200 dark:bg-zinc-700 rounded"></div>
                                        </div>
                                    </div>
                                </flux:table.cell>
                            </flux:table.row>
                        </template>

                        <template x-for="device in stats.device_types" :key="device.device_type">
                            <flux:table.row>
                                <flux:table.cell>
                                    <span class="font-medium capitalize" x-text="device.device_type || 'Unknown'"></span>
                                </flux:table.cell>
                                <flux:table.cell class="text-right font-mono text-sm" x-text="formatNumber(device.visits)"></flux:table.cell>
                            </flux:table.row>
                        </template>

                        <template x-if="!loading && stats.device_types.length === 0">
                            <flux:table.row>
                                <flux:table.cell colspan="2" class="text-center text-zinc-400">
                                    No device data available
                                </flux:table.cell>
                            </flux:table.row>
                        </template>
                    </flux:table.rows>
                </flux:table>
            </flux:card>

            {{-- Browsers --}}
            <flux:card>
                <flux:heading size="lg" class="mb-4">Browsers</flux:heading>

                <flux:table>
                    <flux:table.columns>
                        <flux:table.column>Browser</flux:table.column>
                        <flux:table.column class="text-right">Visitors</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        <template x-if="loading">
                            <flux:table.row>
                                <flux:table.cell colspan="2">
                                    <div class="animate-pulse flex space-x-4">
                                        <div class="flex-1 space-y-3 py-1">
                                            <div class="h-4 bg-zinc-200 dark:bg-zinc-700 rounded"></div>
                                            <div class="h-4 bg-zinc-200 dark:bg-zinc-700 rounded"></div>
                                        </div>
                                    </div>
                                </flux:table.cell>
                            </flux:table.row>
                        </template>

                        <template x-for="browser in stats.browsers" :key="browser.browser">
                            <flux:table.row>
                                <flux:table.cell>
                                    <span class="font-medium" x-text="browser.browser || 'Unknown'"></span>
                                </flux:table.cell>
                                <flux:table.cell class="text-right font-mono text-sm" x-text="formatNumber(browser.visits)"></flux:table.cell>
                            </flux:table.row>
                        </template>

                        <template x-if="!loading && stats.browsers.length === 0">
                            <flux:table.row>
                                <flux:table.cell colspan="2" class="text-center text-zinc-400">
                                    No browser data available
                                </flux:table.cell>
                            </flux:table.row>
                        </template>
                    </flux:table.rows>
                </flux:table>
            </flux:card>

            {{-- Countries --}}
            <flux:card>
                <flux:heading size="lg" class="mb-4">Countries</flux:heading>

                <flux:table>
                    <flux:table.columns>
                        <flux:table.column>Country</flux:table.column>
                        <flux:table.column class="text-right">Visitors</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        <template x-if="loading">
                            <flux:table.row>
                                <flux:table.cell colspan="2">
                                    <div class="animate-pulse flex space-x-4">
                                        <div class="flex-1 space-y-3 py-1">
                                            <div class="h-4 bg-zinc-200 dark:bg-zinc-700 rounded"></div>
                                            <div class="h-4 bg-zinc-200 dark:bg-zinc-700 rounded"></div>
                                        </div>
                                    </div>
                                </flux:table.cell>
                            </flux:table.row>
                        </template>

                        <template x-for="country in stats.countries" :key="country.country">
                            <flux:table.row>
                                <flux:table.cell>
                                    <span class="font-medium" x-text="country.country || 'Unknown'"></span>
                                </flux:table.cell>
                                <flux:table.cell class="text-right font-mono text-sm" x-text="formatNumber(country.visits)"></flux:table.cell>
                            </flux:table.row>
                        </template>

                        <template x-if="!loading && stats.countries.length === 0">
                            <flux:table.row>
                                <flux:table.cell colspan="2" class="text-center text-zinc-400">
                                    No country data available
                                </flux:table.cell>
                            </flux:table.row>
                        </template>
                    </flux:table.rows>
                </flux:table>
            </flux:card>
        </div>

        {{-- Error State --}}
        <flux:card x-show="error" class="!bg-red-50 dark:!bg-red-900/20 !border-red-200 dark:!border-red-800">
            <div class="text-center text-red-600 dark:text-red-400">
                <p class="font-semibold mb-1">Unable to load analytics data</p>
                <p class="text-sm">Please make sure your Fathom API token is configured in your .env file</p>
            </div>
        </flux:card>
    </div>
</x-layouts.app>
