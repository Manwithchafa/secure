<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email Address - Country Culture Acres</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #1e293b; line-height: 1.6;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f1f5f9; padding: 40px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width: 600px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0;">
                    
                    <!-- Header with Logo -->
                    <tr>
                        <td align="center" style="padding: 32px 32px 24px 32px; background-color: #0f172a; border-bottom: 3px solid #15803d;">
                            @if (file_exists(public_path('hey.png')))
                                <img src="{{ $message->embed(public_path('hey.png')) }}" alt="Country Culture Acres Logo" style="height: 56px; width: auto; max-width: 220px; display: block; border: 0;" />
                            @else
                                <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 700; letter-spacing: -0.5px;">Country Culture Acres</h1>
                            @endif
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 40px 32px;">
                            <h2 style="margin-top: 0; margin-bottom: 16px; color: #0f172a; font-size: 22px; font-weight: 700; letter-spacing: -0.3px;">
                                Verify Your Email Address
                            </h2>

                            <p style="margin-bottom: 20px; font-size: 15px; color: #334155; line-height: 1.6;">
                                Hello <strong>{{ $name }}</strong>,
                            </p>

                            <p style="margin-bottom: 24px; font-size: 15px; color: #334155; line-height: 1.6;">
                                Thank you for registering with <strong>Country Culture Acres (CCA)</strong>. To complete your account activation and access your portal features, please verify your email address by clicking the button below.
                            </p>

                            @if (!empty($referenceToken) && $referenceToken !== 'N/A')
                            <!-- Reference Token Card -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #0f172a; border-radius: 8px; border-left: 4px solid #15803d; margin-bottom: 28px;">
                                <tr>
                                    <td style="padding: 20px 24px;">
                                        <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #94a3b8; letter-spacing: 1px; margin-bottom: 8px;">
                                            Your Partner Reference Token
                                        </div>
                                        <div style="font-family: 'Courier New', Courier, monospace, sans-serif; font-size: 22px; font-weight: 700; color: #38bdf8; letter-spacing: 2px; margin-bottom: 10px; user-select: all; -webkit-user-select: all; -moz-user-select: all; -ms-user-select: all; display: inline-block; padding: 6px 12px; background-color: rgba(255, 255, 255, 0.06); border-radius: 6px; border: 1px dashed rgba(56, 189, 248, 0.4);">
                                            {{ $referenceToken }}
                                        </div>
                                        <div style="font-size: 12px; color: #cbd5e1; line-height: 1.5;">
                                            <strong>Keep this reference token safe.</strong> Double-click or tap above to copy.
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            @endif

                            <!-- Primary Verification Action Button -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin-bottom: 28px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $verificationUrl }}" target="_blank" style="display: inline-block; background-color: #15803d; color: #ffffff; font-size: 16px; font-weight: 600; text-decoration: none; padding: 14px 36px; border-radius: 8px; box-shadow: 0 2px 4px rgba(21, 128, 61, 0.2);">
                                            Verify Email Address &rarr;
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin-bottom: 24px; font-size: 13px; color: #64748b; line-height: 1.5;">
                                Note: This verification link will expire in 60 minutes. If you did not create an account with Country Culture Acres, no further action is required.
                            </p>

                            <hr style="border: 0; border-top: 1px solid #e2e8f0; margin-bottom: 24px;">

                            <!-- Direct Clickable Fallback Box -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f8fafc; border-radius: 8px; border: 1px solid #cbd5e1; margin-bottom: 24px;">
                                <tr>
                                    <td style="padding: 16px 20px; font-size: 13px; color: #475569; line-height: 1.5;">
                                        <div style="font-weight: 600; color: #1e293b; margin-bottom: 6px;">
                                            Trouble clicking the button?
                                        </div>
                                        <div>
                                            Click the direct link below or copy and paste it into your browser address bar:
                                        </div>
                                        <div style="margin-top: 8px; padding: 10px 14px; background-color: #ffffff; border-radius: 6px; border: 1px solid #e2e8f0; word-break: break-all;">
                                            <a href="{{ $verificationUrl }}" target="_blank" style="color: #15803d; font-size: 13px; font-weight: 500; text-decoration: underline;">{{ $verificationUrl }}</a>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin-top: 24px; margin-bottom: 0; font-size: 14px; color: #334155;">
                                Warm regards,<br>
                                <strong>Country Culture Acres Team</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="padding: 20px 32px; background-color: #f8fafc; border-top: 1px solid #e2e8f0; font-size: 12px; color: #94a3b8;">
                            <p style="margin: 0 0 6px 0;">
                                &copy; {{ date('Y') }} Country Culture Acres. All rights reserved.
                            </p>
                            <p style="margin: 0;">
                                Support: <a href="mailto:support@ccasecureportal.com" style="color: #64748b; text-decoration: underline;">support@ccasecureportal.com</a>
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
