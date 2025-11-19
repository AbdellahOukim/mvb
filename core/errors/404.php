<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mvb - 404</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f0f0f0;
            font-family: 'Roboto', sans-serif;
            margin: 0;
        }

        h1 {
            color: #666666ff;
            font-weight: 400;
            text-align: center;
        }

        p {
            color: #666666ff;
            text-align: center;
        }
    </style>
</head>

<body>
    <div>
        <h1> 404 Not Found</h1>
        <p> <?= $message ?? "" ?> </p>
    </div>
</body>

</html>