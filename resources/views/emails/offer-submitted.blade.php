<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Offer sent</title>
</head>
<body style="margin:0; padding:0; background:#f5f7fb; font-family: Arial, sans-serif;">

    <div style="max-width:600px; margin:40px auto; background:#ffffff; border-radius:12px; overflow:hidden; border:1px solid #e5e7eb;">

        <!-- Header -->
        <div style="background:#4f46e5; padding:24px; text-align:center;">
            <h1 style="color:#ffffff; margin:0; font-size:20px;">
                Offer Successfully Sent
            </h1>
        </div>

        <!-- Content -->
        <div style="padding:24px; color:#111827;">

            <p style="font-size:16px; margin-bottom:16px;">
                Hello {{ $offer->user->firstname }},
            </p>

            <p style="font-size:15px; line-height:1.6; color:#374151;">
                Your offer for the commission
                <strong>"{{ $offer->commission->title }}"</strong>
                has been successfully sent.
            </p>

            <!-- Offer details -->
            <div style="margin:20px 0; padding:16px; background:#f9fafb; border-left:4px solid #4f46e5; border-radius:8px;">
                <p style="margin:0 0 6px; font-size:13px; color:#6b7280;">Your offer</p>
                <p style="margin:0 0 6px; font-size:14px; color:#111827;">
                    <strong>Amount:</strong> €{{ number_format($offer->price, 2, ',', '.') }}
                </p>
                @if($offer->message)
                <p style="margin:8px 0 0; font-size:13px; color:#6b7280;">Message</p>
                <p style="margin:4px 0 0; font-size:14px; color:#111827;">{{ $offer->message }}</p>
                @endif
            </div>

            <p style="font-size:14px; line-height:1.6; color:#374151;">
                The client will review your offer as soon as possible.
            </p>

            <div style="margin-top:20px; padding:12px 16px; background:#eef2ff; border-radius:8px; font-size:13px; color:#4338ca;">
                Tip: Keep your profile up-to-date for better chances of getting responses.
            </div>

            <p style="margin-top:24px; font-size:14px;">
                Best regards,<br>
                <strong>{{ config('app.name') }}</strong>
            </p>

        </div>

        <!-- Footer -->
        <div style="background:#f3f4f6; padding:16px; text-align:center; font-size:12px; color:#6b7280;">
            This is an automated email, you cannot reply to it.
        </div>

    </div>

</body>
</html>
