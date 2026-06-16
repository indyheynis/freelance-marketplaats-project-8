<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; color: #1e293b; padding: 40px; font-size: 14px; }
        h1 { font-size: 28px; margin: 0; }
        .invoice-number { font-size: 14px; color: #64748b; margin-top: 4px; }
        .section { margin-top: 28px; border-top: 1px solid #e2e8f0; padding-top: 20px; }
        .label { font-size: 11px; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; }
        .value { font-size: 14px; }
        .value-bold { font-size: 14px; font-weight: 600; }
        .grid { display: flex; gap: 60px; }
        .status-badge { display: inline-block; padding: 4px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .status-paid { background: #dcfce7; color: #15803d; }
        .status-pending { background: #fef3c7; color: #92400e; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th { text-align: left; padding: 10px 12px; font-size: 12px; color: #64748b; border-bottom: 1px solid #e2e8f0; }
        th.right { text-align: right; }
        td { padding: 12px; border-bottom: 1px solid #f1f5f9; }
        td.right { text-align: right; }
        .total-row td { font-weight: 700; font-size: 16px; background: #f8fafc; border-top: 2px solid #e2e8f0; }
        .footer { margin-top: 48px; font-size: 11px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 12px; }
    </style>
</head>
<body>

    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div>
            <h1>FACTUUR</h1>
            <div class="invoice-number">{{ $invoice->invoice_number }}</div>
            <div style="margin-top: 8px;">
                <span class="status-badge {{ $invoice->isPaid() ? 'status-paid' : 'status-pending' }}">
                    {{ $invoice->isPaid() ? 'Betaald' : 'Openstaand' }}
                </span>
            </div>
        </div>
        <div style="text-align: right; font-size: 12px; color: #64748b;">
            <div style="font-size: 18px; font-weight: 700; color: #1e293b;">FreelanceHub</div>
            <div>{{ $invoice->created_at->format('d-m-Y') }}</div>
        </div>
    </div>

    <div class="section">
        <div class="grid">
            <div>
                <div class="label">Van (Freelancer)</div>
                <div class="value-bold">{{ $invoice->freelancer->firstname }} {{ $invoice->freelancer->lastname }}</div>
                <div class="value">{{ $invoice->freelancer->email }}</div>
                @if($invoice->freelancer->address)
                <div class="value">{{ $invoice->freelancer->address }}</div>
                <div class="value">{{ $invoice->freelancer->postal_code }} {{ $invoice->freelancer->city }}</div>
                @endif
            </div>
            <div>
                <div class="label">Aan (Opdrachtgever)</div>
                <div class="value-bold">{{ $invoice->client->firstname }} {{ $invoice->client->lastname }}</div>
                <div class="value">{{ $invoice->client->email }}</div>
                @if($invoice->client->address)
                <div class="value">{{ $invoice->client->address }}</div>
                <div class="value">{{ $invoice->client->postal_code }} {{ $invoice->client->city }}</div>
                @endif
            </div>
        </div>
    </div>

    <div class="section">
        <div class="label">Opdracht</div>
        <div class="value-bold">{{ $invoice->commission->title }}</div>
        @if($invoice->commission->category)
        <div style="margin-top: 4px; font-size: 12px; color: #64748b;">{{ $invoice->commission->category->name }}</div>
        @endif
    </div>

    <div class="section" style="border-top: none; padding-top: 0;">
        <table>
            <thead>
                <tr>
                    <th>Omschrijving</th>
                    <th class="right">Bedrag</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        {{ $invoice->commission->title }}
                        @if($invoice->offer?->message)
                        <br><span style="font-size: 12px; color: #64748b;">{{ $invoice->offer->message }}</span>
                        @endif
                    </td>
                    <td class="right">€{{ number_format($invoice->amount, 2, ',', '.') }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td style="text-align: right;">Totaal</td>
                    <td class="right">€{{ number_format($invoice->amount, 2, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    @if($invoice->isPaid())
    <div style="margin-top: 24px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 12px 16px;">
        <div style="font-size: 13px; color: #15803d; font-weight: 600;">Betaald op {{ $invoice->paid_at->format('d-m-Y') }}</div>
    </div>
    @endif

    <div class="footer">
        Gegenereerd via FreelanceHub &bull; {{ now()->format('d-m-Y H:i') }}
    </div>

</body>
</html>
