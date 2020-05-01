<!DOCTYPE html>
<html lang="en">
@extends('layouts.app')
@section('content')
    <div class="main">

        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Profile</h2>
                   
                        <form method="POST" class="register-form" action="{!! URL::to('profile/update/'.$data->id) !!}" id="register-form"  enctype="multipart/form-data">
                        {{ csrf_field() }}
                  
                            <div class="form-group">
                                <label for="fname"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="f_name" id="fname" placeholder="Your First  Name" value="{{$data->first_name}}"/>
                            </div>
                            <div class="form-group">
                                <label for="lname"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="l_name" id="lname" placeholder="Your Last Name" value="{{$data->last_name}}" />
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Your Email" value="{{$data->email}}"/>
                            </div>
                            <div class="form-group">
                                <label for="city"><i class="zmdi  zmdi-city"></i></label>
                                <input type="text" name="city" id="city" placeholder="Your City" value="{{$data->city}}"/>
                            </div>
                            <div class="form-group">
                                <label for="dob"><i class="zmdi  zmdi-calendar"></i></label>
                                <input type="date" name="dob" id="dob" placeholder="Your Date of birth" value="{{$data->dob}}"/>
                            </div>

                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pass" id="pass" placeholder="Password" />
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="re_pass" id="re_pass" placeholder="Repeat your password" />
                            </div>
   
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit"  onclick="return Validate()" value="Update"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                  <h2>  <a href="{!! URL::to('logout') !!}" class="zmdi zmdi-power"></a></h2>
                        <figure><img src="{{asset('assets/images/signup-image.jpg')}}" alt="sing up image"></figure>
                     
                    </div>
                </div>
            </div>

        </section>

    

    </div>

    <!-- JS -->
    
    
    <script type="text/javascript">
    function Validate() {
        var password = document.getElementById("pass").value;
        var confirmPassword = document.getElementById("re_pass").value;
        if (password != confirmPassword) {
            alert("Passwords do not match.");
            return false;
        }
        return true;
    }
</script>
@endsection