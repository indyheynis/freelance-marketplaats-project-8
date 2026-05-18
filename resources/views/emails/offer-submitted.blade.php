<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Sollicitatie bevestigd</title>
</head>
<body style="margin:0; padding:0; background:#f5f7fb; font-family: Arial, sans-serif;">

    <div style="max-width:600px; margin:40px auto; background:#ffffff; border-radius:12px; overflow:hidden; border:1px solid #e5e7eb;">

        <!-- Header -->
        <div style="background:#4f46e5; padding:24px; text-align:center;">
            <h1 style="color:#ffffff; margin:0; font-size:20px;">
                Sollicitatie succesvol verzonden
            </h1>
        </div>

        <!-- Content -->
        <div style="padding:24px; color:#111827;">

            <p style="font-size:16px; margin-bottom:16px;">
                Hallo 👋,
            </p>

            <p style="font-size:15px; line-height:1.6; color:#374151;">
                Je sollicitatie voor de opdracht
                <strong>"{{ $application->commission->title }}"</strong>
                is succesvol verzonden.
            </p>

            <!-- Message box -->
            <div style="margin:20px 0; padding:16px; background:#f9fafb; border-left:4px solid #4f46e5; border-radius:8px;">
                <p style="margin:0; font-size:13px; color:#6b7280;">Jouw bericht</p>
                <p style="margin-top:6px; font-size:14px; color:#111827;">
                    {{ $application->message ?: 'Geen extra bericht toegevoegd.' }}
                </p>
            </div>

            <p style="font-size:14px; line-height:1.6; color:#374151;">
                De opdrachtgever bekijkt je sollicitatie zo snel mogelijk en neemt contact met je op bij interesse.
            </p>

            <!-- Info box -->
            <div style="margin-top:20px; padding:12px 16px; background:#eef2ff; border-radius:8px; font-size:13px; color:#4338ca;">
                💡 Tip: Zorg dat je profiel up-to-date is voor een grotere kans op reacties.
            </div>

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