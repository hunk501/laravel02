<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Register Page</title>
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
            <form method="POST" action="{{ route('register.validate') }}">
              @csrf
              <p><h2>Register</h2></p>
              @if ($errors->any())
                <div>
                  <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif
              @if(session('status'))
              <div><ul><li>{{ session('status') }}</li></ul></div>
              @endif
              <p><input type="text" name="name" placeholder="Full Name"/></p>
              <p><input type="text" name="username" placeholder="Username"/></p>
              <p><input type="password" name="password" placeholder="Password"/></p>
              <p><a href="{{ url('/') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Login</a> &nbsp; <button>Submit</button></p>
            </form>
          </div>
        </div>
    </body>
</html>
