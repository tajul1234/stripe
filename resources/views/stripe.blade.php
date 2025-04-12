<!DOCTYPE html>
<html>
<head>
    <title>Laravel Stripe Payment</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <h2>Laravel Stripe Payment</h2>
    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif
    <form action="{{ route('stripe.post') }}" method="POST">
        @csrf
        <script
            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="{{ env('STRIPE_KEY') }}"
            data-amount="10000"
            data-name="Laravel Stripe Payment"
            data-description="Pay 10000 Taka"
            data-currency="bdt">
        </script>
    </form>
</body>
</html>
