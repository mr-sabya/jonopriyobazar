<table class="table table-bordered w-100">
	<tr>
		<td>Invoice</td>
		<td>#{{ $order->invoice }}</td>
	</tr>
	<tr>
		<td>Power Company</td>
		<td>{{ $order->company['name'] }} - {{ $order->company['type'] }}</td>
	</tr>
	<tr>
		<td>Meter/Customer Number</td>
		<td>{{ $order->meter_no }}</td>
	</tr>
	<tr>
		<td>Phone Number</td>
		<td>{{ $order->phone }}</td>
	</tr>
	<tr>
		<td>Amount</td>
		<td>{{ $order->grand_total }}৳</td>
	</tr>
	<tr>
		<td>Status</td>
		<td>
			@if($order->status == 0)
			<span class="badge badge-warning">
				Pending
			</span>
			@elseif($order->status == 1)
			<span class="badge badge-primary">
				Received
			</span>
			@elseif($order->status == 2)
			<span class="badge badge-info">
				Processing
			</span>
			@elseif($order->status == 3)
			<span class="badge badge-success">
				Completed
			</span>
			@elseif($order->status == 4)
			<span class="badge badge-dark">
				Canceled
			</span>
			@endif
		</td>
	</tr>
</table>