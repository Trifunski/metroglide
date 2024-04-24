<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script>
        window.location.href = '/';
    </script>
    <title>MetroGlide</title>
</head>
<body class="bg-black overflow-x-hidden">

    <div class="flex flex-col items-center justify-center h-screen">
        <div class="flex flex-col items-center justify-center">
            <img src="{{ asset('assets/img/logo.png') }}" alt="MetroGlide Logo" class="w-32 h-32" />
            <h1 class="text-3xl text-white font-bold mt-4">JavaScript Required</h1>
            <p class="text-white text-center mt-4">This website requires JavaScript to function properly. Please enable JavaScript in your browser settings.</p>
        </div>
    </div>
    
</body>
</html>