<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="{{ asset('assets\css\bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('assets\css\candidate_logincss.css') }}" rel="stylesheet">
    <script src="{{ asset('assets\js\jquery-3.5.1.slim.min.js')}}"></script>
    <script src="{{ asset('assets\js\popper.min.js')}}"></script>
    <script src="{{ asset('assets\js\bootstrap.min.js')}}"></script>
</head>
<body class="auth-page">
    <div class="auth-card">
        <div class="card">
            <div class="card-body">
                <div class="auth-brand">
                    <p class="brand-subtitle">Sign in to start your session</p>
                </div>

                <form action="candidate_login" method="post" class="auth-form">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-label">User ID</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="User_Id" required>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    </div>



                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </form>

                @if ($message = Session::get('msg'))
                    <div class="alert alert-danger auth-alert">{{ $message }}</div>
                @endif

                @if (count($errors) > 0)
                    <div class="alert alert-danger auth-alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{!! $error !!}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>