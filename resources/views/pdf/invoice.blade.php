<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice {{ $transaction->invoice_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #333; }
        .header { margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; }
        .info-table { width: 100%; margin: 15px 0; border-collapse: collapse; }
        .info-table td { padding: 4px 8px; vertical-align: top; }
        .info-table .label { font-weight: bold; width: 140px; }
        table.items { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table.items th, table.items td { border: 1px solid #666; padding: 6px 8px; text-align: left; }
        table.items th { background: #eee; font-size: 10px; }
        table.items .text-right { text-align: right; }
        .total-row { font-weight: bold; background: #f5f5f5; }
        .footer { margin-top: 25px; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>INVOICE</h1>
        <strong>{{ $transaction->invoice_number }}</strong> &nbsp;|&nbsp; {{ $transaction->transaction_date->format('d F Y') }}
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Customer</td>
            <td>
                {{ $transaction->customer_code }} - {{ $transaction->customer_name }}<br>
                {{ $transaction->customer_address }}
            </td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Price</th>
                <th class="text-right">Disc 1</th>
                <th class="text-right">Disc 2</th>
                <th class="text-right">Disc 3</th>
                <th class="text-right">Net</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaction->details as $index => $detail)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $detail->product_code }} - {{ $detail->product_name }}</td>
                <td class="text-right">{{ $detail->qty }}</td>
                <td class="text-right">{{ number_format($detail->price, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($detail->discount_1, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($detail->discount_2, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($detail->discount_3, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($detail->net_price, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="8" class="text-right">GRAND TOTAL (Rp)</td>
                <td class="text-right">{{ number_format($transaction->total, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Generated on {{ now()->format('d M Y H:i') }}
    </div>
</body>
</html>
