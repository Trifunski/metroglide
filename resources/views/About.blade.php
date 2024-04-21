<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <title>MetroGlide</title>
</head>
<body class="bg-black">

    <x-navbar />

    <section class="sm:m-7">
        <div class="container mx-auto">
            <div class="flex justify-center items-center my-20">
                <img src="{{ asset('assets/img/banner-sneakers-1.webp') }}" alt="MetroGlide" class="rounded-lg w-full h-96 object-cover opacity-70">
                <span class="absolute text-white text-6xl font-bold">
                    "Rule the Night, Glide the Light"
                </span>
            </div>
        </div>
    </section>

    <x-carousel />

    <x-footer />
    
</body>
</html>