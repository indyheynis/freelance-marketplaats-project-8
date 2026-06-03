<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Application status</title>
</head>
<body>

    <h1>Application Status</h1>

    @if($application->status === 'accepted')

        <p>
            Great news! Your application for commission
            "{{ $application->commission->title }}"
            has been accepted.
        </p>

    @else

        <p>
            Unfortunately, your application for commission
            "{{ $application->commission->title }}"
            has been rejected.
        </p>

    @endif

    <p>
        <strong>Your message:</strong><br>
        {{ $application->message ?: 'No message provided.' }}
    </p>

    <p>
        View the commission for more information.
    </p>

    <br>

    <p>
        Best regards,<br>
        {{ config('app.name') }}
    </p>

</body>
</html>
