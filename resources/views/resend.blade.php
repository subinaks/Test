@extends('layouts.app')
@section('content')
    <div class="main">

        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
             

                    <div class="signin-form">
                       
                        <form method="POST" class="register-form" id="login-form" action="{!! URL::to('register/create') !!}"  enctype="multipart/form-data">
                        @csrf   <div class="form-group">
                                <span>OTP does not match, Please try again</i></span>
                                <input type="hidden" name="f_name" id="fname" value="{{session('fname')}}"/>
                                <input type="hidden" name="l_name" id="l_name" value="{{session('lname')}}"/>
                                <input type="hidden" name="email" id="email" value="{{session('email')}}"/>
                                <input type="hidden" name="dob" id="dob" value="{{session('dob')}}"/>
                                <input type="hidden" name="city" id="city" value="{{session('city')}}"/>
                                <input type="hidden" name="pass" id="pass" value="{{session('pass')}}"/>
                                
                      
                            </div>
                         
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Resend OTP"/>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </section>

    </div>
 
    <!-- JS -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
    
        @if (session('message'))
    
        @endif

    </script>
  
@endsection