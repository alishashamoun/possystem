
<h1>Inventory Report</h1>

<table>
    <thead>
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Value</th>
        </tr>
    </thead>
    <tbody>
        @foreach($report as $item)
            <tr>
                <td>{{ $item['product_name'] }}</td>
                <td>{{ $item['quantity'] }}</td>
                <td>{{ $item['value'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
