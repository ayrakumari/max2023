<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Theme;
use Carbon\Carbon;
use App\Category;
use App\Helpers\AyraHelp;
use Ayra\Node;
use DB;

class TeamController extends Controller
{

    //getMonthwiseOrderDetails

    public function getMonthwiseOrderDetails($uid,$month, $year)
    {
        
        $theme = Theme::uses('corex')->layout('layout');
        $users = User::orderby('id', 'desc')->get();
        $data = [
            'userID' => $uid,
            'b_month' => $month,
            'b_year' => $year,
        ];
        return $theme->scope('teams.incetive_orderDetails', $data)->render();


    }

    //getMonthwiseOrderDetails

    //viewIncentiveEligibilityPanel_History_RND
    public function viewIncentiveEligibilityPanel_History_RND($uid,$month, $incentiveType)
    {
       
        
        $theme = Theme::uses('corex')->layout('layout');
        $users = User::orderby('id', 'desc')->get();
        $data = [
            'userID' => $uid,
            'incentiveType' => $incentiveType,
            'month_view' => $month,
        ];
        $user = auth()->user();
$userRoles = $user->getRoleNames();
$user_role = $userRoles[0];

      
        if (Auth::user()->id == 1 || Auth::user()->id == 156 || Auth::user()->id == 90 ||  Auth::user()->id == 132 || $user_role=='chemist') {
            //return $theme->scope('teams.createTeamTree', $data)->render();
            // AyraHelp::setLoadIncentiveDuration();
            return $theme->scope('teams.incetiveDetailsViewDataHitory_RND', $data)->render();

            

            
        } 
    }

    //viewIncentiveEligibilityPanel_History_RND
    
    //viewIncentiveEligibilityPanel_History
    public function viewIncentiveEligibilityPanel_History($uid,$month, $incentiveType)
    {
       
        
        $theme = Theme::uses('corex')->layout('layout');
        $users = User::orderby('id', 'desc')->get();
        $data = [
            'userID' => $uid,
            'incentiveType' => $incentiveType,
            'month_view' => $month,
        ];
        if (Auth::user()->id == 1 || Auth::user()->id == 90) {
            //return $theme->scope('teams.createTeamTree', $data)->render();
            // AyraHelp::setLoadIncentiveDuration();
            if($incentiveType==1){
                return $theme->scope('teams.incetiveDetailsViewDataHitory', $data)->render();
            }
            if($incentiveType==3){//growth history
                return $theme->scope('teams.incetiveDetailsViewDataHitory_Growth', $data)->render();
            }
            if($incentiveType==4){
                return $theme->scope('teams.incetiveDetailsViewDataHitory_4', $data)->render();
            }
            if($incentiveType==5){
                return $theme->scope('teams.incetiveDetailsViewDataHitory_M_NEWSALES', $data)->render();
            }

            
        } else {
            //abort(401);
            if($incentiveType==1){
                return $theme->scope('teams.incetiveDetailsViewDataHitory', $data)->render();
            }
            if($incentiveType==4){
                return $theme->scope('teams.incetiveDetailsViewDataHitory_4', $data)->render();
            }
            if($incentiveType==5){
                return $theme->scope('teams.incetiveDetailsViewDataHitory_M_NEWSALES', $data)->render();
            }
            
        }
    }
    //viewIncentiveEligibilityPanel_History

