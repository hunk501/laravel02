<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Login Page</title>
        <style>
            html,
            body,
            .container {
            height: 100%;
            overflow: hidden;
            }

            .container {
            display: flex;
            justify-content: center;
            }

            #object {
            height: 300px;
            width: 500px;
            align-self: center;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="container">
            <div id="object">
                <form method="POST" action="{{ route('login.validate') }}">
                    @csrf
                    <p><h2>Login</h2></p>
                    @if ($errors->any())
                        <div>
                            <ul>
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <p><input type="text" name="username" placeholder="Username"/></p>
                    <p><input type="password" name="password" placeholder="Password"/></p>
                    <p><button>Submit</button> &nbsp; <a href="{{ url('/register') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Register</a></p>
                </form>
            </div>
        </div>
    </body>
</html>
