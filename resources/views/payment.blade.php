<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stripe Subscription</title>
</head>
<body>
    <form action="{{ route('subscribe') }}" method="POST" id="payment-form">
        @csrf
        <input id="card-holder-name" type="text" placeholder="Cardholder name">
        <div id="card-element"></div>
        <button id="card-button" data-secret="{{ $intent->client_secret }}">Subscribe</button>
    </form>
</body>
</html>
