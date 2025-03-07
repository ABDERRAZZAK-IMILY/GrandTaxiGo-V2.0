<!DOCTYPE html>
<html>
<head>
    <title>QR Code Test</title>
</head>
<body>
    <div style="text-align: center; margin-top: 50px;">
        <h1>QR Code Test</h1>
        
        @if(isset($qrCodePath))
            <div style="margin: 20px;">
                <img src="{{ Storage::url($qrCodePath) }}" alt="QR Code">
            </div>
        @else
            <p>No QR code available</p>
        @endif
    </div>
</body>
</html>