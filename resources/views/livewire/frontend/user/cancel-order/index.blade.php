<div class="col-lg-9 pt-3">
    <!-- Header & Type Switcher -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="font-weight-bold mb-0">Canceled Orders</h3>
    </div>

    <!-- Navigation Tabs -->
    <ul class="nav nav-pills mb-4 bg-light p-2 br-15">
        @foreach(['product' => 'Products', 'medicine' => 'Medicine', 'custom' => 'Custom', 'electricity' => 'Electricity'] as $key => $label)
        <li class="nav-item flex-fill text-center">
            <a href="javascript:void(0)"
                wire:click="setType('{{ $key }}')"
                class="nav-link br-10 font-weight-bold {{ $type == $key ? 'active bg-danger text-white' : 'text-muted' }}">
                {{ $label }}
            </a>
        </li>
        @endforeach
    </ul>

    <!-- Table Section -->
    <div class="card border-0 shadow-sm br-15 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="border-0 px-4 small font-weight-bold text-muted">#</th>
                        <th class="border-0 small font-weight-bold text-muted">DATE</th>
                        <th class="border-0 small font-weight-bold text-muted">ORDER#INVOICE</th>
                        <th class="border-0 text-center small font-weight-bold text-muted">AMOUNT</th>
                        <th class="border-0 small font-weight-bold text-muted">PAYMENT</th>
                        <th class="border-0 text-center small font-weight-bold text-muted">STATUS</th>
                        <th class="border-0 text-right px-4 small font-weight-bold text-muted">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="px-4 py-3 small text-muted">
                            {{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}
                        </td>
                        <td>
                            <p class="font-weight-bold text-dark mb-0 small">{{ date('d-m-Y', strtotime($order->created_at)) }}</p>
                            <p class="small text-muted mb-0">{{ $order->created_at->diffForHumans() }}</p>
                        </td>
                        <td>
                            <span class="font-weight-bold text-primary">#{{ $order->invoice }}</span>
                        </td>
                        <td class="text-center">
                            <span class="font-weight-bold text-dark">{{ number_format($order->grand_total, 2) }}৳</span>
                        </td>
                        <td>
                            <span class="small font-weight-bold">
                                @if($order->payment_option == 'cash') Cash
                                @elseif($order->payment_option == 'wallet') Wallet
                                @else Refer @endif
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-dark-light text-muted px-2 py-2 br-10 w-100" style="max-width: 100px;">
                                Canceled
                            </span>
                        </td>
                        <td class="text-right px-4">
                            <a href="{{ route('user.order.show', $order->invoice) }}" wire:navigate class="btn btn-sm btn-outline-secondary br-10">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fas fa-ban fa-3x text-muted mb-3 opacity-25"></i>
                            <p class="text-muted">No canceled {{ $type }} orders found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
        <div class="card-footer bg-white border-0 pt-0 px-4 pb-4">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>