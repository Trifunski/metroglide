<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script type="module" src="{{ asset('assets/js/views/filter.js') }}" defer></script>
    <noscript>
        <meta http-equiv="refresh" content="0; url=/required">
    </noscript>
    <title>MetroGlide</title>
</head>
<body class="bg-black overflow-x-hidden">

    <x-navbar />

    <x-filter />

    <x-footer />
    
</body>
</html>