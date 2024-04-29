<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @vite('resources/css/app.css')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
        <script type="module" src="{{ asset('assets/js/views/login.js') }}" defer></script>
        <title>Login / Metroglide</title>
    </head>
    <body class="bg-black text-white">

        <a href="/"><button class="fixed top-4 right-4 bg-white font-semibold text-black px-4 py-2 rounded-md hover:bg-black hover:text-white hover:ring hover:ring-white transition duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2">Volver</button></a>
    
        <section class="bg-black text-white flex min-h-screen flex-col items-center pt-16 sm:justify-center sm:pt-0">
            <a href="#">
                <div class="text-foreground font-semibold text-2xl tracking-tighter mx-auto flex items-center gap-2">
                    Metroglide
                </div>
            </a>
            <div class="relative mt-12 w-full max-w-lg sm:mt-10">
                <div class="mx-5 border dark:border-b-white/50 dark:border-t-white/50 border-b-white/20 sm:border-t-white/20 rounded-lg border-white/20 border-l-white/20 border-r-white/20 sm:shadow-sm lg:rounded-xl lg:shadow-none">
                    <div class="flex flex-col p-6">
                        <h3 class="text-xl font-semibold leading-6 tracking-tighter">Login</h3>
                        <p class="mt-1.5 text-sm font-medium text-white/50">Welcome back, enter your credentials to continue.
                        </p>
                    </div>
                    <div class="p-6 pt-0">
                        <form id="loginForm">
                            <div class="group relative rounded-lg border focus-within:border-sky-200 px-3 pb-1.5 pt-2.5 duration-200 focus-within:ring focus-within:ring-sky-300/30">
                                <div class="flex justify-between">
                                    <label class="text-xs font-medium text-muted-foreground group-focus-within:text-white text-gray-400">Email</label>
                                </div>
                                <input type="email" id="email" autocomplete="off" class="block w-full border-0 bg-transparent p-1 text-sm file:my-1 file:rounded-full file:border-0 file:bg-accent file:px-4 file:py-2 file:font-medium placeholder:text-muted-foreground/90 focus:outline-none focus:ring-0 sm:leading-7">
                            </div>
                            <div class="mt-4">
                                <div>
                                    <div class="group relative rounded-lg border focus-within:border-sky-200 px-3 pb-1.5 pt-2.5 duration-200 focus-within:ring focus-within:ring-sky-300/30">
                                        <div class="flex justify-between">
                                            <label class="text-xs font-medium text-muted-foreground group-focus-within:text-white text-gray-400">Password</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="password" id="password" class="block w-full border-0 bg-transparent p-1 text-sm file:my-1 placeholder:text-muted-foreground/90 focus:outline-none focus:ring-0 focus:ring-teal-500 sm:leading-7 text-foreground">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-10 flex items-center justify-end gap-x-2">
                                <button class="font-semibold hover:bg-black hover:text-white hover:ring hover:ring-white transition duration-300 inline-flex items-center justify-center rounded-md text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-white text-black h-10 px-4 py-2" type="submit">Log in</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        
    </body>
</html>