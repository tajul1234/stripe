<!DOCTYPE html>
<html>
<head>
    <title>Pay with AamarPay</title>
</head>
<body>
    <h2>AamarPay Sandbox Payment</h2>

    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <form method="POST" action="{{ route('pay.now') }}">
        @csrf
        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Phone:</label><br>
        <input type="text" name="phone" required><br><br>

        <label>Amount (BDT):</label><br>
        <input type="number" name="amount" required><br><br>

        <button type="submit">Pay Now</button>
    </form>
</body>
</html>
