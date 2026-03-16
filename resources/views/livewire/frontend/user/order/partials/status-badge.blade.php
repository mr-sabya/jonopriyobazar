@php
/**
* Map order status integers to human-readable labels and CSS classes.
* 0: Pending, 1: Received, 2: Processing, 3: Completed, 4: Canceled
*/
$statusMap = [
0 => [
'label' => 'Pending',
'class' => 'badge-warning-light text-warning',
'icon' => 'fa-clock'
],
1 => [
'label' => 'Received',
'class' => 'badge-primary-light text-primary',
'icon' => 'fa-check-circle'
],
2 => [
'label' => 'Processing',
'class' => 'badge-info-light text-info',
'icon' => 'fa-spinner fa-spin'
],
3 => [
'label' => 'Completed',
'class' => 'badge-success-light text-success',
'icon' => 'fa-check-double'
],
4 => [
'label' => 'Canceled',
'class' => 'badge-dark-light text-muted',
'icon' => 'fa-times-circle'
],
];

$currentStatus = $statusMap[$order->status] ?? [
'label' => 'Unknown',
'class' => 'badge-secondary',
'icon' => 'fa-question-circle'
];
@endphp

<span class="badge {{ $currentStatus['class'] }} px-3 py-2 br-10 d-inline-flex align-items-center font-weight-bold shadow-sm" style="min-width: 100px; justify-content: center;">
    <i class="fas {{ $currentStatus['icon'] }} mr-2"></i>
    {{ $currentStatus['label'] }}
</span>