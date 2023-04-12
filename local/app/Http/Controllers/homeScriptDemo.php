//SELECT order_id , subOrder ,created_by FROM `qc_forms` WHERE artwork_status=1 and order_type='Private Label' and order_repeat=1 and is_deleted=0 and dispatch_status=1 and created_by=3
        

        //SELECT order_id , subOrder , created_by from qc_forms WHERE artwork_status=1 and created_by=4 and order_type='Private Label' and order_repeat=1 

        $data_output=AyraHelp::ScriptForStartDefault();  


        // $arr_data_green=OrderMaster::where('order_statge_id','ART_WORK_RECIEVED')->where('action_status',0)->where('action_mark',0)->get();    
        // echo count($arr_data_green);



        $qc_arrs_dataA = DB::table('qc_forms')
        ->where('is_deleted',0) 
        ->where('dispatch_status',1)          
        //->where('qc_forms.artwork_status',0) 
        ->select('qc_forms.*')
        ->get();
        //echo $checkOrderMaster=AyraHelp::checkOrderMasterDataDuplicte(662,'ART_WORK_RECIEVED');
        //die;

         // echo "<pre>";
        //print_r($qc_arrs_dataA);
        //die;
        foreach ($qc_arrs_dataA as $key => $value) {
          //  print_r($value->form_id);
          //  if($value->form_id==662){
          //   echo "662";
          //   die;
          //  }
          
            //echo "<br>";
        if($value->order_type=='Bulk'){

          $checkOrderMaster=AyraHelp::checkOrderMasterDataDuplicte($value->form_id,'ART_WORK_RECIEVED');
          if($checkOrderMaster==0){
          
            $mstOrderObj=new OrderMaster;
            $mstOrderObj->form_id =$value->form_id;
            $mstOrderObj->assign_userid =0;
            $mstOrderObj->order_statge_id ='ART_WORK_RECIEVED';     
            $mstOrderObj->assigned_by =$value->created_by;
            $mstOrderObj->assigned_on =date('Y-m-d');
            $mstOrderObj->expected_date =date('Y-m-d');
            $mstOrderObj->action_status =1;
            $mstOrderObj->completed_on =date('Y-m-d');
            $mstOrderObj->action_mark =1;
            $mstOrderObj->assigned_team =2; //sales user
            //$mstOrderObj->save();   


          }
          $checkOrderMaster=AyraHelp::checkOrderMasterDataDuplicte($value->form_id,'PRODUCTION');
            if($checkOrderMaster==0){
            
              $mstOrderObj=new OrderMaster;
              $mstOrderObj->form_id =$value->form_id;
              $mstOrderObj->assign_userid =0;
              $mstOrderObj->order_statge_id ='PRODUCTION';     
              $mstOrderObj->assigned_by =$value->created_by;
              $mstOrderObj->assigned_on =date('Y-m-d');
              $mstOrderObj->expected_date =date('Y-m-d');
              $mstOrderObj->action_status =0;
              $mstOrderObj->completed_on =date('Y-m-d');
              $mstOrderObj->action_mark =1;
              $mstOrderObj->assigned_team =2; //sales user
              //$mstOrderObj->save();
            }

        }else{
           if($value->order_repeat==16){
            
            if($value->artwork_status==0){
              $checkOrderMaster=AyraHelp::checkOrderMasterDataDuplicte($value->form_id,'ART_WORK_RECIEVED');
              if($checkOrderMaster==0){              
                $mstOrderObj=new OrderMaster;
                $mstOrderObj->form_id =$value->form_id;
                $mstOrderObj->assign_userid =0;
                $mstOrderObj->order_statge_id ='ART_WORK_RECIEVED';     
                $mstOrderObj->assigned_by =$value->created_by;
                $mstOrderObj->assigned_on =date('Y-m-d');
                $mstOrderObj->expected_date =date('Y-m-d');
                $mstOrderObj->action_status =0;
                $mstOrderObj->completed_on =date('Y-m-d');
                $mstOrderObj->action_mark =1;
                $mstOrderObj->assigned_team =2; //sales user
               // $mstOrderObj->save();           

              }

            }
            

            



           }
           if($value->order_repeat==2){
          
            $checkOrderMaster=AyraHelp::checkOrderMasterDataDuplicte($value->form_id,'ART_WORK_RECIEVED');
            if($checkOrderMaster==0){          
             
              $mstOrderObj=new OrderMaster;
              $mstOrderObj->form_id =$value->form_id;
              $mstOrderObj->assign_userid =0;
              $mstOrderObj->order_statge_id ='ART_WORK_RECIEVED';     
              $mstOrderObj->assigned_by =$value->created_by;
              $mstOrderObj->assigned_on =date('Y-m-d');
              $mstOrderObj->expected_date =date('Y-m-d');
              $mstOrderObj->action_status =1;
              $mstOrderObj->completed_on =date('Y-m-d');
              $mstOrderObj->action_mark =1;
              $mstOrderObj->assigned_team =2; //sales user
              //$mstOrderObj->save();  
  
  
            }
            $checkOrderMaster=AyraHelp::checkOrderMasterDataDuplicte($value->form_id,'PURCHASE_LABEL_BOX');
            if($checkOrderMaster==0){          
              
              $mstOrderObj=new OrderMaster;
              $mstOrderObj->form_id =$value->form_id;
              $mstOrderObj->assign_userid =0;
              $mstOrderObj->order_statge_id ='PURCHASE_LABEL_BOX';     
              $mstOrderObj->assigned_by =$value->created_by;
              $mstOrderObj->assigned_on =date('Y-m-d');
              $mstOrderObj->expected_date =date('Y-m-d');
              $mstOrderObj->action_status =0;
              $mstOrderObj->completed_on =date('Y-m-d');
              $mstOrderObj->action_mark =1;
              $mstOrderObj->assigned_team =2; //sales user
              //$mstOrderObj->save();
            }

          }

        }
        
        


        

        }
        //die;

        // $qc_arrs = DB::table('order_master')
        // ->join('qc_forms', 'order_master.form_id', '=', 'qc_forms.form_id')
        // ->where('order_master.order_statge_id','ART_WORK_RECIEVED')    
        // ->where('order_master.action_status',0)    
        // ->where('order_master.action_mark',0)    
        // ->where('qc_forms.is_deleted',0)  
        // ->select('qc_forms.*')
        // ->get();
        // echo "<pre>";
        // $exp=array();
        // foreach ($qc_arrs as $key => $qc_arr) {
            
        //   if($qc_arr->form_id==$value->form_id){

        //   }else{
        //     $exp[]=$value->form_id;
        //   }
        // }
        

        // $arr_datas = DB::table('order_master')
        // ->join('qc_forms', 'order_master.form_id', '=', 'qc_forms.form_id')
        // ->where('order_master.order_statge_id','ART_WORK_RECIEVED')    
        // ->where('order_master.action_status',0)               
        // ->where('qc_forms.is_deleted',0)  
        // ->where('qc_forms.dispatch_status',1)  
        // ->where('qc_forms.created_by',Auth::user()->id)  
        // ->select('order_master.*')
        // ->get();

       // print_r(count($arr_datas));
        //die;

      // $arr_data_green=QCFORM::where('is_deleted',0)->where('dispatch_status',1)->get();    
      // echo '<pre>';
      // print_r(count($arr_data_green));

       // $mystatus=AyraHelp::completePreviousStageDone(5,11);


      //    die;

        //QCFORM::query()->truncate();
        //QCBOM::query()->truncate();
        //QC_BOM_Purchase::query()->truncate();
        //QCPP::query()->truncate();

        //OrderMaster::query()->truncate();        
        //OPData::query()->truncate();
      //  echo "<pre>";
      //   $qcboms=QCBOM::where('form_id',1)->whereNotNull('m_name')->get();
      //   print_r($qcboms);
      //   die;
      //  echo "<pre>";
      //   $qc_data_arr=AyraHelp::getPendingPurchaseStages();
      //   print_r($qc_data_arr);
      //   die;

        


       //$data_output=AyraHelp::AScriptForOrderUpdateOrder();
          //die;
        // $data_output=AyraHelp::getStuckAtStage(1,1);
        // echo "<pre>";
        // print_r($data_output);
        // die;
        
      //   $sms = AWS::createClient('sns');
      //   $otp ='555';

     
      //   $data_sms= $sms->publish([
      //     'Message' => $otp.' OTP for Bo  Access Requested from"',
      //     'PhoneNumber' => '917703886088',    
      //     'MessageAttributes' => [
      //         'AWS.SNS.SMS.SMSType'  => [
      //             'DataType'    => 'String',
      //             'StringValue' => 'Transactional',
      //         ]
      //     ],
      // ]);

     
      //AyraHelp::getBOMScript();
    

        // $qc_arr=QCFORM::get();
        // //vode
        // foreach ($qc_arr as $key => $qc_form) {
        
        // $formID=$qc_form->form_id;
        // $fomr_id=$formID;
        // //saveBOM
        // // $qcBOMObj=new QCBOM;
        // // $qcBOMObj->m_name='';
        // // $qcBOMObj->qty='';
        // // $qcBOMObj->size='';
        // // $qcBOMObj->form_id=$formID;     
        // // $qcBOMObj->save(); 

        // //save order prcess
        // $qcPPObj=new QCPP;
        // $qcPPObj->qc_label='FILLING';
        // $qcPPObj->qc_yes='YES';
        // $qcPPObj->qc_no='';  
        // $qcPPObj->qc_from_id=$fomr_id;  
        // $qcPPObj->save();

        // $qcPPObj=new QCPP;
        // $qcPPObj->qc_label='SEAL';
        // $qcPPObj->qc_yes='YES';
        // $qcPPObj->qc_no='';  
        // $qcPPObj->qc_from_id=$fomr_id;  
        // $qcPPObj->save();

        // $qcPPObj=new QCPP;
        // $qcPPObj->qc_label='CAPPING';
        // $qcPPObj->qc_yes='YES';
        // $qcPPObj->qc_no='';  
        // $qcPPObj->qc_from_id=$fomr_id;  
        // $qcPPObj->save();

        // $qcPPObj=new QCPP;
        // $qcPPObj->qc_label='LABEL';
        // $qcPPObj->qc_yes='YES';
        // $qcPPObj->qc_no='';  
        // $qcPPObj->qc_from_id=$fomr_id;  
        // $qcPPObj->save();


        // $qcPPObj=new QCPP;
        // $qcPPObj->qc_label='CODING ON LABEL';
        // $qcPPObj->qc_yes='YES';
        // $qcPPObj->qc_no='';  
        // $qcPPObj->qc_from_id=$fomr_id;  
        // $qcPPObj->save();

        // $qcPPObj=new QCPP;
        // $qcPPObj->qc_label='BOXING';
        // $qcPPObj->qc_yes='YES';
        // $qcPPObj->qc_no='';  
        // $qcPPObj->qc_from_id=$fomr_id;  
        // $qcPPObj->save();

        // $qcPPObj=new QCPP;
        // $qcPPObj->qc_label='CODING ON BOX';
        // $qcPPObj->qc_yes='YES';
        // $qcPPObj->qc_no='';  
        // $qcPPObj->qc_from_id=$fomr_id;  
        // $qcPPObj->save();

        // $qcPPObj=new QCPP;
        // $qcPPObj->qc_label='SHRINK WRAP';
        // $qcPPObj->qc_yes='YES';
        // $qcPPObj->qc_no='';  
        // $qcPPObj->qc_from_id=$fomr_id;  
        // $qcPPObj->save();


        // $qcPPObj=new QCPP;
        // $qcPPObj->qc_label='CARTONIZE';
        // $qcPPObj->qc_yes='YES';
        // $qcPPObj->qc_no='';  
        // $qcPPObj->qc_from_id=$fomr_id;  
        // $qcPPObj->save();
        


        

        //save order prcess




        //}
        //vode
        //die;