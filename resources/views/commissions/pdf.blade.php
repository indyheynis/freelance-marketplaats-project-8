<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; color: #1e293b; padding: 40px; }
        h1 { font-size: 24px; margin-bottom: 4px; }
        .badge { display: inline-block; background: #e0e7ff; color: #3730a3; padding: 4px 12px; border-radius: 20px; font-size: 12px; }
        .section { margin-top: 24px; border-top: 1px solid #e2e8f0; padding-top: 16px; }
        .label { font-size: 12px; color: #64748b; margin-bottom: 4px; }
        .value { font-size: 16px; font-weight: 600; }
        .grid { display: flex; gap: 40px; margin-top: 16px; }
        .footer { margin-top: 40px; font-size: 11px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 12px; }
    </style>
</head>
<body>
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1>{{ $commission->title }}</h1>
            @if($commission->category)
                <span class="badge">{{ $commission->category->name }}</span>
            @endif
        </div>
        <div style="font-size: 12px; color: #64748b;">
            FreelanceHub &bull; {{ now()->format('d-m-Y') }}
        </div>
    </div>

    <div class="section">
        <div class="label">Description</div>
        <p style="color: #475569; line-height: 1.6;">{{ $commission->description }}</p>
    </div>

    <div class="section">
        <div class="grid">
            <div>
                <div class="label">Budget</div>
                <div class="value">{{ $commission->budget }}</div>
            </div>
            <div>
                <div class="label">Deadline</div>
                <div class="value">{{ $commission->deadline }}</div>
            </div>
            <div>
                <div class="label">Posted by </div>
                <div class="value">{{ $commission->user->firstname }} {{ $commission->user->lastname }}</div>
            </div>
        </div>
    </div>

    <div class="footer">
        Gegenereerd via FreelanceHub &bull; {{ now()->format('d-m-Y H:i') }}
    </div>
</body>
</html>