<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{env('APP_NAME')}}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="font-sans bg-mint-100">

<!-- Sticky Header -->
<header class="flex bg-white text-white p-4 fixed w-full top-0 z-10">
    <a class="font-bold text-xl text-gray-800" href="/"><img src="{{ asset('images/logo_trainercontainer.png') }}" class="md:h-16 h-12 w-auto mr-10" /></a>
    <nav class="container mx-auto flex justify-between items-center">
        <div class="flex-1 flex justify-center">
            <a href="{{ route('soccerdraw') }}" class=" hover:text-green-500 text-black font-bold py-2 px-4 rounded mr-4">{{__('Soccer Drawing Tool')}}</a>
        </div>
        @if (Route::has('login'))
            <div class="flex flex-wrap md:top-auto right-0 fixed px-6 py-4 sm:block items-center">
                @auth
                    <a href="{{ route('dashboard') }}" class="mt-4 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">{{__('Dashboard')}}</a>
                @else
                    <a href="{{ route('login') }}" class="mt-2 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">{{__('Login')}}</a>
                @endif
            </div>
        @endif
    </nav>
</header>

<!-- First Section with Big Image -->
<section id="home" class="bg-cover bg-center h-screen flex items-center justify-center" style="background-image: url({{ asset('images/background_header.jpg') }})">
    <div class="text-center">
        <h1 class="text-4xl font-bold text-white">{{__('Level Up Your Soccer Practices!')}}</h1>
        <a href="{{ route('register') }}">"<button id="joinNowBtn" class="mt-4 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
            {{__('Register now')}}
            </button></a>
    </div>
</section>

<!-- Highlight Section -->
<section id="about" class="container mx-auto my-8 p-4">
    <h2 class="text-2xl font-semibold text-center mb-6">{{__('Features')}}</h2>
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="text-center p-4">
            <p class="font-semibold">{{ __('Coming soon') }}: {{__('AI generated practices')}}</p>
            <!-- Add icon here -->
        </div>
        <div class="text-center p-4">
            <p class="font-semibold">{{ __('Rate your players after each session and keep track of their development.') }}</p>
            <!-- Add icon here -->
        </div>
        <div class="text-center p-4">
            <p class="font-semibold">{{ __('Easily create your practice within 5 minutes.') }}</p>
            <!-- Add icon here -->
        </div>
        <div class="text-center p-4">
            <p class="font-semibold">{{ __('Use our free soccer drawing tool to create tactics and drills.') }}</p>
            <a href="{{ route('soccerdraw') }}" class="mt-2 inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">{{__('Try Drawing Tool')}}</a>
            <!-- Add icon here -->
        </div>
    </div>
</section>

<!-- Waiting List Signup -->
<section id="signup" class="bg-green-100 p-8">
    <div class="container mx-auto text-center">
        <a href="{{ route('register') }}"><h2 class="text-2xl font-semibold mb-4">{{__('Register now')}}</h2></a>
    </div>
</section>

<!-- Footer -->
<footer class="bg-green-500 text-white p-4">
    <div class="container mx-auto text-center">
        <nav>
            <a href="{{ route('imprint') }}" class="ml-4 hover:text-green-200">{{ __('Imprint') }}</a>
        </nav>
        <!-- Social Media Icons -->
        <address class="mt-4">
            <!-- Address and Contact Info -->
        </address>
    </div>
</footer>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-0XLX9M5RC6"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-0XLX9M5RC6');
</script>
<script>
    gtag('event', 'page_view', {
        'screen_name': 'Welcome'
    })
</script>
</body>
</html>
