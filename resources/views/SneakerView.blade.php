<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script type="module" src="{{ asset('assets/js/views/sneaker.js') }}"></script>
    <title>MetroGlide</title>
</head>
<body class="bg-black">
    
    <x-navbar />

    <section class="text-white body-font overflow-hidden">

        <div class="container px-5 py-24 mx-auto">
            <div class="lg:w-4/5 mx-auto flex justify-between">
            <img id="sneakerImage" class="lg:w-1/2 w-full lg:h-auto h-64 object-cover object-center rounded" src="">
            <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                <h2 id="brandName" class="text-3xl font-bold title-font tracking-widest"></h2>
                <h1 id="sneakerName" class="text-3xl title-font font-bold mb-1"></h1>
                <p id="sneakerDescription" class="leading-relaxed"></p>
                <div class="flex mt-6 items-center pb-5 border-b-2 border-gray-100 mb-5">
                    <div class="flex items-center w-full justify-between">
                        <div class="flex items-center">
                            <span class="mr-3">Size</span>
                            <select id="sizeList" class="rounded border appearance-none py-2 focus:outline-none focus:ring-2 focus:ring-white text-black pl-3 pr-10">
                                
                            </select>
                        </div>
                        <span id="sneakerQuantity" class="flex items-center">
                            
                        </span>
                    </div>
                </div>
                <div class="flex justify-between">
                    
                    <span id="sneakerPrice" class="title-font font-medium text-2xl"></span>

                    @if (session()->has('token'))
                        @if (strtotime(session()->get('token_expired_at')) > strtotime(date('Y-m-d H:i:s')))
                            <button id="addToCart" class="bg-white font-semibold text-black px-4 py-2 rounded-md hover:bg-black hover:text-white hover:ring hover:ring-white transition duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2">
                                Add Cart
                            </button>
                        @else
                            <a href="/login">
                                <button class="bg-white font-semibold text-black px-4 py-2 rounded-md hover:bg-black hover:text-white hover:ring hover:ring-white transition duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2">
                                    Add Cart
                                </button>
                            </a>
                        @endif
                    @else
                        <a href="/login">
                            <button class="bg-white font-semibold text-black px-4 py-2 rounded-md hover:bg-black hover:text-white hover:ring hover:ring-white transition duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2">
                                Add Cart
                            </button>
                        </a>
                    @endif
                    
                </div>
            </div>
            </div>
        </div>
    </section>

    <x-carousel />

    <x-footer />

</body>
</html>
