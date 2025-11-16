<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found | MVB</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --text: #1a202c;
            --text-light: #718096;
            --border: #e2e8f0;
            --bg: #f7fafc;
            --white: #ffffff;
            --error: #e53e3e;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg);
            color: var(--text);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
        }

        .error-container {
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        .error-code {
            font-size: 6rem;
            font-weight: 700;
            color: var(--text-light);
            line-height: 1;
            margin-bottom: 1rem;
        }

        .error-title {
            font-size: 1.875rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--text);
        }

        .error-message {
            font-size: 1.125rem;
            color: var(--text-light);
            margin-bottom: 2rem;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 0.375rem;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #3182ce;
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: #2c5aa0;
        }

        .btn-secondary {
            background-color: var(--white);
            color: var(--text);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background-color: var(--bg);
        }

        .logo {
            position: absolute;
            top: 2rem;
            left: 2rem;
            font-weight: 600;
            font-size: 1.25rem;
            color: var(--text);
        }

        @media (max-width: 640px) {
            .error-code {
                font-size: 4rem;
            }

            .error-title {
                font-size: 1.5rem;
            }

            .action-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 200px;
            }
        }
    </style>
</head>

<body>
    <div class="logo">2R Technolgy mvb </div>

    <div class="error-container">
        <div class="error-code">404</div>
        <h1 class="error-title">Not Fount </h1>
        <p class="error-message">
            <?= $error ?? " Not just found " ?>
        </p>

        <div class="action-buttons">
            <a href="/" class="btn btn-primary">Documentation</a>
        </div>
    </div>
</body>

</html>