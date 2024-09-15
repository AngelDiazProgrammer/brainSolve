<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{ asset('css/general.css') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Index</h1>

<!-- En vista1.blade.php -->
<form action="{{ route('login') }}" method="GET">
    <button type="submit">Login</button>
</form>
</body>
</html>
