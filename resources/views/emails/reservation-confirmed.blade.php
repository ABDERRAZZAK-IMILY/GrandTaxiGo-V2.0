<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Confirmation</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        .header h1 {
            color: #4a6cf7;
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px 0;
        }
        .trip-details {
            background-color: #f5f8ff;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
        }
        .trip-details p {
            margin: 8px 0;
        }
        .qr-code {
            text-align: center;
            margin: 30px 0;
        }
        .qr-code img {
            max-width: 200px;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #777;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            background-color: #4a6cf7;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Your Reservation is Confirmed!</h1>
        </div>
        
        <div class="content">
            <p>Hello {{ $reservation->user->name }},</p>
            
            <p>We are pleased to inform you that your trip reservation has been confirmed. Here are the trip details:</p>
            
            <div class="trip-details">
                <p><strong>Reservation Number:</strong> #{{ $reservation->id }}</p>
                <p><strong>From:</strong> {{ $reservation->trip->departure_location }}</p>
                <p><strong>To:</strong> {{ $reservation->trip->destination }}</p>
                <p><strong>Departure Date & Time:</strong> {{ \Carbon\Carbon::parse($reservation->trip->departure_time)->format('Y-m-d H:i') }}</p>
                <p><strong>Driver Name:</strong> {{ $reservation->trip->driver->name }}</p>
            </div>
            
            <p>Please keep the QR code below and show it to the driver when boarding:</p>
            
            <div class="qr-code">
                <img src="{{ $message->embed(storage_path('app/public/' . $qrCodePath)) }}">
            </div>
            
            <p>If you need to cancel or modify your reservation, please do so through your account on our platform.</p>
            
            <p>We wish you a safe and pleasant journey!</p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} GrandTaxiGo. All rights reserved. </p>
        </div>
    </div>
</body>
</html> 