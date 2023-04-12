<?php

namespace App\Imports;

use App\RawClientDataSampleAttendance;
use App\Client;
use App\Sample;
use App\Item;
use App\ItemStock;
use App\ItemCat;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Auth;
use App\User;
use DB;
use Session;
use App\Helpers\AyraHelp;
use Maatwebsite\Excel\Concerns\ToModel;
use Mail;

class ItemImportAttendance implements ToModel
{

    public function model(array $row)
    {



        if (!empty(array_filter($row))) {
            $containsm = Str::contains($row[0], 'Punch');
            if ($containsm) {

                $row_data = explode(":", $row[0]);
                $year = $row_data[0];
                $row_data_month = explode("/", $row_data[1]);
                $month = $row_data_month[0];
                Session::put('month', $month);
                Session::put('year', $year);
            }

            if (!$containsm) {
                if (in_array(1, $row)) {
                    //DB::table('demo_attn')->where('id',  $rowData->id)->delete();
                } else {
                    $year = Session::get('year');
                    $month = Session::get('month');

                    DB::table('demo_attn')->insert(
                        [
                            'attn_key' => 'data',
                            'atten_month' => $month,
                            'atten_yr' => $year,
                            'attn_value' => json_encode($row)
                        ]
                    );
                }
            }
        }
    }


    public function model__(array $row)
    {

        $off_email = $row[8];


        $user_arr = DB::table('users')->where('email', $off_email)->first();
        if ($user_arr == null) {

            // create user account with profile
            //  $json = file_get_contents('http://postalpincode.in/api/pincode/'.$row[5]);
            //  $obj = json_decode($json);
            //  $obj->PostOffice[0]->State;        



            DB::table('hrm_emp')->insert(
                [
                    'emp_code' => '5454',
                    'name' => $row[0],
                    'email' => $row[1],
                    'phone' => $row[2],
                    'dob' =>  $row[3],
                    'gender' => $row[4],
                    'pincode' =>  $row[5],
                    'address' => $row[6],
                    // 'city' => $obj->PostOffice[0]->District,
                    // 'state' => $obj->PostOffice[0]->State,
                    'doj' => $row[7],
                    'comp_email' => $row[8],
                    'pan_card' =>  $row[9],
                    'aadhar_card' => $row[10]
                ]
            );

            $ps = 'boerp@123';

            $users = User::create([
                'name' => $row[0],
                'email' => $row[8],
                'password' => $ps,
            ]);
            // $users->sendEmailVerificationNotification();
            $users->assignRole('User');


            //send email
            //     $subLine='Bo ERP| Login Information';                   
            //     $data = array(
            //      'email'=>$row[0] ,
            //      'password'=>$ps 
            //    );
            //    $txtEmail='bointldev@gmail.com';

            //    Mail::send('boerp', $data, function($message) use ($txtEmail,$subLine) {

            //       $message->to($txtEmail, 'Bo Internatinal')->subject
            //          ($subLine);

            //          $message->from('ajayit2020@gmail.com','MAX');
            //    });
            //send email





        } else {
            //update profile

        }
    }
}
