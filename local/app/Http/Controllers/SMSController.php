<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use AWS;

class SMSController extends Controller
{
    protected function sendSMS($phone_number)
    {
        $sms = AWS::createClient('sns');

        $sms->publish([
            'Message' => 'BO Hello, This is just a test Message
                454544',
            'PhoneNumber' => $phone_number,
            'MessageAttributes' => [
                'AWS.SNS.SMS.SMSType'  => [
                    'DataType'    => 'String',
                    'StringValue' => 'Transactional',
                ]
            ],
        ]);
    }
}
