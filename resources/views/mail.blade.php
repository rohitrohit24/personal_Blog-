<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #333333;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        .header {
            background-color: #064e3b;
            padding: 24px 30px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            letter-spacing: 0.5px;
        }
        .body {
            padding: 30px;
        }
        .body h2 {
            margin-top: 0;
            font-size: 20px;
            color: #111827;
        }
        .body p {
            line-height: 1.6;
            color: #4b5563;
            font-size: 15px;
        }
        .btn-wrapper {
            text-align: center;
            margin: 30px 0;
        }
        .btn {
            display: inline-block;
            background-color: #059669;
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 14px;
        }
        .footer {
            background-color: #f9fafb;
            padding: 20px 30px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
        }
        .footer a {
            color: #ef4444;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Post on Our Blog</h1>
        </div>
        <div class="body">
            <h2>{{ $post->title }}</h2>
            <p>{{ Str::limit(strip_tags($post->content ?? ''), 200, '...') }}</p>
            <div class="btn-wrapper">
                <a href="{{ route('blog.show', $post->id) }}" class="btn">Read Article</a>
            </div>
        </div>
        <div class="footer">
            <p>You received this email because you subscribed to our newsletter.</p>
        </div>
    </div>
</body>
</html>
