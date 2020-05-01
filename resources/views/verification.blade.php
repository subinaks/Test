@extends('layouts.app')
@section('content')
    <div class="main">

        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
             

                    <div class="signin-form">
                       
                        <form method="POST" class="register-form" id="login-form" action="{!! URL::to('verification/otp') !!}"  enctype="multipart/form-data">
                           {{ csrf_field() }}     <div class="form-group">
                           <span>An OTP sent to  your email</i></span><br>
                                <input type="text" name="otp" id="otp" placeholder="Enter OTP"/>
                               
                            </div>
                         
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="verify"/>
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