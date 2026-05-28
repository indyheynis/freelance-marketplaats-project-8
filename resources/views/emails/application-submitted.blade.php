<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Application sent</title>
</head>
<body style="margin:0; padding:0; background:#f5f7fb; font-family: Arial, sans-serif;">

    <div style="max-width:600px; margin:40px auto; background:#ffffff; border-radius:12px; overflow:hidden; border:1px solid #e5e7eb;">

        <!-- Header -->
        <div style="background:#4f46e5; padding:24px; text-align:center;">
            <h1 style="color:#ffffff; margin:0; font-size:20px;">Application Successfully Sent</h1>
        </div>

        <!-- Content -->
        <div style="padding:24px; color:#111827;">

            <p style="font-size:16px; margin-bottom:16px;">
                Hello {{ $application->freelancer->firstname }},
            </p>

            <p style="font-size:15px; line-height:1.6; color:#374151;">
                Your application for the commission
                <strong>"{{ $application->commission->title }}"</strong>
                has been successfully sent.
            </p>

            @if($application->message)
            <div style="margin:20px 0; padding:16px; background:#f9fafb; border-left:4px solid #4f46e5; border-radius:8px;">
                <p style="margin:0 0 6px; font-size:13px; color:#6b7280;">Your message</p>
                <p style="margin:0; font-size:14px; color:#111827;">{{ $application->message }}</p>
            </div>
            @endif

            <p style="font-size:14px; line-height:1.6; color:#374151;">
                The client will review your application as soon as possible.
            </p>

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
