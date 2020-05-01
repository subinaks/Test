<?php

namespace App\Http\Controllers;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Http\Request;
use App\User;
use App\UserDetail;
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
            'email' => 'required|unique:user_details',
            'dob' => 'required',
             'city' => 'required',
           
        ]);
        if ($v->fails()) {
        
            return redirect()->back()->withErrors($v->errors())->withInput();
        }
    
       $user=User::firstOrCreate(['first_name'=>$request->f_name,
       'last_name'=>$request->l_name,
       'password'=>\Hash::make($request->pass)
       ]);

       $user_details=UserDetail::firstOrCreate(['email'=>$request->email,
       'dob'=>$request->dob,
       'city'=>$request->city,
       'user_id'=>$user->id
       ]);
       $keycode = $this->generateRandomString(6);

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
       $mail->Body = "<i>$keycode is your OTP for login</i>";
       $mail->AltBody = "This is the plain text version of the email content";
       
       if(!$mail->send()) 
       {
           echo "Mailer Error: " . $mail->ErrorInfo;
       } 
       else 
       {
           echo "An otp sent to your email";
           return view('verification')->with('otp', $keycode);
       }
       
    
     

      
    }
    public function verification(Request $request)
    {
      
     
         $keycode=$request->otp_value;
        $otp=$request->otp;

        if( $keycode==$otp)
        {
            return view('index');

        }
        else
        {
            echo "OTP is not match please, try again";
            return view('verification')->with('otp', $keycode);
        }
       
    }
    public  function generateRandomString($length = 20) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function profile()
    {
       
        return view('profile');
    }
    public function  loginCreate(Request  $request)
    {
        $login=User::leftjoin('user_details','user_details.user_id','users.id')
        ->select('users.id','users.first_name','users.password','users.last_name','user_details.email','user_details.city','user_details.dob')
       -> where('user_details.email',$request->email)->first();
   
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
}
