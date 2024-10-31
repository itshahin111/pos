<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    {{-- Email Otp Sending Body --}}
    <div
        style="background-color: #f0f0f0; padding: 20
    px; width: 100%; max-width: 600px; margin: 0 auto; font-family: 'figtree', sans-serif;">
        <div style="background-color: #fff; padding: 20px; border-radius: 5px;">
            <h1 style="font-size: 24px; margin-bottom: 10px;">Email Verification</h1>
            <p style="font
                size: 16px; line-height: 1.5; color: #666;">Hello </p>
            <p style="font-size: 16px; line-height: 1.5; color: #666;">
                We have sent an OTP to your email address <span style="font-weight: bold;"></span>
                for
                verification. Please enter the O
                following code to verify your email address:
            </p>

            <span style="font-weight: bold;">{{ $otp }}</span> to complete your email verification.
            <br><br>
            <p style="font-size: 14px; line-height: 1.5; color: #999;">
                If you did not request this email, please ignore this message. Your email may have been compromised.
            </p>
            <p style="font-size: 14px; line-height: 1.5; color: #999;">
                This OTP will expire in 10 minutes.
            </p>
            <p style="font-size: 14px; line-height: 1.5; color: #999;">
                Best regards,
            </p>
            <p style="font-size: 14px; line-height: 1.5;
                            color: #999;">Your Team</p>
            <p style="font-size: 14px; line-height: 1.5;
                            color: #999;">Email: <a
                    href="mailto:info@example.com">info@example
                    .com</a></p>
            <p style="font-size: 14px; line-height: 1.5;
                            color: #999;">Phone: (123) 456-7890
            </p>
        </div>
    </div>
    {{-- Email Otp Sending Body --}}


</body>

</html>
