$users = DB::table('indmt_data')->where('SENDEREMAIL', '!=', '')->where('created_at', '>=', '2020-09-01')->where('email_sent', 0)->where('duplicate_lead_status', 0)->get();

    //$users = DB::table('indmt_data')->where('QUERY_ID','1433740647')->get();
    foreach ($users as $key => $rows) {


      //  $sent_toEmail='bointldev@gmail.com';

      $senderName = ucwords($rows->SENDERNAME);
      // $phone = substr($rows->MOB, -10);
      //email
      $sent_to = $rows->SENDEREMAIL;
      $subLine = "Private Label Skincare Products and Essential Oils";
      $data = array(
        'QUERY_ID' => $rows->QUERY_ID,
        'customNumber' => $senderName

      );
      Mail::send('bo_email_bulk', $data, function ($message) use ($sent_to, $senderName, $subLine) {

        $message->to($sent_to, $senderName)->subject($subLine);
        $message->attach('http://demo.local/Bo_International_Cosmetic_Products.pdf');
        $message->attach('http://demo.local/Bo_International_Essential_Oils.pdf');
        //  $message->cc($use_data->email, $use_data->name = null);
        //$message->bcc('bointldev@gmail.com', 'Ajay Kumar');
        
        $message->from('info@max.net', 'MAX')
        ->replyTo('pooja@max.net', 'Pooja Gupta');
      });
      $affected = DB::table('indmt_data')
        ->where('QUERY_ID', $rows->QUERY_ID)
        ->update(['email_sent' => 1]);
     // sms


      //email

    }




    echo "email sent";
  }