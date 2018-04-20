<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Gamepad API</title>
</head>

<body>
<div id="app">
    <p>Press a button to activate your game controller.</p>
    <ball></ball>
</div>
<script src="js/app.js"></script>
</body>

</html>