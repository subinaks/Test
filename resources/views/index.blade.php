@extends('layouts.app')
@section('content')
    <div class="main">

        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                <div class="signup-image">
                        <figure><img src="{{asset('assets/images/signup-image.jpg')}}" alt="sing up image"></figure>
                        <a href="{!! URL::to('/') !!}" class="signup-image-link"  >Create an account</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Sign In</h2>
                        <form method="POST" class="register-form" id="login-form" action="{!! URL::to('login/create') !!}" enctype="multipart/form-data">
                       
                        @csrf
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-email"></i></label>
                                <input type="email" name="email" id="your_name" placeholder="Your Email" required/>
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pass" id="your_pass" placeholder="Password" required/>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                                <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember me</label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection