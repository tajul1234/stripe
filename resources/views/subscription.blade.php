<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stripe Subscription</title>
</head>
<body>
    <h1>Subscription Page</h1>
    <p>You are about to pay <strong>${{ number_format($price, 2) }}</strong> USD for the subscription.</p>

    <form action="{{ route('subscribe') }}" method="POST" id="payment-form">
        @csrf
        <input id="card-holder-name" name="cardholder_name" type="text" placeholder="Cardholder name" required>

        <!-- Stripe Card Element -->
        <div id="card-element" style="margin: 15px 0;"></div>

        <!-- Hidden input to store payment method ID -->
        <input type="hidden" name="payment_method" id="payment-method">

        <button type="submit" id="card-button" data-secret="{{ $intent->client_secret }}">
            Subscribe
        </button>
    </form>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe("{{ env('STRIPE_KEY') }}");
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        const form = document.getElementById('payment-form');
        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            if (!cardHolderName.value.trim()) {
                alert("Please enter the cardholder's name.");
                return;
            }

            const { setupIntent, error } = await stripe.confirmCardSetup(
                clientSecret,
                {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name: cardHolderName.value
                        }
                    }
                }
            );

            if (error) {
                alert(error.message);
            } else {
                document.getElementById('payment-method').value = setupIntent.payment_method;
                form.submit();
            }
        });
    </script>
</body>
</html>
