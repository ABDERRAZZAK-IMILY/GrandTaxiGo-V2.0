<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تأكيد الحجز</title>
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
            <h1>تم تأكيد حجزك!</h1>
        </div>
        
        <div class="content">
            <p>مرحباً {{ $reservation->user->name }}،</p>
            
            <p>نود إعلامك بأنه تم تأكيد حجزك للرحلة. فيما يلي تفاصيل الرحلة:</p>
            
            <div class="trip-details">
                <p><strong>رقم الحجز:</strong> #{{ $reservation->id }}</p>
                <p><strong>من:</strong> {{ $reservation->trip->departure_location }}</p>
                <p><strong>إلى:</strong> {{ $reservation->trip->destination }}</p>
                <p><strong>تاريخ المغادرة:</strong> {{ \Carbon\Carbon::parse($reservation->trip->departure_time)->format('Y-m-d H:i') }}</p>
                <p><strong>اسم السائق:</strong> {{ $reservation->trip->driver->name }}</p>
                <p><strong>عدد المقاعد:</strong> {{ $reservation->number_of_seats }}</p>
            </div>
            
            <p>يرجى الاحتفاظ برمز QR أدناه وإظهاره للسائق عند الصعود:</p>
            
            <div class="qr-code">
                <img src="{{ $message->embed(storage_path('app/public/' . $qrCodePath)) }}" alt="رمز QR للحجز">
            </div>
            
            <p>إذا كنت بحاجة إلى إلغاء الحجز أو تعديله، يرجى القيام بذلك من خلال حسابك على منصتنا.</p>
            
            <p>نتمنى لك رحلة آمنة وممتعة!</p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} GrandTaxiGo. جميع الحقوق محفوظة.</p>
        </div>
    </div>
</body>
</html> 