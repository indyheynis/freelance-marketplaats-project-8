<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Nieuwe offerte ontvangen</title>
</head>
<body style="margin:0; padding:0; background:#f5f7fb; font-family: Arial, sans-serif;">

    <div style="max-width:600px; margin:40px auto; background:#ffffff; border-radius:12px; overflow:hidden; border:1px solid #e5e7eb;">

        <!-- Header -->
        <div style="background:#4f46e5; padding:24px; text-align:center;">
            <h1 style="color:#ffffff; margin:0; font-size:20px;">
                Nieuwe offerte ontvangen
            </h1>
        </div>

        <!-- Content -->
        <div style="padding:24px; color:#111827;">

            <p style="font-size:16px; margin-bottom:16px;">
                Hallo {{ $offer->commission->user->firstname }},
            </p>

            <p style="font-size:15px; line-height:1.6; color:#374151;">
                Je hebt een nieuwe offerte ontvangen voor de opdracht
                <strong>"{{ $offer->commission->title }}"</strong>.
            </p>

            <!-- Offer details -->
            <div style="margin:20px 0; padding:16px; background:#f9fafb; border-left:4px solid #4f46e5; border-radius:8px;">
                <p style="margin:0 0 8px; font-size:13px; color:#6b7280;">Offerte details</p>
                <p style="margin:0 0 6px; font-size:14px; color:#111827;">
                    <strong>Freelancer:</strong> {{ $offer->user->firstname }} {{ $offer->user->lastname }}
                </p>
                <p style="margin:0 0 6px; font-size:14px; color:#111827;">
                    <strong>Bedrag:</strong> €{{ number_format($offer->price, 2, ',', '.') }}
                </p>
                @if($offer->message)
                <p style="margin:8px 0 0; font-size:13px; color:#6b7280;">Bericht</p>
                <p style="margin:4px 0 0; font-size:14px; color:#111827;">{{ $offer->message }}</p>
                @endif
            </div>

            <p style="font-size:14px; line-height:1.6; color:#374151;">
                Log in op FreelanceHub om de offerte te bekijken en te accepteren of af te wijzen.
            </p>

            <p style="margin-top:24px; font-size:14px;">
                Groeten,<br>
                <strong>{{ config('app.name') }}</strong>
            </p>

        </div>

        <!-- Footer -->
        <div style="background:#f3f4f6; padding:16px; text-align:center; font-size:12px; color:#6b7280;">
            Dit is een automatische e-mail, je kunt hier niet op reageren.
        </div>

    </div>

</body>
</html>
