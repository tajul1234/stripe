<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{ route('subscribe') }}" method="POST" id="payment-form">
        @csrf
        <input id="card-holder-name" type="text" placeholder="Cardholder name">

        <!-- Stripe Card Element -->
        <div id="card-element"></div>

        <button id="card-button" data-secret="{{ $intent->client_secret }}">
            Subscribe
        </button>
    </form>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe("{{ env('STRIPE_KEY') }}");
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;

        cardButton.addEventListener('click', async (e) => {
            const { paymentMethod, error } = await stripe.createPaymentMethod(
                'card', cardElement, {
                    billing_details: { name: cardHolderName.value }
                }
            );

            if (error) {
                alert(error.message);
            } else {
                // Send paymentMethod.id to backend for subscription
                fetch('/subscribe', {
                    method: 'POST',
                    body: JSON.stringify({ payment_method: paymentMethod.id }),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Subscription successful!");
                    }
                });
            }
        });
    </script>

</body>
</html>
