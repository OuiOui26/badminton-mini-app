<!-- resources/views/app.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Badminton Conductor</title>
    @vite('resources/js/app.js')
</head>
<body>
    @inertia 
</body>
</html>
