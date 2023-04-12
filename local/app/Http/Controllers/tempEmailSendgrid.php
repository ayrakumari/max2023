require 'vendor/autoload.php';
    // $Apikey="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";
    $Apikey = "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";

    
$email = new \SendGrid\Mail\Mail();
      $email->setFrom("info@max.net", "MAX");
      $email->setSubject("Private Label Skincare Products and Essential Oils");
      $email->addTo($sent_toEmail, $senderName);
      $email->setReplyTo('pooja@max.net', 'info@max.net');
      $email->addBcc('bointldev@gmail.com', $senderName);

      //$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
      $body = file_get_contents('bo_email.html');
      $customNumber = $senderName;
      $body = str_replace('{{--customNumber--}}', $customNumber, $body);
      $body = str_replace('{{--QUERY_ID--}}', $rows->QUERY_ID, $body);

      $email->addContent(
        "text/html",
        $body
      );

      //$file_encoded = base64_encode('a1.pdf');
      $file_encoded = base64_encode(file_get_contents('Bo_International_Cosmetic_Products.pdf'));

      $email->addAttachment(
        $file_encoded,
        "application/pdf",
        "MAX Cosmetic Products.pdf",
        "attachment"
      );
      $file_encoded = base64_encode(file_get_contents('Bo_International_Essential_Oils.pdf'));
      $email->addAttachment(
        $file_encoded,
        "application/pdf",
        "MAX_Essential Oils.pdf",
        "attachment"
      );

      // $file_encoded = base64_encode('bo_International_profile.pdf');
      // $email->addAttachment(
      //    $file_encoded,
      //    "application/pdf",
      //    "bo_International_profile.pdf",
      //    "attachment"
      // );

      $sendgrid = new \SendGrid($Apikey);
      try {
        $response = $sendgrid->send($email);
        //print $response->statusCode() . "\n";
        //print_r($response->headers());
        //print $response->body() . "\n";
        $affected = DB::table('indmt_data')
          ->where('QUERY_ID', $rows->QUERY_ID)
          ->update(['email_sent' => 1]);
        //sms





        //sms


      } catch (Exception $e) {
        echo 'Caught exception: ' . $e->getMessage() . "\n";
      }