    public function viewIncentiveEligibilityPanel($uid, $incentiveType)
    {
        $uid;
        $incentiveType;
        $theme = Theme::uses('corex')->layout('layout');
        $users = User::orderby('id', 'desc')->get();
        $data = [
            'userID' => $uid,
            'incentiveType' => $incentiveType,
        ];
        if (Auth::user()->id == 1 || Auth::user()->id == 90) {
            //return $theme->scope('teams.createTeamTree', $data)->render();
            // AyraHelp::setLoadIncentiveDuration();
            if($incentiveType==1){ //new sales
                return $theme->scope('teams.incetiveDetailsViewData', $data)->render();
            }
            if($incentiveType==3){ //growth team
                return $theme->scope('teams.incetiveDetailsViewData_growth', $data)->render();
            }

            if($incentiveType==4){ // growth manager
                return $theme->scope('teams.incetiveDetailsViewData_4', $data)->render();
            }
            if($incentiveType==5){ //new sales manager
                return $theme->scope('teams.incetiveDetailsViewData_M_NewSales', $data)->render();
            }

           

            
        } else {
            //abort(401);

            if($incentiveType==1){
                return $theme->scope('teams.incetiveDetailsViewData', $data)->render();
            }
            if($incentiveType==3){ //growth team
                return $theme->scope('teams.incetiveDetailsViewData_growth', $data)->render();
            }
            if($incentiveType==4){
                return $theme->scope('teams.incetiveDetailsViewData_4', $data)->render();
            }
            if($incentiveType==5){//manager new sales
                return $theme->scope('teams.incetiveDetailsViewData_M_NewSales', $data)->render();
            }

        }
    }
    public function viewIncentiveEligibility(Request $request)
    {
        print_r($request->all());
    }

    //setIncentiveApprovalStutus
    public function setIncentiveApprovalStutus(Request $request)
    {
        $approved_msg = $request->approved_msg;
        $approved_status = $request->approved_status;
        $incentiveCircleType = $request->incentiveCircleType;
        $incentivePayoutPercentage = $request->incentivePayoutPercentage;
        $incentiveTotalAmount = $request->incentiveTotalAmount;
        $incentiveAmount = $request->incentiveAmount;
        $incentiveUser = $request->incentiveUser;


        //amount

        $incentiveArr = DB::table('incentive_curr_duration')->where('circle_type', $incentiveCircleType)->first();
        $DurationName = $incentiveArr->name . "|" . $incentiveArr->start_date . "-" . $incentiveArr->end_date;
        $incetiveCode = $incentiveUser . $incentiveCircleType . date('dmY', strtotime($incentiveArr->start_date));


        $user = auth()->user();
        $userRoles = $user->getRoleNames();
        $user_role = $userRoles[0];
        if ($user_role == "Admin") {
            $incentiveAppr = DB::table('incentive_approval')->where('incentive_code', $incetiveCode)->whereNotNull('approved_1')->first();
            if ($incentiveAppr == null) {

                $affected = DB::table('incentive_approval')
              ->where('incentive_code', $incetiveCode)
              ->update(
                  [
                    'admin_approved' => Auth::user()->name,
                    'approved_1' => Auth::user()->id,
                    'admin_remarks' => $approved_msg,
                    'admin_approved_status' => $approved_status,
                    'admin_approved_on' => date('Y-m-d H:i:s'),
                  ]
                );

                
                
                $resp = array(
                    'status' => 1,
                    'msg' => 'Approved Success Fully'

                );
            } else {
                $resp = array(
                    'status' => 0,
                    'msg' => 'Already Approved'

                );
            }
        } else {

            $incentiveAppr = DB::table('incentive_approval')->where('incentive_code', $incetiveCode)->first();
            if ($incentiveAppr == null) {
                DB::table('incentive_approval')->insert(
                    [
                        'incentive_code' => $incetiveCode,
                        'incentive_type' => $incentiveCircleType,
                        'incentive_duration' => $DurationName,
                        'incentive_per_applied' => $incentivePayoutPercentage,
                        'amount' => $incentiveTotalAmount,
                        'incentive_amount' => $incentiveAmount,
                        'approved_by_sales_head' => Auth::user()->name,
                        'approved_2' => Auth::user()->id,
                        'remarks' => $approved_msg,
                        'status' => $approved_status,
                        'submitted_on' => date('Y-m-d H:i:s'),
    
                    ]
                );
                $resp = array(
                    'status' => 1,
                    'msg' => 'Approved Successfully'

                );

            }else{
                $resp = array(
                    'status' => 0,
                    'msg' => 'Already Approved'

                );
            }
           
        }




        return response()->json($resp);
    }
    //setIncentiveApprovalStutus
    //incentive 
    //IncentivePanel_RND
    public function IncentivePanel_RND(Request $request)
    {
        $theme = Theme::uses('corex')->layout('layout');
        $users = User::orderby('id', 'desc')->get();
        $user = auth()->user();
$userRoles = $user->getRoleNames();
$user_role = $userRoles[0];

        $data = ['users' => $users];
        if (Auth::user()->id == 1 ||Auth::user()->id==90 || Auth::user()->id==132 || $user_role='chemist') {
            //return $theme->scope('teams.createTeamTree', $data)->render();
            AyraHelp::setLoadIncentiveDuration();

            return $theme->scope('teams.incentivePanel_rnd', $data)->render();
        } else {
            abort(401);
        }
    }

