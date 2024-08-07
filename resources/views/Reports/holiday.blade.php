<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plano de Férias</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background-color: #fff;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .user-info,
        .vacation-info {
            margin-bottom: 20px;
        }

        .user-info p,
        .vacation-info p {
            margin: 5px 0;
        }

        .label {
            font-weight: bold;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Vacation Plan</h1>

        <div class="user-info">
            <h2>User information</h2>
            <p><span class="label">Name:</span> {{ $data['user']->name }}</p>
            <p><span class="label">E-mail:</span> {{ $data['user']->email }}</p>
        </div>

        <div class="vacation-info">
            <h2>Vacation details</h2>
            <p><span class="label">Title:</span> {{ $data['holiday']->title }}</p>
            <p><span class="label">Description:</span> {{ $data['holiday']->description }}</p>
            <p><span class="label">Date:</span> {{ $data['holiday']->date }}</p>
            <p><span class="label">Location:</span> {{ $data['holiday']->location }}</p>
        </div>
    </div>
</body>

</html>
