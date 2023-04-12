<!-- main  -->
<div class="m-content">
    <?php
    $user_id = Request::segment(2);


    $chemistLimitArr = DB::table('sample_assigned_list')
        ->where('user_id', $user_id)
        ->first();
    $chemistAssingedArr_1 = DB::table('sample_for_users')
        ->where('user_id', $user_id)
        ->where('is_active', 1)
        ->where('sample_type_id', 1)
        ->first();
    $chemistAssingedArr_3 = DB::table('sample_for_users')
        ->where('user_id', $user_id)
        ->where('is_active', 1)
        ->where('sample_type_id', 3)
        ->first();
    $chemistAssingedArr_4 = DB::table('sample_for_users')
        ->where('user_id', $user_id)
        ->where('is_active', 1)
        ->where('sample_type_id', 4)
        ->first();


    $chemistAssingedArr_5 = DB::table('sample_for_users')
        ->where('user_id', $user_id)
        ->where('is_active', 1)
        ->where('sample_type_id', 5)
        ->first();




    ?>
    <!-- datalist -->
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Chemist Orders as per samples :{{AyraHelp::getUser( $user_id )->name}}
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="javascript::void(0)" id="btnPrintSample" class="btn btn-info  m-btn--custom m-btn--icon">
                            <span>
                                <i class="la la-print"></i>
                                <span>PRINT</span>
                            </span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                <div class="m-portlet__body">
                    <div class="form-group m-form__group row">
                        <div class="col-lg-4">
                            <label>Sales Person:</label>
                            <select class="form-control m-input" id="salesPerson">

                                <?php
                                $user = auth()->user();
                                $userRoles = $user->getRoleNames();
                                $user_role = $userRoles[0];
                                ?>
                               
                                @foreach (AyraHelp::getChemist() as $user)                                

                                @if ($user->id == $user_id)
                                <option selected value="{{$user->id}}">{{$user->name}}</option>
                                @else
                                <option value="{{$user->id}}">{{$user->name}}</option>
                                @endif

                                
                                @endforeach
                               

                              

                            </select>
                            <span class="m-form__help"></span>
                        </div>
                        <div class="col-lg-4">
                            <label class="">Month:</label>
                            <select name="" id="txtMonth" class="form-control">
                                <option value="ALL">ALL</option>
                                <?php

                                for ($m = 1; $m <= 12; ++$m) {
                                    $date = '2019-' . $m . '-1';
                                    $m = sprintf("%02d", $m);

                                ?>
                                    <option value="{{$m}}">{{date('F', mktime(0, 0, 0, $m, 1))}}</option>
                                <?php
                                }

                                ?>
                            </select>

                            <span class="m-form__help"></span>
                        </div>
                        <div class="col-lg-4">
                            <label class="">Year:</label>
                            <select name="" id="txtyearData" class="form-control">
                                <?php

                                for ($m = 2018; $m <= date('Y'); ++$m) {

                                ?>
                                    <option <?php echo $m == date('Y') ? 'selected' : ''  ?> value="{{$m}}">{{$m}}</option>
                                <?php
                                }

                                ?>
                            </select>

                            <span class="m-form__help"></span>
                        </div>

                    </div>

                </div>
                <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions--solid">
                        <div class="row">
                            <div class="col-lg-4"></div>
                            <div class="col-lg-8">
                                <button type="button" class="btn btn-primary" id="btnShowchemistWaiseOrder">Submit</button>
                                <button type="reset" class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="showChemistOrdersampleDetails" id="div_printme">

            </div>




        </div>
    </div>



</div>
<!-- main  -->