    //IncentivePanel_RND


    public function IncentivePanel(Request $request)
    {
        $theme = Theme::uses('corex')->layout('layout');
        $users = User::orderby('id', 'desc')->get();
        $data = ['users' => $users];
        if (Auth::user()->id == 1 || Auth::user()->id == 90 || Auth::user()->id == 132 || Auth::user()->id == 156 || Auth::user()->id == 171 ) {
            //return $theme->scope('teams.createTeamTree', $data)->render();
            AyraHelp::setLoadIncentiveDuration();

            return $theme->scope('teams.incentivePanlel', $data)->render();
        } else {
            abort(401);
        }
    }

    public function MyIncentivePanel(Request $request)
    {
        $theme = Theme::uses('corex')->layout('layout');
        $users = User::orderby('id', 'desc')->get();
        $data = ['users' => $users];
        AyraHelp::setLoadIncentiveDuration();

        return $theme->scope('teams.MyIncentivePanlel', $data)->render();

    }


    


    //incentive 
    //getTree
    public function getTree(Request $request)
    {
        if (Auth::user()->id == 1 || Auth::user()->id == 90) {
            $roots = Category::roots()->get();
            foreach ($roots as $root)
                echo json_encode($this->renderNode($root));
        } else {
            $roots = Category::where('user_id', Auth::user()->id)->get();
            foreach ($roots as $root)
                echo json_encode($this->renderNode($root));
        }
    }
    //getTree
    public function renderNode($node)
    {

        $userURL = '/member-info/' . $node->user_id;


        $emp_arr = AyraHelp::getProfilePIC($node->user_id);

        if (!isset($emp_arr->photo)) {
            $avatarURL = asset('local/public/img/avatar.jpg');
        } else {
            $avatarURL = asset('local/public/uploads/photos') . "/" . optional($emp_arr)->photo;
        }
        $lbl = intVal($node->depth) + 1;
        $arr_data = array(
            'text' => array(
                'name' => array('val' => AyraHelp::getUser($node->user_id)->name, 'href' => $userURL),
                'Level' => "Level: " . $lbl,
                'contact' => "Phone: " . $node->phone,


            ),
            'image' => $avatarURL,
        );

        if ($node->children()->count() > 0) {

            foreach ($node->children as $child)
                $arr_data['children'][] = $this->renderNode($child);
        }
        return $arr_data;
    }
    //CreateMember
    public function CreateMember(Request $request)
    {
        $parentID = 1;
        $param_member = $request->param_member;
        $user_arr = User::where('id', $param_member)->first();
        $root = Category::where('user_id', $parentID)->first();

        $child1 = $root->children()->create([
            'name' => $user_arr->name,
            'user_id' => $user_arr->id,
            'sponsor_id' => $user_arr->id,
            'phone' => $user_arr->phone,

        ]);
        //updates user table with parent id and parent code to
        $affected = DB::table('users')
            ->where('id', $user_arr->id)
            ->update(['parent_id' => $parentID, 'parent_code' => 'AAY']);
        //create team in teams tables
        DB::table('teams')->insert(
            [
                'team_name' => $request->txtTeamName,
                'created_by' => Auth::user()->id,
                'created_at' => date('Y-m-d H:i:s'),
                'team_leader_id' => $user_arr->id,
            ]
        );
    }
    //CreateMember
    // myTeamList
    public function myTeamList()
    {
        $theme = Theme::uses('corex')->layout('layout');
        $users = User::orderby('id', 'desc')->get();
        $data = ['users' => $users];
        if (Auth::user()->id != 1 || Auth::user()->id != 90) {
            //return $theme->scope('teams.createTeamTree', $data)->render();
            return $theme->scope('teams.MyTeamList', $data)->render();
        } else {
            abort(401);
        }
    }
    // myTeamList

    // param_manager

