<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Alert !</title>
</head>

<body>
    <h1>Hello, {{ $user->name }} !</h1>

    <p>Some of your applications have remained without a response for 2 weeks now. How about you call them back ?</p>

    <p>Want to access the application's details ? Forgot to update it with your latest contact ? Just click on each company to access or edit the application</p>
    <ul>
        @foreach($applications as $application)
        <li><a href="{{ url('dashboard') }}">{{ $application->company_name }}</a></li>
        @endforeach
    </ul>
    <a href="{{ url('applications') }}">See all of my applications</a>
</body>
</html>