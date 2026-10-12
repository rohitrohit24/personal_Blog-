<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Post Alert</title>
</head>

<body
    style="margin: 0; padding: 0; background-color: #0f172a; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased;">

    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"
        style="background-color: #0f172a; padding: 30px 10px;">
        <tr>
            <td align="center">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"
                    style="max-width: 600px; background-color: #1e293b; border-radius: 12px; overflow: hidden; border: 1px solid #334155; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);">

                    <!-- Header -->
                    <tr>
                        <td
                            style="padding: 28px 32px; background-color: #1e293b; border-bottom: 1px solid #334155; text-align: left;">
                            <span style="font-size: 20px; font-weight: 700; color: #f8fafc; letter-spacing: -0.5px;">
                                <span style="color: #38bdf8;">&lt;/&gt;</span> {{ config('app.name', 'My Tech Blog') }}
                            </span>
                        </td>
                    </tr>

                    <!-- Featured Image -->
                    @if (!empty($post->image))
                        <tr>
                            <td style="padding: 0; line-height: 0;">
                                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                                    style="width: 100%; max-height: 280px; object-fit: cover; display: block; border: 0;" />
                            </td>
                        </tr>
                    @endif

                    <!-- Body -->
                    <tr>
                        <td style="padding: 32px;">
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0"
                                style="margin-bottom: 16px;">
                                <tr>
                                    @if (!empty($post->category))
                                        <td
                                            style="background-color: rgba(56, 189, 248, 0.15); border: 1px solid #0284c7; padding: 4px 12px; border-radius: 9999px;">
                                            <span
                                                style="color: #38bdf8; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                                                {{ $post->category->name ?? 'Article' }}
                                            </span>
                                        </td>
                                    @endif
                                    <td style="padding-left: 12px; color: #94a3b8; font-size: 13px;">
                                        {{ $post->created_at ? $post->created_at->format('M d, Y') : date('M d, Y') }}
                                    </td>
                                </tr>
                            </table>

                            <h1
                                style="margin: 0 0 16px 0; font-size: 24px; line-height: 1.35; font-weight: 700; color: #f1f5f9;">
                                {{ $post->title }}
                            </h1>

                            <p style="margin: 0 0 28px 0; font-size: 15px; line-height: 1.6; color: #94a3b8;">
                                {{ Str::limit(strip_tags($post->content), 170, '...') }}
                            </p>

                            <table role="presentation" border="0" cellpadding="0" cellspacing="0"
                                style="margin-bottom: 8px;">
                                <tr>
                                    <td align="center" style="border-radius: 8px; background-color: #2563eb;">
                                        <a href="{{ url('/blog/' . $post->slug) }}" target="_blank"
                                            style="display: inline-block; padding: 13px 28px; font-size: 15px; font-weight: 600; color: #ffffff; text-decoration: none; border-radius: 8px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);">
                                            Read Full Article &rarr;
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="padding: 24px 32px; background-color: #0f172a; border-top: 1px solid #334155; text-align: center;">
                            <p style="margin: 0 0 8px 0; font-size: 13px; color: #64748b;">
                                You are receiving this email because you subscribed to updates on
                                <strong>{{ config('app.name') }}</strong>.
                            </p>
                            <p style="margin: 0; font-size: 12px; color: #475569;">
                                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>
