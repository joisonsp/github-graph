<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tech Challenge</title>
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

</head>

<body>
    <div id="first-step">
        <h1>First step</h1>
        @if (Route::has('login'))
            <div id="button_git"class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                @auth
                    <h3> You`re Logged in </h3>
                @else
                    <x-primary-button-link class="ml-4" id="log-in" href="/auth/redirect">
                        {{ __('Log in with Github') }}
                    </x-primary-button-link>
                @endauth
            </div>
        @endif

    </div>
    <div id="second-step">
        <h1>Second step</h1>
        <h3>Repositories list</h3>
        <h6>Select a repository</h6>
        <select id="list-repo">
        </select>
    </div>
    <div id="third-step">
        <h1>Third step</h1>
        <p> See your graph here! </p>
        <canvas id="myChart"></canvas>
    </div>
</body>
<script>
    var username = '<?php echo session('username'); ?>'
    console.log(username);
</script>
<script src="{{ URL::asset('js/index.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>


</html>
