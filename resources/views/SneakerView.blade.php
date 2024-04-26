<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script type="module" src="{{ asset('assets/js/views/sneaker.js') }}" defer></script>
    <title>MetroGlide</title>
</head>
<body class="bg-black">
    
    <x-navbar />

    <section class="text-white body-font overflow-hidden">

        <div class="container px-5 py-24 mx-auto" id="sneakerContainer">
            
        </div>
    </section>

    <x-carousel />

    <x-footer />

</body>
</html>
