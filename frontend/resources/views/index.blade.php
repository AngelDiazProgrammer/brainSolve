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
<nav id="barra_superior">
    <form action="{{ route('login') }}" method="GET">
        <button type="submit">Login</button>
    </form>
    <button type="submit">Quienes somos</button>
    <button type="submit">Allowed</button>
</nav>
<h1>Index</h1>
<div class="grid grid-cols-3 gap-7">

	<!-- Each <div> is a single column.
	Place some content inside to see the effect. -->
	<div>
        <h1>Index</h1>
    </div>

	<div>
        <h1>Index</h1>
    </div>

	<div>
        <h1>Index</h1>
    </div>

</div>

</body>
</html>
