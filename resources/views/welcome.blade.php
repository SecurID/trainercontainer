<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soccer Match Finder</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="font-sans bg-mint-100">

<!-- Sticky Header -->
<header class="flex bg-green-500 text-white p-4 fixed w-full top-0 z-10">
    <a class="font-bold text-xl text-gray-800" href="/"><img src="{{ asset('images/logo_trainercontainer.png') }}" class="h-16 w-auto mr-10" /></a>
    <nav class="container mx-auto flex justify-between items-center">
        <div>
            <a href="#home" class="font-semibold hover:text-green-200">Home</a>
            <a href="#about" class="ml-4 font-semibold hover:text-green-200">About Us</a>
            <a href="#features" class="ml-4 font-semibold hover:text-green-200">Features</a>
            <a href="#signup" class="ml-4 font-semibold hover:text-green-200">Sign Up</a>
        </div>
        @if (Route::has('login'))
            <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                    @endif
                @endif
            </div>
        @endif
    </nav>
</header>

<!-- First Section with Big Image -->
<section id="home" class="bg-cover bg-center h-screen flex items-center justify-center" style="background-image: url({{ asset('images/background_header.jpg') }})">
    <div class="text-center">
        <h1 class="text-4xl font-bold text-white">Find Your Next Match Today!</h1>
        <button id="joinNowBtn" class="mt-4 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
            Register now
        </button>
    </div>
</section>

<!-- Highlight Section -->
<section id="about" class="container mx-auto my-8 p-4">
    <h2 class="text-2xl font-semibold text-center mb-6">Why Choose Us?</h2>
    <div class="grid md:grid-cols-3 gap-4">
        <div class="text-center p-4">
            <p class="font-semibold">Easy Match Scheduling</p>
            <!-- Add icon here -->
        </div>
        <div class="text-center p-4">
            <p class="font-semibold">Connect with Fellow Coaches</p>
            <!-- Add icon here -->
        </div>
        <div class="text-center p-4">
            <p class="font-semibold">Real-Time Notifications</p>
            <!-- Add icon here -->
        </div>
    </div>
</section>

<!-- Waiting List Signup -->
<section id="signup" class="bg-green-100 p-8">
    <div class="container mx-auto text-center">
        <h2 class="text-2xl font-semibold mb-4">Be the First to Know!</h2>
        <p class="mb-4">Sign up for our waiting list and stay updated.</p>
        <form class="flex justify-center">
            <input type="email" placeholder="Enter your email" class="p-2 rounded-l">
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-r">
                Subscribe
            </button>
        </form>
    </div>
</section>

<!-- Footer -->
<footer class="bg-green-500 text-white p-4 mt-8">
    <div class="container mx-auto text-center">
        <nav>
            <a href="#privacy" class="hover:text-green-200">Privacy Policy</a>
            <a href="#terms" class="ml-4 hover:text-green-200">Terms of Service</a>
            <a href="#contact" class="ml-4 hover:text-green-200">Contact Us</a>
        </nav>
        <!-- Social Media Icons -->
        <address class="mt-4">
            <!-- Address and Contact Info -->
        </address>
    </div>
</footer>

</body>
</html>
