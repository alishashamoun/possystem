


  <h1>Low Stock Products</h1>

  @if(count($lowStockProducts) > 0)
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Product Name</th>
          <th>Quantity</th>
          <th>Threshold</th>
        </tr>
      </thead>
      <tbody>
        @foreach($lowStockProducts as $product)
          <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->stock->quantity }}</td>
            <td>{{ $product->threshold }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <p>No products with low stock levels found.</p>
  @endif
