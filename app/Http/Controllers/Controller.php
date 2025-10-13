<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use Bouncer;
use Session;
use URL;
use Auth;
use DB;
//use Mail;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Role;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function role_abilities($id){

        return Role::select('abilities.name','abilities.entity_type')
                ->join('permissions','permissions.entity_id','=','roles.id')
                ->join('abilities','abilities.id','=','permissions.ability_id')
                ->where('roles.id','=',$id)
                ->get();

    }

   

    public static function can_model($model,$action,$space){


      $abilities=self::role_abilities($space->id);

      $checked="";

      foreach ($abilities as $ability) {

        /*if($ability->entity_type=="App\\".$model && ($ability->name==$action || $ability->name=="*" )){
          $checked="checked";
        }*/


       if($ability->name==$action.'_'.$model){
          $checked="checked";
        }


      }
       return $checked;      

    }

    public static function has_ability($ability){

        if(Bouncer::cannot($ability)){    
           Session::flash('alert-danger', 'You are not allowed');
           abort(back());           
        }       

    }

    public static function uploadFile($request){

        

         if($file = $request->file('thefile')){
       
          
          $destinationPath = '../uploads';

          $thefile=$file->move($destinationPath,time().$file->getClientOriginalName());

          return $thefile;
         }else{

            return 1;
         }

     }


     public static function upload_img($file){       

          
          $destinationPath = 'uploads';

          $path=$file->move($destinationPath,time().$file->getClientOriginalName());

          return $path;
        
     }

    public static function send_mail($from,$from_name,$to,$subject,$msg){

        $data = array( 'to' =>$to, 'subject' => $subject, 'from' =>$from,'from_name' =>$from_name);

          Mail::raw($msg, function($message)use ($data)
                  {
                    $message->from($data['from'],$data['from_name']);

                    $message->to($data['to'])->subject($data['subject']);
                  });

        if (Mail::failures()) return false; else return true;
        
    }

        /* Mail Option two*/
/*       public static function send_mails($from, $from_name, $to, $subject, $msg)
{
    // Validate email addresses
    if (!filter_var($from, FILTER_VALIDATE_EMAIL)) {
        Log::error('Invalid from email address: ' . $from);
        return false;
    }

    if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
        Log::error('Invalid to email address: ' . $to);
        return false;
    }

    try {
        // Prepare email data
        $data = [
            'to' => $to,
            'subject' => $subject,
            'from' => $from,
            'from_name' => $from_name,
            'msg' => $msg
        ];

        // Send the email
        Mail::send([], [], function ($message) use ($data) {
            $message->from($data['from'], $data['from_name'])
                    ->to($data['to'])
                    ->subject($data['subject'])
                    ->setBody($data['msg'], 'text/html');
        });

        return true; // Success
    } catch (\Exception $e) {
        // Log the error
        Log::error('Mail sending failed: ' . $e->getMessage());
        return false; // Failure
    }
}*/
       
       public static function send_mails($from_name, $to, $subject, $msg)
{
    // Get the 'from' address from the environment
    $from = env('MAIL_FROM_ADDRESS');

    // Validate email addresses
    if (!filter_var($from, FILTER_VALIDATE_EMAIL)) {
        Log::error('Invalid from email address in .env: ' . $from);
        return false;
    }

    if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
        Log::error('Invalid recipient email address: ' . $to);
        return false;
    }

    try {
        // Prepare email data
        $data = [
            'to' => $to,
            'subject' => $subject,
            'from' => $from,
            'from_name' => $from_name,
            'msg' => $msg
        ];

        // Send the email
        Mail::send([], [], function ($message) use ($data) {
            $message->from($data['from'], $data['from_name']) // Use env('MAIL_FROM_ADDRESS')
                    ->to($data['to'])
                    ->subject($data['subject'])
                    ->setBody($data['msg'], 'text/html'); // HTML email body
        });

        return true; // Success
    } catch (\Exception $e) {
        // Log the error
        Log::error('Mail sending failed: ' . $e->getMessage());
        return false; // Failure
    }
} 


    public static function send_sms($number,$msg){
        
            //require_once('AfricasTalkingGateway.php');

            $username   = "wnn";
            $apikey     = "trtt55";

            $recipients = $number;
            $message    = $msg;

            $gateway    = new AfricasTalkingGateway($username, $apikey);
            
                try 
                { 
                                  
                  $results = $gateway->sendMessage($recipients, $message);
                  
                 /* foreach($results as $result) {
                    //echo " Number: " .$result->number;
                    echo " Status: " .$result->status."<br>";
                    //echo " MessageId: " .$result->messageId;
                    //echo " Cost: "   .$result->cost."<br>";
                  }*/

                  return $results; 
                 
                }
                catch ( AfricasTalkingGatewayException $e )
                {
                  $error="Encountered an error while sending: ".$e->getMessage();
                  return $error;
                }
        
                
                
    }

    public static function age($dob){

      if($dob=="")return "";

      else  return floor((time() - strtotime($dob)) / 31556926);      

    }
}
