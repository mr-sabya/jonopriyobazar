@foreach($notifications as $notification)
<div class="col-lg-12">
    <div class="product_wrap p-3">
        <a href="{{ route('user.notification.show', $notification->id) }}">
            <div class="row">
                <div class="col-2">
                    <img src="{{ url('frontend/images/logo_dark.png') }}">
                </div>
                <div class="col-8 m-auto">
                    <p class="text-center m-auto">
                        {{ $notification->data['data']['info'] }}
                    </p>
                </div>
                <div class="col-2 m-auto">
                    @if($notification->read_at == null)
                    <span class="badge badge-warning">Unread</span>
                    @else
                    <span class="badge badge-success">Read</span>
                    @endif
                </div>
            </div>
        </a>

    </div>
</div>
@endforeach