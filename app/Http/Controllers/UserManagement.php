<?php

namespace App\Http\Controllers;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Http\Request;
use App\User;
use App\UserDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RegistrationRequest;
class UserManagement extends Controller
{
    public function register()
    {
        return view('register');
    }
    public function login()
    {
        return view('index');
    }
    public function create(RegistrationRequest $request)
    {
        $v = Validator::make($request->all(), [
            'f_name' => 'required',
            'l_name' => 'required',
            'pass' => 'required',
            'email' => 'required',
            'dob' => 'required',
             'city' => 'required',
           
        ]);
        if ($v->fails()) {
        
            return redirect()->back()->withErrors($v->errors())->withInput();
        }
    
        $first_name = request('f_name');
        $last_name = request('l_name');
        $password = request('pass');
        $email = request('email');
        $dob = request('dob');
        $city = request('city');

       
       if( $email==''){
        return json_encode(array('statusCode'=>400,'msg'=>"Email not valid".$email));
    }
    else
    {
        $otp = $this->generateRandomString();
        $mail = new PHPMailer;

       $mail->SMTPDebug = 0;                               
     
       $mail->isSMTP();                              
       $mail->Host = "smtp.gmail.com";
       
       $mail->SMTPAuth = true;                          
          
       $mail->Username = "project.subina@gmail.com";                 
       $mail->Password = "project@123456789";                           
       
       $mail->SMTPSecure = "tls";                           
       
       $mail->Port = 587;                                   
       
       $mail->From = "project.subina@gmail.com";
       $mail->FromName = "Subina";
       
       $mail->addAddress($request->email, $request->f_name);
       
       $mail->isHTML(true);
       
       $mail->Subject = "Registration Successfully";
       $mail->Body = "<i>$otp is your OTP for login</i>";
       $mail->AltBody = "This is the plain text version of the email content";
       
       if(!$mail->send()) 
       {
           echo "Mailer Error: " . $mail->ErrorInfo;
       } 
       else 
       {
        session(['fname'=>$first_name]);
        session(['lname'=>$last_name ]);
        session(['pass'=>$password]);
        session(['dob'=>$dob]);
        session(['city'=> $city]);
        session(['email'=> $email]);
        session(['otp' => $otp]);

      
           return view('verification');
       }

    }
}
  
      
    
    public function verification(Request $request)
    {
        
        $otp = trim(request('otp'));
   
        if($otp == session('otp'))
        {
            $user = new User();

            $user->first_name=session('fname');
            $user->last_name=session('lname');
            $user->password=session('pass');
            $user->save();

            $user_details = new UserDetail();
            
            $user_details->email=session('email');
            
            $user_details->dob=session('dob');
           
            $user_details->city=session('city');
            
            $user_details->user_id=$user->id;
           
            $user_details->save();

            return view('index');

        }
        else
        {
            return view('resend')->with(session('fname'),session('lname'),session('email'),session('dob'),session('city'),session('pass'));
        }
       
    
}
    public  function generateRandomString() {
        $otp = mt_rand(1000,9999);
        return $otp;
    }
    public function profile()
    {
       
        return view('profile');
    }
    public function  loginCreate(Request $request)
    {
      
        $login=User::leftjoin('user_details','user_details.user_id','users.id')
        ->select('users.id','users.first_name','users.password','users.last_name','user_details.email','user_details.city','user_details.dob')
       -> where('user_details.email',$request->email)
       -> where('users.password',$request->pass)
    ->first();
   
       if($login)
        {
        
            return view('profile')->with('data',$login);
        }
        else{
            echo "Login Failed";
            return redirect()->back();

        }
    }
    public function updateProfile(Request  $request,$id)
    {
    
        $user=User::where('id',$id)
        ->Update(['first_name'=>$request->f_name,
        'last_name'=>$request->l_name,
        'password'=>\Hash::make($request->pass)
        ]);
 
        $user_details=UserDetail::where('user_id',$id)
        ->Update(['email'=>$request->email,
        'dob'=>$request->dob,
        'city'=>$request->city
        
        ]);

        $login=User::leftjoin('user_details','user_details.user_id','users.id')
        ->select('users.id','users.first_name','users.password','users.last_name','user_details.email','user_details.city','user_details.dob')
       -> where('user_details.user_id',$id)->first();
        return view('profile')->with('data',$login);;
    }
    public function logout(Request $request)
    {
        Auth::logout();
        Session::flush();
        Redirect::back();
        return view('index');
    }
}
