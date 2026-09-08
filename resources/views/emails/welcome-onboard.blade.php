<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Country Culture Acres</title>
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
                                Welcome Onboard, {{ $name }}! 🌾
                            </h2>

                            <p style="margin-bottom: 20px; font-size: 15px; color: #334155; line-height: 1.6;">
                                We are delighted to welcome you to <strong>Country Culture Acres (CCA)</strong>. Your partner account is active and ready on our secure agritech co-ownership portal.
                            </p>

                            <p style="margin-bottom: 24px; font-size: 15px; color: #334155; line-height: 1.6;">
                                Through the CCA Portal, you gain direct access to your agricultural participation records, settlement tracking, and active batch metrics.
                            </p>

                            <!-- Feature Highlights Box -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #f8fafc; border-radius: 8px; border: 1px solid #cbd5e1; margin-bottom: 28px;">
                                <tr>
                                    <td style="padding: 20px 24px;">
                                        <h3 style="margin-top: 0; margin-bottom: 14px; font-size: 14px; font-weight: 700; text-transform: uppercase; color: #15803d; letter-spacing: 0.5px;">
                                            What You Can Do On Your Portal:
                                        </h3>
                                        <ul style="margin: 0; padding-left: 18px; color: #334155; font-size: 14px;">
                                            <li style="margin-bottom: 8px;"><strong>Co-Ownership Batches:</strong> Explore and track active crop participation batches.</li>
                                            <li style="margin-bottom: 8px;"><strong>Access Tokens:</strong> Activate and manage secure access tokens for batch entry.</li>
                                            <li style="margin-bottom: 8px;"><strong>Contributions & Settlements:</strong> View real-time verified records and withdrawal status updates.</li>
                                            <li style="margin-bottom: 0;"><strong>Security & Activity:</strong> Receive instant security alerts on sign-in and profile changes.</li>
                                        </ul>
                                    </td>
                                </tr>
                            </table>

                            <!-- Call to Action Button -->
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin-bottom: 32px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $portalUrl }}" target="_blank" style="display: inline-block; background-color: #15803d; color: #ffffff; font-size: 15px; font-weight: 600; text-decoration: none; padding: 14px 32px; border-radius: 8px; box-shadow: 0 2px 4px rgba(21, 128, 61, 0.2); transition: background-color 0.2s ease;">
                                            Access Your Portal Dashboard &rarr;
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <hr style="border: 0; border-top: 1px solid #e2e8f0; margin-bottom: 24px;">

                            <p style="margin-bottom: 8px; font-size: 14px; color: #64748b;">
                                Need assistance or have questions about your account? Contact our team at <a href="mailto:support@ccasecureportal.com" style="color: #15803d; text-decoration: underline;">support@ccasecureportal.com</a>.
                            </p>

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
                                Secure Agritech Co-Ownership Portal &bull; <a href="{{ $portalUrl }}" style="color: #64748b; text-decoration: underline;">ccasecureportal.com</a>
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
