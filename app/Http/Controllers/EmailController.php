<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Email;
use App\Models\Client;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmailMailable;
use Mews\Purifier\Facades\Purifier;

class EmailController extends Controller
{
     /*
     Display the list of users and the email sending form
     -----------------------------------------------------------------------------------------------------
    */

   public function index()
   {
       // Get all sent emails, or you can apply pagination if needed
       /*$emails = Email::all(); 

       return view('emails.index', compact('emails')); 
*/

       $data['emails']=Email::select('emails.*')
                                ->orderBy('emails.created_at', 'desc')
                                ->get();
                               
        return view('emails.index',$data);
   }
    /*
     Create emails
     -----------------------------------------------------------------------------------------------------
    */

    // Display the form for creating emails
    public function create()
    {
        // Get all users with an email
        $clients = Client::whereNotNull('email_address')->get();

        // Return the create view with the list of users
        return view('emails.create', compact('clients'));
    }

    /*
     Send emails to the users  $message = Purifier::clean($request->input('message'));
     -----------------------------------------------------------------------------------------------------
    */
      public function sendEmailsToUsers(Request $request)
        {
            $request->validate([
                'subject' => 'required|string',
                'message' => 'required|string',
                'recipient_type' => 'required|string',
                'recipient_id' => 'nullable|numeric',
            ]);

            $subject = $request->input('subject');
            $rawMessage = $request->input('message'); // Original message with HTML
            $cleanedMessage = strip_tags($rawMessage); // Remove all HTML tags
            $message = "Greetings,\n\n" . $cleanedMessage . "\n\nWarm Regards,\nTechdev Systems";

            $sender = env('MAIL_USERNAME', 'TDS'); // Default sender

            // Base email data for saving in the database
            $baseEmailData = [
                'subject' => $subject,
                'message' => $message, // Use the cleaned message
                'sender' => $sender,
                'status' => 'failed', // Default status
            ];

            $recipientType = $request->input('recipient_type');
            $recipientId = $request->input('recipient_id');

            // Handle sending emails based on recipient type
            if ($recipientType === 'individual') {
                $client = Client::find($recipientId);
                if ($client) {
                    try {
                        Mail::to($client->email_address)->send(new SendEmailMailable($subject, $message));
                        // Update email data for successful send
                        $emailData = $baseEmailData;
                        $emailData['recipient'] = $client->email_address;
                        $emailData['status'] = 'sent';
                        Email::create($emailData); // Save to database
                    } catch (\Exception $e) {
                        // Log error and save as failed
                        $emailData = $baseEmailData;
                        $emailData['recipient'] = $client->email_address;
                        Email::create($emailData);
                        \Log::error("Failed to send email to: {$client->email_address}. Error: {$e->getMessage()}");
                    }
                }
            } elseif ($recipientType === 'group') {
                // Implement group email logic if needed
            } elseif ($recipientType === 'all') {
                $clients = Client::whereNotNull('email_address')->get();
                foreach ($clients as $client) {
                    try {
                        Mail::to($client->email_address)->send(new SendEmailMailable($subject, $message));
                        // Update email data for successful send
                        $emailData = $baseEmailData;
                        $emailData['recipient'] = $client->email_address;
                        $emailData['status'] = 'sent';
                        Email::create($emailData); // Save to database
                    } catch (\Exception $e) {
                        // Log error and save as failed
                        $emailData = $baseEmailData;
                        $emailData['recipient'] = $client->email_address;
                        Email::create($emailData);
                        \Log::error("Failed to send email to: {$client->email_address}. Error: {$e->getMessage()}");
                    }
                }
            }

            return redirect()->route('emails.index')->with('success', 'Emails sent successfully!');
        }


    /*
    Retrieve Individual Emails
    ---------------------------------------------------------------------------------------------------
    */

       public function show($id)
        {
            // Retrieve member details
            $data['emails'] = Email::select('emails.*')
                                    ->where('emails.id', '=', $id)
                                    ->first();


            return view('emails.show', $data);
        }

}
