<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Offer status</title>
</head>
<body>

    <h1>Offer Status</h1>

    @if($offer->status === 'accepted')

        <p>
            Great news! Your offer for commission
            "{{ $offer->commission->title }}"
            has been accepted.
        </p>

    @else

        <p>
            Unfortunately, your offer for commission
            "{{ $offer->commission->title }}"
            has been rejected.
        </p>

    @endif

    @if($offer->message)
    <p>
        <strong>Your message:</strong><br>
        {{ $offer->message }}
    </p>
    @endif

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
