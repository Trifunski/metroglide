<section class="bg-black py-20">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-start">
            <div class="w-1/4 bg-black border-y p-5 rounded-lg">
                <h2 class="text-white text-lg font-semibold mb-4">Filters</h2>
                <div class="mb-4">
                    <div id="accordion-flush-brands" data-accordion="collapse" data-active-classes="text-gray-900" data-inactive-classes="text-gray-500">
                        <h2 id="accordion-flush-heading-1">
                            <button type="button" class="flex items-center justify-between w-full py-5 font-medium rtl:text-right text-white border-b gap-3" data-accordion-target="#accordion-flush-body-1" aria-expanded="false" aria-controls="accordion-flush-body-1">
                                <span>Brands</span>
                                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                                </svg>
                            </button>
                        </h2>
                        <div id="accordion-flush-body-1" class="hidden" aria-labelledby="accordion-flush-heading-1">
                            <div class="py-5 border-b">
                                <label for="nike" class="block text-gray-300 mb-2">
                                    <input type="checkbox" id="nike" class="mr-2">
                                    Nike
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <div id="accordion-flush-size" data-accordion="collapse" data-active-classes="text-gray-900" data-inactive-classes="text-gray-500">
                        <h2 id="accordion-flush-heading-2">
                            <button type="button" class="flex items-center justify-between w-full py-5 font-medium rtl:text-right text-white border-b gap-3" data-accordion-target="#accordion-flush-body-2" aria-expanded="false" aria-controls="accordion-flush-body-2">
                                <span>Sizes</span>
                                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                                </svg>
                            </button>
                        </h2>
                        <div id="accordion-flush-body-2" class="hidden" aria-labelledby="accordion-flush-heading-2">
                            <div class="flex flex-wrap py-5 border-b">
                                <div class="w-1/2 sm:w-1/4 lg:w-1/6 mb-2">
                                    <label for="size-36" class="block text-gray-300">
                                        <input type="checkbox" id="size-36" class="mr-2">
                                        36
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <div id="accordion-flush-price" data-accordion="collapse" data-active-classes="text-gray-900" data-inactive-classes="text-gray-500">
                        <h2 id="accordion-flush-heading-3">
                            <button type="button" class="flex items-center justify-between w-full py-5 font-medium rtl:text-right text-white border-b gap-3" data-accordion-target="#accordion-flush-body-3" aria-expanded="false" aria-controls="accordion-flush-body-3">
                                <span>Price</span>
                                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                                </svg>
                            </button>
                        </h2>
                        <div id="accordion-flush-body-3" class="hidden" aria-labelledby="accordion-flush-heading-3">
                            <div class="py-5 border-b">
                                <label for="price-0-100" class="block text-gray-300 mb-2">
                                    <input type="checkbox" id="price-0-100" class="mr-2">
                                    $0 - $100
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <button id="filterButton" class="bg-white font-semibold text-black mt-2 px-4 py-2 rounded-md hover:bg-black hover:text-white hover:ring hover:ring-white transition duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2">Apply Filters</button>
            </div>
            <div class="w-3/4 pl-5">
                <div class="grid grid-cols-3 gap-5 cursor-pointer" id="sneakersContainer">
                    <noscript>
                        <div class="text-white text-center">Please enable JavaScript to view the sneakers.</div>
                    </noscript>
                    
                </div>
            </div>
        </div>
    </div>
</section> 
