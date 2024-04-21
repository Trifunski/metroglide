<section class="bg-white dark:bg-gray-900">
    <div class="py-8 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6 flex flex-col lg:flex-row justify-between">
        <div class="max-w-screen-md lg:w-1/2 ">
            <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Subscribe to our newsletter today.</h2>
            <p class="mb-8 font-light text-gray-500 sm:text-xl dark:text-gray-400">Join a vibrant community of sneaker enthusiasts. Get exclusive access to the latest releases and special collaborations.</p>
            <div class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
                <form class="flex flex-col sm:flex-row items-center gap-4">
                    <input type="email" class="px-4 py-2 w-full sm:w-auto bg-white text-black rounded-md" placeholder="Ingresa tu correo electrónico" size="40" />
                    <button type="submit" class="bg-black text-white px-4 py-2 hover:scale-105">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>
        <div class="flex justify-center lg:justify-end mt-8 lg:mt-0">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Sneakers" class="h-60 object-cover rounded-lg" />
        </div>
    </div>
</section>

<style>
    .bg-black {
        background-color: #000;
    }
</style>