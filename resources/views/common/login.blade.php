<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Login Page</title>

    </head>
    <body class="antialiased">
        <div>
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                        @endif
                    @endauth
                </div>
            @else
                <div>
                    <form method="POST" action="{{ route('login.validate') }}">
                        @csrf
                        <p><h2>Login</h2></p>
                        <p><input type="text" name="username" placeholder="Username"/></p>
                        <p><input type="password" name="password" placeholder="Password"/></p>
                        <p><button>Submit</button> &nbsp; <a href="{{ url('/register') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Register</a></p>
                    </form>
                </div>
            @endif
        </div>
    </body>
</html>
