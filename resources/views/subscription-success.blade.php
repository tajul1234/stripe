<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #28a745;
        }
        p {
            font-size: 1.1rem;
            line-height: 1.6;
            text-align: center;
        }
        ul {
            list-style: none;
            padding: 0;
            font-size: 1.1rem;
        }
        ul li {
            margin: 10px 0;
            text-align: left;
        }
        ul li strong {
            color: #007bff;
        }
        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .btn:hover {
            background-color: #218838;
        }
        @media screen and (max-width: 768px) {
            body {
                padding: 10px;
            }
            .container {
                padding: 15px;
            }
            h1 {
                font-size: 1.5rem;
            }
            p {
                font-size: 1rem;
            }
            ul li {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Subscription Successful!</h1>
        <p>Thank you for subscribing to our service.</p>

        <p>Your subscription details:</p>
        <ul>
            <li><strong>Today's Date:</strong> {{ \Carbon\Carbon::now()->toFormattedDateString() }}</li>
            <li><strong>Plan Name:</strong> {{ $subscription->name }}</li>
            <li><strong>Amount:</strong> ${{ $amount }} {{ $priceCurrency }}</li>
            <li><strong>Next Billing Date:</strong> {{ $nextBillingDate }}</li>
        </ul>

        <a href="{{ route('dashboard') }}" class="btn">Back to Dashboard</a>
    </div>
</body>
</html>
