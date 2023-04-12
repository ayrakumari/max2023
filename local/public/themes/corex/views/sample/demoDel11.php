$samplePrintCat = $request->samplePrintCat;


    $print_sample_date = $request->print_sample_date;
    $today = date('Y-m-d');
    $to = \Carbon\Carbon::createFromFormat('Y-m-d', $print_sample_date);
    $from = \Carbon\Carbon::createFromFormat('Y-m-d', $today);
    $diff_in_days = $from->diffInDays($to);
    $date = \Carbon\Carbon::today()->subDays($diff_in_days);

    $theme = Theme::uses('corex')->layout('layout');
    $max_id = Sample::max('sample_index') + 1;
    $user = auth()->user();
    $userRoles = $user->getRoleNames();
    $user_role = $userRoles[0];
    if ($user_role == 'Admin' || $user_role == 'Sampler' ||  $user_role == 'CourierTrk' || $user_role == 'SalesHead' || Auth::user()->id == 146 || Auth::user()->id == 124) {

      switch ($samplePrintCat) {
        case 1:
          $sample_arr = Sample::where('status', 1)->where('is_deleted',0)->where('sample_type', 1)->where('created_at', '>=', $date)->get();

          break;
        case 2:
          $sample_arr = Sample::where('status', 1)->where('is_deleted',0)->where('sample_type', 2)->where('created_at', '>=', $date)->get();

          break;
        case 3:
          $sample_arr = Sample::where('status', 1)->where('is_deleted',0)->where('sample_type', 3)->where('created_at', '>=', $date)->get();

          break;
        case 4:
          $sample_arr = Sample::where('status', 1)->where('is_deleted',0)->where('sample_type', 4)->where('created_at', '>=', $date)->get();

          break;
        case 5:
          $sample_arr = Sample::where('status', 1)->where('is_deleted',0)->where('sample_type', 5)->where('created_at', '>=', $date)->get();

          break;
        case 6:
          $sample_arr = Sample::where('status', 1)->where('is_deleted',0)->where('created_at', '>=', $date)->get();
          break;
      }

      if (count($sample_arr) <= 0) {
        // return redirect()->route('qcform.list');
        $sample_search = date("d,F Y", strtotime($to));
        return redirect('/')->with('status', 'No sample found from ' . $sample_search);
      }
    } else {
      if ($user_role == 'SalesUser') {
        $sample_arr = Sample::where('status', 1)->where('created_by', Auth::user()->id)->where('created_at', '>=', $date)->get();
        if (count($sample_arr) <= 0) {
          // return redirect()->route('qcform.list');
          $sample_search = date("d,F Y", strtotime($to));
          return redirect('/')->with('status', 'No sample found from ' . $sample_search);
        }
      } else {
        $sample_arr = DB::table('samples')
          ->join('users_access', function ($join) {
            $join->on('samples.client_id', '=', 'users_access.client_id');
            $join->on('users_access.access_by', '=', 'samples.created_by');
          })
          ->select('samples.*')
          ->orderBy('samples.id', 'DESC')
          ->orwhere('users_access.access_to', Auth::user()->id)
          ->where('samples.status', 1)
          ->get();
      }
    }
    foreach ($sample_arr as $key => $value) {

      $users = Client::where('id', $value->client_id)->first();

      $client_data = AyraHelp::getClientbyid($value->client_id);
      if ($value->created_at != null) {
        $sample_created = date("d,F Y", strtotime($value->created_at));
      } else {
        $sample_created = '';
      }
      $cname = isset($client_data->firstname) ? $client_data->firstname : "";
      $cbran = isset($client_data->company) ? $client_data->company : "";


      $sample_data[] = array(
        'sample_code' => $value->sample_code,
        'client_name' => $cname . "(" . $cbran . ")",
        'client_phone' => optional($users)->phone,
        'client_address' => optional($value)->ship_address,
        'client_company' => optional($users)->company,
        'sample_created' => $sample_created,
        'sample_remarks' => optional($value)->remarks,
        'sample_details' => json_decode(optional($value)->sample_details),
      );
    }

    $data = [
      'users' => '$users',
      'sample_id' => $max_id,
      'sample_data' => $sample_data
    ];