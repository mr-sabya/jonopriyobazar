<div class="dashboard-v5">

    <!-- HEADER -->
    <div class="row align-items-center mb-4">
        <div class="col-md-7">
            <h1 class="h3 fw-bold text-dark mb-1">Executive Intelligence</h1>
            <p class="text-muted small mb-0">Complete ecosystem monitoring: Orders, Users, Finances, and Inventory.</p>
        </div>
        <div class="col-md-5 text-md-end mt-3 mt-md-0">
            <button wire:click="loadIntelligence" class="btn btn-white border shadow-sm rounded-pill px-4 me-2">
                <i class="zmdi zmdi-refresh-alt me-1"></i> Sync Intelligence
            </button>
        </div>
    </div>

    <!-- 1. ORIGINAL ORDER SEGMENTS (Today/Month/Total) -->
    <div class="row g-4 mb-4">
        @php
        $kpis = [
        ['title' => "Today's Pulse", 'data' => $today_order, 'color' => 'primary', 'icon' => 'zmdi-flash'],
        ['title' => "Monthly Activity", 'data' => $month_order, 'color' => 'success', 'icon' => 'zmdi-calendar-check'],
        ['title' => "Lifetime Volume", 'data' => $orders, 'color' => 'info', 'icon' => 'zmdi-globe']
        ];
        $orderTypes = ['product' => 'Product', 'custom' => 'Custom', 'medicine' => 'Medicine', 'electricity' => 'Electricity'];
        @endphp
        @foreach($kpis as $kpi)
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100 overflow-hidden border-start border-4 border-{{ $kpi['color'] }}">
                <div class="card-header bg-white border-0 pt-3 px-3 pb-0 d-flex justify-content-between">
                    <h6 class="fw-bold text-muted small uppercase mb-0">{{ $kpi['title'] }}</h6>
                    <i class="zmdi {{ $kpi['icon'] }} text-{{ $kpi['color'] }}"></i>
                </div>
                <div class="card-body px-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light small text-muted">
                            <tr>
                                <th class="ps-3">Type</th>
                                <th>Total</th>
                                <th>Del.</th>
                                <th class="pe-3">Can.</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orderTypes as $key => $label)
                            <tr>
                                <td class="ps-3 fw-medium small">{{ $label }}</td>
                                <td>{{ $kpi['data']->where('type', $key)->count() }}</td>
                                <td class="text-success fw-bold">{{ $kpi['data']->where('type', $key)->where('status', 3)->count() }}</td>
                                <td class="text-danger fw-bold pe-3">{{ $kpi['data']->where('type', $key)->where('status', 4)->count() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- 2. APEX ANALYTICS CHARTS -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Order Trends</h5>
                    <ul class="nav nav-pills nav-adobe-pills small" id="pills-tab">
                        <li class="nav-item"><button class="nav-link active rounded-pill px-3" data-bs-toggle="pill" data-bs-target="#d_tab">Daily</button></li>
                        <li class="nav-item"><button class="nav-link rounded-pill px-3" data-bs-toggle="pill" data-bs-target="#m_tab">Monthly</button></li>
                        <li class="nav-item"><button class="nav-link rounded-pill px-3" data-bs-toggle="pill" data-bs-target="#y_tab">Yearly</button></li>
                    </ul>
                </div>
                <div class="card-body pt-0">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="d_tab">
                            <div id="apex-daily"></div>
                        </div>
                        <div class="tab-pane fade" id="m_tab">
                            <div id="apex-monthly"></div>
                        </div>
                        <div class="tab-pane fade" id="y_tab">
                            <div id="apex-yearly"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0">Distribution Status</h5>
                </div>
                <div class="card-body">
                    <div id="apex-pie"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. SALES KPI STRIP (Restored) -->
    <div class="row g-4 mb-4 text-center">
        <div class="col-12">
            <div class="card border-0 shadow-sm py-4">
                <div class="row align-items-center">
                    <div class="col-md-3 border-end">
                        <h5>2,365</h5><small class="text-muted">Revenue</small>
                    </div>
                    <div class="col-md-3 border-end">
                        <h5>365</h5><small class="text-muted">Returns</small>
                    </div>
                    <div class="col-md-3 border-end">
                        <h5>65</h5><small class="text-muted">Queries</small>
                    </div>
                    <div class="col-md-3">
                        <h5>2,055</h5><small class="text-muted">Invoices</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. RECENT ORDERS & NEW PRODUCTS -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0">Recent Orders</h5>
                </div>
                <div class="card-body px-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light small text-muted">
                            <tr>
                                <th class="ps-4">User</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th class="pe-4">Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recent_orders as $ro)
                            <tr>
                                <td class="ps-4 fw-bold small text-dark">{{ $ro->user->name ?? 'Guest' }}</td>
                                <td><span class="badge text-bg-light border small px-3">{{ ucfirst($ro->type) }}</span></td>
                                <td><span class="badge {{ $ro->status == 3 ? 'text-bg-success' : 'text-bg-warning' }} rounded-pill px-3">{{ $ro->status == 3 ? 'Delivered' : 'Pending' }}</span></td>
                                <td class="pe-4 text-muted small">{{ $ro->created_at->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0">New Products</h5>
                </div>
                <div class="card-body px-0">
                    <ul class="list-group list-group-flush">
                        @foreach($recent_products as $rp)
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-4 py-3">
                            <div class="d-flex align-items-center">
                                <img src="{{ $rp->image_url }}" class="rounded shadow-sm me-3" width="40">
                                <div>
                                    <h6 class="mb-0 fw-bold small">{{ $rp->name }}</h6><small class="text-success">${{ $rp->sale_price }}</small>
                                </div>
                            </div>
                            <span class="badge bg-light text-dark border">{{ $rp->quantity }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. USERS, WITHDRAWALS, POINTS, PRIZES -->
    <div class="row g-4 mb-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0">Recent Users</h5>
                </div>
                <div class="card-body px-0">
                    <ul class="list-group list-group-flush">
                        @foreach($recent_users as $ru)
                        <li class="list-group-item d-flex align-items-center border-0 px-4 py-3">
                            <img src="{{ $ru->image_url }}" class="rounded-circle me-3 border" width="40" height="40">
                            <div>
                                <h6 class="mb-0 fw-bold small">{{ $ru->name }}</h6><small class="text-muted">Bal: ${{ number_format($ru->wallet_balance, 2) }}</small>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0">Financial Requests (Withdrawals)</h5>
                </div>
                <div class="card-body px-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light small text-muted">
                            <tr>
                                <th class="ps-4">User</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th class="pe-4">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($withdrawals as $w)
                            <tr>
                                <td class="ps-4 fw-bold small">{{ $w->user->name ?? 'User' }}</td>
                                <td class="fw-bold text-primary">${{ number_format($w->amount, 2) }}</td>
                                <td><span class="badge text-bg-info px-3">{{ $w->method }}</span></td>
                                <td class="pe-4"><span class="badge {{ $w->status_class }} rounded-pill px-3">{{ $w->status_label }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0">Points Intelligence</h5>
                </div>
                <div class="card-body px-0">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="bg-light small text-muted">
                            <tr>
                                <th class="ps-4">User</th>
                                <th>Order</th>
                                <th>Points</th>
                                <th class="pe-4">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user_points as $up)
                            <tr>
                                <td class="ps-4 small">{{ $up->user->name ?? 'User' }}</td>
                                <td>#{{ $up->order_id }}</td>
                                <td class="text-info fw-bold">+{{ $up->point }}</td>
                                <td class="pe-4 small">{{ $up->date->format('M d') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0">Recent Prize Winners</h5>
                </div>
                <div class="card-body px-0">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="bg-light small text-muted">
                            <tr>
                                <th class="ps-4">Winner</th>
                                <th>Prize</th>
                                <th class="pe-4">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user_prizes as $uprize)
                            <tr>
                                <td class="ps-4 small">{{ $uprize->user->name ?? 'User' }}</td>
                                <td class="fw-bold small">{{ $uprize->prize->name ?? 'Gift' }}</td>
                                <td class="pe-4"><span class="badge {{ $uprize->status_class }}">{{ $uprize->status_label }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- 6. CHAT, PROFILE, & STOCK ALERTS -->
    <div class="row g-4 mb-4">
        <!-- Stock -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100 border-top border-4 border-danger">
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between">
                    <h5 class="fw-bold text-danger mb-0">Stock Alerts</h5>
                    <i class="zmdi zmdi-alert-triangle text-danger"></i>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        @foreach($stock_alerts as $sa)
                        <li class="d-flex justify-content-between mb-3 border-bottom pb-2">
                            <span class="small fw-bold">{{ $sa->name }}</span>
                            <span class="badge text-bg-danger">{{ $sa->quantity }} Left</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <!-- Profile -->
        
        <!-- Chat Widget -->
    
    </div>

    
</div>

@push('scripts')
<script>
    function renderIntelligenceCharts() {
        if (typeof ApexCharts === 'undefined') {
            setTimeout(renderIntelligenceCharts, 100);
            return;
        }
        const data = @json($chartData);

        const baseOptions = {
            chart: {
                height: 320,
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                },
                fontFamily: 'Inter, sans-serif'
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            grid: {
                borderColor: '#f1f1f1'
            }
        };

        // Charts initialization
        new ApexCharts(document.querySelector("#apex-daily"), {
            ...baseOptions,
            series: [{
                name: 'Orders',
                data: data.daily.data
            }],
            xaxis: {
                categories: data.daily.labels
            },
            colors: ['#4e73df'],
            fill: {
                type: 'gradient',
                gradient: {
                    opacityFrom: 0.3,
                    opacityTo: 0.05
                }
            },
            chart: {
                ...baseOptions.chart,
                type: 'area'
            }
        }).render();
        new ApexCharts(document.querySelector("#apex-monthly"), {
            ...baseOptions,
            series: [{
                name: 'Orders',
                data: data.monthly.data
            }],
            xaxis: {
                categories: data.monthly.labels
            },
            colors: ['#1cc88a'],
            chart: {
                ...baseOptions.chart,
                type: 'area'
            }
        }).render();
        new ApexCharts(document.querySelector("#apex-yearly"), {
            ...baseOptions,
            series: [{
                name: 'Orders',
                data: data.yearly.data
            }],
            xaxis: {
                categories: data.yearly.labels
            },
            colors: ['#f6c23e'],
            chart: {
                ...baseOptions.chart,
                type: 'bar'
            },
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    columnWidth: '40%'
                }
            }
        }).render();
        new ApexCharts(document.querySelector("#apex-pie"), {
            series: data.pie.map(i => i[1]),
            labels: data.pie.map(i => i[0]),
            chart: {
                type: 'donut',
                height: 320
            },
            colors: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e'],
            legend: {
                position: 'bottom'
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '75%'
                    }
                }
            }
        }).render();
    }

    document.addEventListener('livewire:navigated', renderIntelligenceCharts);

    document.querySelectorAll('button[data-bs-toggle="pill"]').forEach(tab => {
        tab.addEventListener('shown.bs.tab', () => window.dispatchEvent(new Event('resize')));
    });
</script>

<style>
   

    .card {
        border-radius: 12px;
    }

    .btn-white {
        background: #fff;
        color: #4e73df;
    }

    .nav-adobe-pills .nav-link {
        font-weight: 700;
        color: #858796;
        font-size: 0.75rem;
        text-transform: uppercase;
        border-radius: 20px;
    }

    .nav-adobe-pills .nav-link.active {
        background: #4e73df !important;
        color: #fff !important;
    }

    .table thead th {
        border: 0;
        text-transform: uppercase;
        font-size: 0.65rem;
        background: #f8f9fc !important;
        padding: 12px;
    }
</style>
@endpush