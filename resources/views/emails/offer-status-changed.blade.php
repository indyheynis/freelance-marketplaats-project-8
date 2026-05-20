<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Sollicitatie status</title>
</head>
<body>

    <h1>Sollicitatie status</h1>

    @if($application->status === 'accepted')

        <p>
            Goed nieuws! Je sollicitatie voor opdracht
            "{{ $application->commission->title }}"
            is geaccepteerd.
        </p>

    @else

        <p>
            Helaas, je sollicitatie voor opdracht
            "{{ $application->commission->title }}"
            is afgewezen.
        </p>

    @endif

    <p>
        <strong>Jouw bericht:</strong><br>
        {{ $application->message ?: 'Geen bericht toegevoegd.' }}
    </p>

    <p>
        Bekijk de opdracht voor meer informatie.
    </p>

    <br>

    <p>
        Groeten,<br>
        {{ config('app.name') }}
    </p>

</body>
</html>