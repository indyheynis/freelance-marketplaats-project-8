<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Sollicitatie bevestigd</title>
</head>
<body>
    <h1>Sollicitatie bevestigd</h1>

    <p>
        Je sollicitatie voor opdracht
        "<strong>{{ $application->commission->title }}</strong>"
        is succesvol verzonden.
    </p>

    <p>
        <strong>Bericht:</strong><br>
        {{ $application->message ?: 'Geen extra bericht toegevoegd.' }}
    </p>

    <p>
        We nemen zo snel mogelijk contact met je op zodra de opdrachtgever reageert.
    </p>

    <p>
        Groeten,<br>
        {{ config('app.name') }}
    </p>
</body>
</html>