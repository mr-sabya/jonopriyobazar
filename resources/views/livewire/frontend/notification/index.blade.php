<div class="section py-5">
    <div class="custom-container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <!-- Header Section -->
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h3 class="font-weight-bold mb-1">Notifications</h3>
                        <p class="text-muted small mb-0">Stay updated with your latest activities</p>
                    </div>
                    @if(Auth::user()->unreadNotifications->count() > 0)
                    <button wire:click="markAllAsRead" class="btn btn-outline-primary btn-sm br-10 px-3 shadow-sm font-weight-bold">
                        <i class="fas fa-check-double mr-1"></i> Mark all as read
                    </button>
                    @endif
                </div>

                @if(session()->has('success'))
                    <div class="alert alert-success br-10 border-0 shadow-sm mb-4">
                        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                    </div>
                @endif

                <div class="notification-list">
                    @forelse($notifications as $notification)
                    <div class="card border-0 shadow-sm br-15 mb-3 overflow-hidden transition-hover {{ $notification->read_at == null ? 'unread-border' : '' }}">
                        <div class="card-body p-0">
                            <a href="javascript:void(0)" 
                               wire:click="readAndRedirect('{{ $notification->id }}')" 
                               class="text-decoration-none d-block p-3 notification-item {{ $notification->read_at == null ? 'bg-unread' : 'bg-white' }}">
                                
                                <div class="row align-items-center">
                                    <!-- Icon Column -->
                                    <div class="col-auto">
                                        <div class="icon-box {{ $notification->read_at == null ? 'bg-primary text-white' : 'bg-light text-muted' }}">
                                            @php
                                                $role = $notification->data['role'] ?? 'default';
                                            @endphp
                                            @if($role == 'wallet' || $role == 'walletpackage')
                                                <i class="fas fa-wallet"></i>
                                            @elseif($role == 'order')
                                                <i class="fas fa-shopping-bag"></i>
                                            @else
                                                <i class="fas fa-bell"></i>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Content Column -->
                                    <div class="col pl-0">
                                        <p class="mb-1 text-dark {{ $notification->read_at == null ? 'font-weight-bold' : '' }}">
                                            {{ $notification->data['data']['info'] ?? 'New Notification' }}
                                        </p>
                                        <div class="d-flex align-items-center mt-1">
                                            <span class="text-muted small">
                                                <i class="far fa-clock mr-1"></i> {{ $notification->created_at->diffForHumans() }}
                                            </span>
                                            @if($notification->read_at == null)
                                            <span class="ml-2 dot-indicator"></span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Status Column -->
                                    <div class="col-auto text-right">
                                        <i class="fas fa-chevron-right text-light small"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-bell-slash fa-4x text-light"></i>
                        </div>
                        <h5 class="text-muted">No notifications yet</h5>
                        <p class="small text-muted">We'll notify you when something important happens.</p>
                    </div>
                    @endforelse
                </div>

                <!-- Load More Section -->
                @if($notifications->hasMorePages())
                <div class="text-center mt-5">
                    <button wire:click="loadMore" class="btn btn-white shadow-sm br-10 px-5 font-weight-bold py-2 border">
                        <span wire:loading.remove wire:target="loadMore">Load More Activity</span>
                        <span wire:loading wire:target="loadMore">
                            <i class="fas fa-spinner fa-spin mr-2"></i> Loading...
                        </span>
                    </button>
                </div>
                @endif
                
            </div>
        </div>
    </div>
</div>