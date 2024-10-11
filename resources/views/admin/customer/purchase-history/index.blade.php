

<!-- resources/views/customer/purchases/index.blade.php -->
<h2>Purchase History</h2>
<ul>
    @forelse ($purchases as $purchase)
        <li>{{ $purchase->item_name }} - {{ $purchase->quantity }} - {{ $purchase->total_price }} - {{ $purchase->created_at->format('d-m-Y H:i:s') }}</li>
    @empty
        <li>No purchases found.</li>
    @endforelse
</ul>
