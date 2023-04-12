<!-- main  -->
<div class="m-content">
    <!-- datalist -->
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Bradwise Details
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">

                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <!--begin::Form-->
            <form id="btnGetBrandDetails" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" action="{{route('getMTDRangeWiseBrandDetails')}}" method="post">
                @csrf 
                <div class="m-portlet__body">
                    <div class="form-group m-form__group row">
                        <div class="col-lg-3">
                            <label>Sales:</label>
                            <select class="form-control m-input" id="salesPerson" name="sale_name">
                                <option value="ALL">--Select ALL--</option>
                                <?php
                                $user = auth()->user();
                                $userRoles = $user->getRoleNames();
                                $user_role = $userRoles[0];
                                ?>
                                @if ($user_role =="Admin" || $user_role =="SalesHead")
                                @foreach (AyraHelp::getSalesAgentOnlyWITHSTAFF() as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                                @else
                                <option value="{{Auth::user()->id}}">{{Auth::user()->name}}</option>
                                @endif

                            </select>

                        </div>
                        <div class="col-lg-3">
                            <label>Brands:</label>
                            <label class="form-control-label">* Client:</label>
                            <select class="form-control m-select2 m-select2-general" name="clinet_id">
                                <option value="ALL">--Select ALL--</option>
                                <?php

                                if (isset($useID)) {
                                ?>
                                    @foreach (AyraHelp::getClientByadded($useID) as $user)
                                    <?php
                                    $data_arrCLData = AyraHelp::IsClientHaveOrderList($user->id);
                                    // if($data_arrCLData>=1){

                                    // }

                                    ?>
                                    <option value="{{$user->id}}">{{$user->firstname}} | {{$user->phone}} | {{$user->email}}</option>
                                    <?php

                                    ?>
                                    @endforeach
                                <?php
                                } else {
                                ?>
                                    @foreach (AyraHelp::getClientByadded(Auth::user()->id) as $user)
                                    <?php
                                    $data_arrCLData = AyraHelp::IsClientHaveOrderList($user->id);
                                    // if($data_arrCLData>=1){

                                    // }

                                    ?>
                                    <option value="{{$user->id}}">{{$user->firstname}} | {{$user->phone}} | {{$user->email}}</option>
                                    <?php

                                    ?>
                                    @endforeach
                                <?php
                                }
                                ?>

                            </select>

                        </div>
                        <div class="col-lg-2">
                            <label>Order Type:</label>
                            <div class="m-radio-list">
                                <label class="m-radio m-radio--success">
                                    <input type="radio" name="orderType" value="1"> Private Lable
                                    <span></span>
                                </label>
                                <label class="m-radio m-radio--brand">
                                    <input type="radio" name="orderType" value="2"> Bulk
                                    <span></span>
                                </label>
                                <label class="m-radio m-radio--primary">
                                    <input type="radio" name="orderType" value="3"> Both
                                    <span></span>
                                </label>
                            </div>

                        </div>

                        <div class="col-lg-2">
                            <label class="">Month:</label>
                            <select name="monthNumber" id="txtMonth" class="form-control">
                                <option value="">All</option>

                                <?php

                                for ($m = 1; $m <= 12; ++$m) {
                                    $date = '2019-' . $m . '-1';
                                ?>
                                    <option value="{{$m}}">{{date('F', mktime(0, 0, 0, $m, 1))}}</option>
                                <?php
                                }

                                ?>
                            </select>
                        </div>

                        <div class="col-lg-2">

                            <label class="">Year:</label>
                            <select name="YearNumber" id="txtYearPayRec" class="form-control">
                                <option value="">-SELECT-</option>
                                <?php

                                for ($m = 2018; $m <= date('Y'); ++$m) {

                                ?>
                                    <option value="{{$m}}">{{$m}}</option>
                                <?php
                                }

                                ?>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions--solid">
                        <div class="row">

                            <div class="col-lg-8">
                                <button type="submit"  class="btn btn-primary">Submit</button>

                            </div>
                            <div class="col-lg-4">
                                <button type="reset" class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!--end::Form-->



        </div>
    </div>

    <!-- datalist -->

</div>
<!-- main  -->