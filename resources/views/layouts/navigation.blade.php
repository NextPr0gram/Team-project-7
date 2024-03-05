{{-- Secondary nav bar on top of the header --}}
{{-- <nav class="flex justify-end items-center px-4 mx-auto h-9 text-base max-w-8xl sm:px-6 lg:px-8">
    <a class="pr-2" href="">Store locator</a>
    <div class="w-1 h-5 bg-bluish-purple"></div>
    <a class="pl-2" href="">Help</a>
</nav> --}}

{{-- Main header --}}
<nav x-data="{ open: false, showMenu: false, showCart: false}" class="text-base border-b border-gray-100 max-h bg- dark:bg-gray-800 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="px-4 mx-auto max-w-8xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block mx-2 h-9" />

                    </a>
                </div>



                {{-- <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                        {{ __('Dashboard') }}
                </x-nav- .0> --}}
            </div>

            {{-- right side nav-items account, wishlist, cart buttons...--}}
            <div class="flex flex-grow justify-end {{-- md:justify-between --}} items-center">

                {{-- Searchbar --}}
                <form class="flex px-0 my-auto md:px-8" method="GET" action="{{ route('search') }}">
                    <x-text-input name="search" class="hidden w-full md:block"></x-text-input>
                    <button class="flex-none px-2" type="submit">
                        <img src="{{asset('icons/utility/search-icon-dark.svg')}}" alt="">
                    </button>

                </form>



                {{-- account dropdown button with icon and text --}}
                <div class="flex items-center">
                    {{-- Account button mobile--}}
                    <button @click="open = ! open" title="Account" class="flex flex-shrink-0 items-center px-2 sm:hidden text-bluish-purple">
                        @auth
                        <div class="hidden pr-2 text-base md:block">{{ Auth::user()->name }}</div>
                        @else
                        <div class="hidden pr-2 text-base md:block">Account</div>
                        @endauth

                        <img src="{{asset('icons/utility/account-icon-dark.svg')}}" alt="">
                    </button>
                    {{-- Account button--}}
                    <x-dropdown align="right" width="48" class="">

                        <x-slot name="trigger">
                            <button class="hidden items-center pr-2 text-base sm:inline-flex text-bluish-purple hover:underline">
                                @auth
                                <div class="px-1 text-bluish-purple">{{ Auth::user()->name }}</div>
                                @else
                                <div class="px-1 text-base text-bluish-purple">Account</div>
                                @endauth
                                <img src="{{asset('icons/utility/account-icon-dark.svg')}}" alt="">

                                {{-- dropdown icon, uncomment to show--}}
                                {{-- <div class="ms-1">
                                    <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div> --}}
                            </button>
                        </x-slot>




                        <x-slot name="content">
                            @auth
                            <!-- Show profile and logout for authenticated users -->
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('profile.orders')">
                                {{ __('Orders') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                            @else
                            <!-- Show login and register for guests (not authenticated users) -->
                            <x-dropdown-link :href="route('login')">
                                {{ __('Login') }}
                            </x-dropdown-link>

                            @if (Route::has('register'))
                            <x-dropdown-link :href="route('register')">
                                {{ __('Register') }}
                            </x-dropdown-link>
                            @endif
                            @endauth
                        </x-slot>

                    </x-dropdown>

                    <div x-data="{ showMenu : false }" class="relative">

                        {{-- Button to Toggle the Wishlist Dropdown --}}
                        <button @click="showMenu = !showMenu" title="Wishlist" class="flex-none px-2">
                            <img src="{{asset('icons/utility/wishlist-icon-dark.svg')}}" alt="">
                        </button>

                        {{-- Mobile Dark Overlay for Remaining 2/12 of the Width --}}
                        <div x-show="showMenu" class="sm:hidden fixed inset-0 bg-default-black opacity-50"></div>

                        {{-- Mobile and Desktop Dropdown Menu --}}
                        <div x-show="showMenu" x-transition:enter="transform transition-transform ease-in-out duration-500" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition-transform ease-in-out duration-500" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="sm:hidden fixed h-screen w-10/12 top-0 right-0 pt-3 rounded-md shadow-md border border-solid border-neutral-30 bg-default-white md:flex md:flex-col md:right-20 md:w-96 md:h-auto md:mt-16 md:gap-3 md:rounded-lg z-40">

                            {{-- Wishlist Title Section --}}
                            <div class="flex flex-grow justify-between py-4 px-4 items-center self-stretch text-neutral-900">
                                <h3 class="font-formula1 text-lg not-italic font-medium leading-5 md:flex md:mx-auto">Wishlist</h3>

                                {{-- Button to Close the Mobile Wishlist --}}
                                <button @click="showMenu = false" class="md:hidden">
                                    <img src="{{ asset('icons/utility/cancel-icon.svg') }}" class="w-8 h-8" alt="">
                                </button>
                            </div>

                            {{-- Wishlist Items Container --}}
                            <div class="px-4 pb-6">

                                {{-- Wishlist Item 1 Container --}}
                                <div class="flex flex-col py-4 border-b-2 stroke-2 border-neutral-30">
                                    {{-- Item 1 Left Container --}}
                                    <div class="flex items-center justify-between">
                                        <img src="#" alt="" class="w-20 h-20 shrink-0 bg-primary-75 rounded-sm">

                                        <div class="flex flex-col font-lexend text-sm not-italic leading-4 w-8/12 pl-4 text-neutral-900">
                                            <p class="font-bold pb-2">Item Name</p>
                                            <p class="font-normal">£ 24.99</p>
                                        </div>

                                        {{-- Item 1 Right Container--}}
                                        <div class="flex flex-col items-end">
                                            <button class="group">
                                                <img src="{{ asset('icons/utility/heart-default.svg') }}" class="w-6 h-5 group-hover:hidden" alt="Like Button">
                                                <img src="{{ asset('icons/utility/heart-hover.svg') }}" class="w-6 h-5 group-hover:block hidden" alt="Like Button Hover">
                                            </button>
                                            <x-secondary-button class="font-lexend text-sm not-italic font-normal leading-4 mt-5 h-10 w-32 text-primary-300">Add to cart</x-secondary-button>
                                        </div>
                                    </div>
                                </div>

                                {{-- Wishlist Item 2 Container--}}
                                <div class="flex flex-col py-4 border-b-2 stroke-2 border-neutral-30">

                                    {{-- Item 2 Left Container--}}
                                    <div class="flex items-center justify-between">
                                        <img src="#" alt="" class="w-20 h-20 shrink-0 bg-primary-75 rounded-sm">

                                        <div class="flex flex-col font-lexend text-sm not-italic leading-4 pl-4 w-8/12 text-neutral-900">
                                            <p class="font-bold pb-2">Item Name</p>
                                            <p class="font-normal">£ 24.99</p>
                                        </div>

                                        {{-- Item 2 Right Container--}}
                                        <div class="flex flex-col items-end">
                                            <button class="group">
                                                <img src="{{ asset('icons/utility/heart-default.svg') }}" class="w-6 h-5 group-hover:hidden" alt="Like Button">
                                                <img src="{{ asset('icons/utility/heart-hover.svg') }}" class="w-6 h-5 group-hover:block hidden" alt="Like Button Hover">
                                            </button>
                                            <x-secondary-button class="font-lexend text-sm not-italic font-normal leading-4 mt-5 h-10 w-32 text-primary-300">Add to cart</x-secondary-button>
                                        </div>
                                    </div>
                                </div>

                                {{-- Wishlist Item 3 Container--}}
                                <div class="pt-4">
                                    {{-- Item 3 Left Container--}}
                                    <div class="flex items-center justify-between">
                                        <img src="#" alt="" class="w-20 h-20 shrink-0 bg-primary-75 rounded-sm">

                                        <div class="flex flex-col font-lexend text-sm not-italic leading-4 pl-4 w-8/12 text-neutral-900">
                                            <p class="font-bold pb-2">Item Name</p>
                                            <p class="font-normal">£ 24.99</p>
                                        </div>

                                        {{-- Item 3 Right Container--}}
                                        <div class="flex flex-col items-end">
                                            <button class="group">
                                                <img src="{{ asset('icons/utility/heart-default.svg') }}" class="w-6 h-5 group-hover:hidden" alt="Like Button">
                                                <img src="{{ asset('icons/utility/heart-hover.svg') }}" class="w-6 h-5 group-hover:block hidden" alt="Like Button Hover">
                                            </button>
                                            <x-secondary-button class="font-lexend text-sm not-italic font-normal leading-4 mt-5 h-10 w-32 text-primary-300">Add to cart</x-secondary-button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-center underline text-neutral-100 pb-4">
                                <a href="{{ route('wishlist') }}" class="font-lexend text-sm not-italic font-normal leading-4">View all items</a>
                            </div>
                        </div>
                    </div>

                    <!-- <div x-data="{ showMenu : false }" class="relative">

                        {{-- Button to Toggle the Basket Dropdown and Slide --}}
                        <button @click="showMenu = !showMenu" title="Wishlist" class="flex-none px-2">
                            <img src="{{asset('icons/utility/wishlist-icon-dark.svg')}}" alt="Wishlist button">
                        </button>

                        {{-- Mobile Dark Overlay for Remaining 2/12 of the Width --}}
                        <div x-show="showMenu" class="sm:hidden fixed inset-0 bg-default-black opacity-50"></div>

                        {{-- Mobile and Desktop Dropdown Menu --}}
                        <div x-show="showMenu" x-transition:enter="transform transition-transform ease-in-out duration-500" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition-transform ease-in-out duration-500" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="sm:hidden fixed h-screen w-10/12 top-0 right-0 pt-3 rounded-md shadow-md border border-solid border-neutral-30 bg-default-white md:flex md:flex-col md:right-20 md:w-96 md:h-auto md:mt-16 md:gap-3 md:rounded-lg z-40">

                            {{-- Basket Title Section --}}
                            <div class="flex flex-grow justify-between py-4 px-4 items-center self-stretch text-neutral-900">
                                <h3 class="font-formula1 text-lg not-italic font-medium leading-5 md:flex md:mx-auto">Basket</h3>

                                {{-- Button to Close the Mobile Basket --}}
                                <button @click="showMenu = false" class="md:hidden">
                                    <img src="{{ asset('icons/utility/cancel-icon.svg') }}" class="w-8 h-8" alt="">
                                </button>
                            </div>

                            {{-- Basket Items Container --}}
                            <div class="px-4 pb-6">

                                {{-- Basket Item 1 Container --}}
                                <div class="flex justify-between py-4 border-b-2 stroke-2 border-neutral-30">

                                    {{-- Left Container --}}
                                    <div class="flex items-center">
                                        <img src="#" alt="" class="w-20 h-20 shrink-0 bg-primary-75 rounded-sm">

                                        <div class="flex flex-col font-lexend text-sm not-italic leading-4 pl-4 text-neutral-900">
                                            <p class="font-bold pb-2">Item Name</p>
                                            <p class="font-normal">£ 24.99</p>
                                        </div>
                                    </div>

                                    {{-- Right Container--}}
                                    <div class="flex items-center">
                                        <div class="grid grid-cols-3 items-center border border-1 border-neutral-100 rounded-md px-3 py-0.5">
                                            <img src="{{ asset('icons/utility/minus-symbol.png') }}" class="" alt="">
                                            <p class="px-2 border-1 border-r border-l border-neutral-30">0</p>
                                            <img src="{{ asset('icons/utility/plus-symbol.png') }}" class="pl-3" alt="">

                                        </div>
                                    </div>

                                    <div class="flex items-center">
                                        <button>
                                            <img src="{{ asset('icons/utility/bin-icon.png') }}" class="w-5 h-5" alt="">
                                        </button>

                                    </div>
                                </div>

                                {{-- Basket Item 2 Container --}}
                                <div class="flex justify-between py-4 border-b-2 stroke-2 border-neutral-30">

                                    {{-- Left Container --}}
                                    <div class="flex items-center">
                                        <img src="#" alt="" class="w-20 h-20 shrink-0 bg-primary-75 rounded-sm">

                                        <div class="flex flex-col font-lexend text-sm not-italic leading-4 pl-4 text-neutral-900">
                                            <p class="font-bold pb-2">Item Name</p>
                                            <p class="font-normal">£ 24.99</p>
                                        </div>
                                    </div>

                                    {{-- Right Container--}}
                                    <div class="flex items-center">
                                        <div class="grid grid-cols-3 items-center border border-1 border-neutral-100 rounded-md px-3 py-0.5">
                                            <img src="{{ asset('icons/utility/minus-symbol.png') }}" class="" alt="">
                                            <p class="px-2 border-1 border-r border-l border-neutral-30">0</p>
                                            <img src="{{ asset('icons/utility/plus-symbol.png') }}" class="pl-3" alt="">

                                        </div>
                                    </div>

                                    <div class="flex items-center">
                                        <button>
                                            <img src="{{ asset('icons/utility/bin-icon.png') }}" class="w-5 h-5" alt="">
                                        </button>

                                    </div>
                                </div>

                                {{-- Basket Item 3 Container --}}
                                <div class="flex justify-between pt-4"> border-b-2 stroke-2 border-neutral-30

                    {{-- Left Container --}}
                    <div class="flex items-center">
                        <img src="#" alt="" class="w-20 h-20 shrink-0 bg-primary-75 rounded-sm">

                        <div class="flex flex-col font-lexend text-sm not-italic leading-4 pl-4 text-neutral-900">
                            <p class="font-bold pb-2">Item Name</p>
                            <p class="font-normal">£ 24.99</p>
                        </div>
                    </div>

                    {{-- Right Container--}}
                    <div class="flex items-center">
                        <div class="grid grid-cols-3 items-center border border-1 border-neutral-100 rounded-md px-3 py-0.5">
                            <img src="{{ asset('icons/utility/minus-symbol.png') }}" class="" alt="">
                            <p class="px-2 border-1 border-r border-l border-neutral-30">0</p>
                            <img src="{{ asset('icons/utility/plus-symbol.png') }}" class="pl-3" alt="">

                        </div>
                    </div>

                    <div class="flex items-center">
                        <button>
                            <img src="{{ asset('icons/utility/bin-icon.png') }}" class="w-5 h-5" alt="">
                        </button>

                    </div>
                </div>

            </div>

            <div class="flex items-center justify-center underline text-neutral-100 pb-4">
                <a href="{{ route('wishlist') }}" class="font-lexend text-sm not-italic font-normal leading-4">View all items</a>
            </div>
        </div>
    </div> -->

                    {{-- Shopping cart button --}}
                    <a href="{{ route('basket.show') }}" class="flex-none px-2">
                        <img src="{{asset('icons/utility/shopping-cart-dark.svg')}}" alt="">
                    </a>

                    {{-- Checkout button --}}
                    <a href="{{ route('checkout') }}"><x-secondary-button title="Checkout" class="hidden flex-shrink-0 mx-2 md:block">
                            Checkout
                        </x-secondary-button></a>
                </div>

            </div>


            <!-- Hamburger -->
            {{-- <div class="flex items-center -me-2 sm:hidden">
                <button @click="open = ! open" class="inline-flex justify-center items-center p-2 text-gray-400 rounded-md transition duration-150 ease-in-out dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div> --}}
        </div>
    </div>
    <div x-show="showMenu" @click.away="showMenu = false" class="mt-2 md:hidden">
        <a href="#" class="block px-4 py-2 text-white hover:bg-gray-700">Home</a>
        <a href="#" class="block px-4 py-2 text-white hover:bg-gray-700">About</a>
        <a href="#" class="block px-4 py-2 text-white hover:bg-gray-700">Services</a>
        <a href="#" class="block px-4 py-2 text-white hover:bg-gray-700">Contact</a>
    </div>

    <!-- Responsive account navigation menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden overflow-hidden transition-all duration-300 ease-in-out sm:hidden">
        {{-- <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
        </x-responsive-nav-link>
    </div> --}}

    <!-- Responsive Settings Options -->
    <div class="pt-4 pb-1 border-gray-200 dark:border-gray-600">
        @auth
        <div class="px-4">
            <div class="text-base font-medium text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
            <div class="text-base font-medium text-gray-500">{{ Auth::user()->email }}</div>
        </div>
        @endauth
        <div class="mt-3 space-y-1">
            @auth
            <x-responsive-nav-link :href="route('profile.edit')">
                {{ __('Profile') }}
            </x-responsive-nav-link>

            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>
            @else
            <x-responsive-nav-link :href="route('login')">
                Login
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('register')">
                Register
            </x-responsive-nav-link>
            @endauth
        </div>
    </div>
    </div>
</nav>

{{-- Secondary nav bar at the bottom of the header --}}
<div class="bg-navy-blue font-lexend-deca">
    <nav class="flex justify-center items-center h-9 text-base">
        <a class="flex items-center px-3 h-full transition-all duration-150 ease-in-out sm:px-10 text-snow-white hover:border-b-4" href="{{ route('hoodies') }}">Hoodies</a>
        <a class="flex items-center px-3 h-full transition-all duration-150 ease-in-out sm:px-10 text-snow-white hover:border-b-4" href="{{ route('tshirts') }}">T-Shirts</a>
        <a class="flex items-center px-3 h-full transition-all duration-150 ease-in-out sm:px-10 text-snow-white hover:border-b-4" href="{{ route('trousers') }}">Trousers</a>
        <a class="flex items-center px-3 h-full transition-all duration-150 ease-in-out sm:px-10 text-snow-white hover:border-b-4" href="{{ route('jackets') }}">Jackets</a>
        <a class="flex items-center px-3 h-full transition-all duration-150 ease-in-out sm:px-10 text-snow-white hover:border-b-4" href="{{ route('accessories') }}">Accessories</a>
    </nav>
</div>