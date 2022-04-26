<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{config('app.name','Acacia')}}</title>
    <x-core::css-header/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.0.2/tailwind.min.css">
</head>
<body>

<!-- Section 1 -->
<section class="h-screen w-full px-3 antialiased bg-gray-800 text-primary lg:px-6">
    <div class="mx-auto max-w-7xl">
        <nav class="flex items-center w-full h-24 select-none" x-data="{ showMenu: false }">
            <div class="relative flex flex-wrap items-center justify-between w-full h-24 mx-auto font-medium md:justify-center">
                <x-core::logo/>
                <div class="fixed top-0 left-0 z-40 items-center hidden w-full h-full p-3 text-xl bg-gray-900 bg-opacity-50 md:text-sm lg:text-base md:w-3/4 md:bg-transparent md:p-0 md:relative md:flex" :class="{'flex': showMenu, 'hidden': !showMenu }">
                    <div class="flex-col w-full h-auto h-full overflow-hidden bg-white rounded-lg select-none md:bg-transparent md:rounded-none md:relative md:flex md:flex-row md:overflow-auto">
                        <div class="flex flex-col items-center justify-center w-full h-full mt-12 text-center text-primary md:text-indigo-200 md:w-2/3 md:mt-0 md:flex-row md:items-center">
                            <a href="{{route('dashboard')}}" class="inline-block px-4 py-2 mx-2 font-medium text-left text-indigo-700 md:text-white md:px-0 lg:mx-3 md:text-center">Dashboard</a>
                            <a href="{{route('acacia.backend.index')}}" class="inline-block px-0 px-4 py-2 mx-2 font-medium text-left md:px-0 hover:text-indigo-800 md:hover:text-white lg:mx-3 md:text-center">Backend</a>
                            <a href="#" class="inline-block px-0 px-4 py-2 mx-2 font-medium text-left md:px-0 hover:text-indigo-800 md:hover:text-white lg:mx-3 md:text-center">Contact</a>
                        </div>
                        <div class="flex flex-col items-center justify-end w-full h-full pt-4 md:w-1/3 md:flex-row md:py-0">
                            <a href="{{route('register')}}" class="w-full pl-6 mr-0 text-primary hover:text-white md:pl-0 md:mr-3 lg:mr-5 md:w-auto">Register</a>
                            <a href="{{route('login')}}" class="inline-flex items-center justify-center px-4 py-2 mr-1 text-base font-medium leading-6 whitespace-no-wrap transition duration-150 ease-in-out bg-primary border border-transparent rounded-full hover:bg-white focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700">Login</a>

                        </div>
                    </div>
                </div>
                <div @click="showMenu = !showMenu" class="absolute right-0 z-50 flex flex-col items-end w-10 h-10 p-2 mr-4 rounded-full cursor-pointer md:hidden hover:bg-gray-900 hover:bg-opacity-10" :class="{ 'text-gray-400': showMenu, 'text-gray-100': !showMenu }">
                    <svg class="w-6 h-6" x-show="!showMenu" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" x-cloak="">
                        <path d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg class="w-6 h-6" x-show="showMenu" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" x-cloak="">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
            </div>
        </nav>
        <div class="container py-32 mx-auto text-center sm:px-4">

            <h1 class="text-4xl font-extrabold leading-10 tracking-tight text-white sm:text-5xl sm:leading-none md:text-6xl xl:text-7xl"><span class="block">{{config('app.name')}}</span>
                <span class="relative inline-block mt-3 text-primary">Frontend</span></h1>
            <div class="max-w-lg mx-auto my-6 text-sm text-center text-indigo-200 md:mt-12 sm:text-base md:max-w-xl md:text-lg xl:text-xl">Your tagline can never be worse.</div>
            <a href="{{route('dashboard')}}" class="text-center rounded-full bg-gray-900 text-white font-black text-lg p-3 px-4 mt-4">
                Get Started
            </a>
            <div class="mt-8 text-sm text-indigo-300">By signing up, you agree to our terms and services.</div>
        </div>
    </div>
</section>

<!-- AlpineJS Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.8.0/alpine.js"></script>

</body>
</html>
