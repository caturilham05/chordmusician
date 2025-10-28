<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Internal Server Error</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #1a1a1a;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        .container {
            max-width: 600px;
        }

        h1 {
            font-size: 100px;
            font-weight: bold;
            background: linear-gradient(90deg, #ff007f, #a200ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        p {
            font-size: 18px;
            margin-top: 10px;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            background: #ff007f;
            border-radius: 5px;
            transition: 0.3s;
        }

        a:hover {
            background: #a200ff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>500</h1>
        <p>Oops! There is a problem on our server, please wait a moment..</p>
        <a href="{{ url('/') }}">Back to home</a>
    </div>
</body>
</html>
