<?php


namespace App\Models;


use Illuminate\Support\Facades\Mail;
use Thread;

class UserCreationSender extends Thread
{

    public $phoneNumber = "";
    public $email = "";
    public $userName = "";
    public $currentCode = "";

    public function __construct($responseCode, $phoneNumber, $email, $userName)
    {
        $this->currentCode = $responseCode;
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
        $this->userName = $userName;
    }

    public function run()
    {
        self::sendSmsMessage();
        self::sendEmail();
    }

    private function sendEmail()
    {
        $to_name = $this->userName;
        $to_email = $this->email;
        $data = array('name' => "Ogbonna Vitalis(sender_name)", "body" => "A test mail");
        Mail::send('emails . mail', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject('New Registration in Shops System');
            $message->from('SENDER_EMAIL_ADDRESS', 'Test Mail');
        });
    }

    private function sendSmsMessage()
    {
        // Account details
        $apiKey = urlencode('Your apiKey');

        // Message details
        $numbers = array($this->phoneNumber);
        $sender = urlencode("Shop Api Service");
        $message = rawurlencode("Welcome Mr. " . $this->userName . " To Shop Api Service You Need To Activate Your Account With This Verification Code : " . $this->currentCode);

        $numbers = implode(',', $numbers);

        // Prepare data for POST request
        $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);

        // Send the POST request with cURL
        $ch = curl_init('https://api.textlocal.in/send/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // Process your response here
        echo $response;
    }
}