    public function addNewteam()
    {
        $theme = Theme::uses('corex')->layout('layout');
        $users = User::orderby('id', 'desc')->get();
        $data = ['users' => $users];
        if (Auth::user()->id == 1 || Auth::user()->id == 90) {
            //return $theme->scope('teams.createTeamTree', $data)->render();
            return $theme->scope('teams.createTeamTree', $data)->render();
        } else {
            abort(401);
        }
    }

    public function boteamList()
    {
        $theme = Theme::uses('corex')->layout('layout');
        $users = User::orderby('id', 'desc')->get();
        $data = ['users' => $users];
        if (Auth::user()->id == 1 || Auth::user()->id == 90) {
            return $theme->scope('teams.teamList', $data)->render();
        } else {
            abort(401);
        }
    }
    //moveTeamMember2member
    public function moveTeamMember2member(Request $request)
    {
        $parentID = $request->selectedUseri2;
        $root = Category::where('user_id', $parentID)->first();
        $pid=$root->id;
       
         $param_member = $request->selectedUserid1;
        

        $affected = DB::table('categories')
            ->where('user_id', $param_member)
            ->update(['parent_id' => $pid]);
    }
    //moveTeamMember2member

    //setTeamMember2member
    public function setTeamMember2member(Request $request)
    {
        $parentID = $request->userid;
        $param_member = $request->selectedUserid;



        $user_arr = User::where('id', $param_member)->first();
        $root = Category::where('user_id', $parentID)->first();

        $child1 = $root->children()->create([
            'name' => $user_arr->name,
            'user_id' => $user_arr->id,
            'sponsor_id' => $user_arr->id,
            'phone' => $user_arr->phone,

        ]);
        //updates user table with parent id and parent code to
        $affected = DB::table('users')
            ->where('id', $user_arr->id)
            ->update(['parent_id' => $parentID, 'parent_code' => $user_arr->user_prefix]);
    }
    //setTeamMember2member
    private function findPosition($decendants, $position)
    {
        $i = 0;
        foreach ($decendants as $decendant) {
            if ($i == $position) {
                return $decendant;
            }
            $i++;
        }
    }

    public function getTeamMember(Request $request)
    {

        $usersList = User::where('is_deleted', 0)->orderby('id', 'desc')->where('parent_id', 1)->get();

        $data_arr_1 = array();

        foreach ($usersList as $key => $rowData) {
            $emp_arr = AyraHelp::getProfilePIC($rowData->id);
            $name = AyraHelp::getUser($rowData->id)->name;
            if (!isset($emp_arr->photo)) {
                $img_photo = asset('local/public/img/avatar.jpg');
            } else {
                $img_photo = asset('local/public/uploads/photos') . "/" . optional($emp_arr)->photo;
            }
            $teams = DB::table('teams')->where('team_leader_id', $rowData->id)->first();
            $TreamData = array();
            $node = Category::where('user_id', '=', $rowData->id)->first();

            foreach ($node->getImmediateDescendants() as $descendant) {

                //child data 
                $emp_arr = AyraHelp::getProfilePIC($descendant->user_id);
                $name1 = AyraHelp::getUser($descendant->user_id)->name;
                if (!isset($emp_arr->photo)) {
                    $img_photo1 = asset('local/public/img/avatar.jpg');
                } else {
                    $img_photo1 = asset('local/public/uploads/photos') . "/" . optional($emp_arr)->photo;
                }

                //child data 

                $TreamData[] = array(
                    'user_id' => 1,
                    'user_name' => $name1,
                    'user_photo' => $img_photo1,
                );
            }







            $data_arr_1[] = array(
                'RecordID' => $rowData->id,
                'userIMP' => $img_photo,
                'user_name' => $name,
                'teamcode' => $teams->team_name,
                'managerName' => 'Ajay',
                'teams' => $TreamData
            );
        }


        $JSON_Data = json_encode($data_arr_1);
        $columnsDefault = [
            'RecordID'     => true,
            'userIMP'     => true,
            'teamcode'     => true,
            'user_name'     => true,
            'managerName'     => true,
            'teams'     => true,

            'Actions'      => true,
        ];
        $this->DataGridResponse($JSON_Data, $columnsDefault);
    }
}
