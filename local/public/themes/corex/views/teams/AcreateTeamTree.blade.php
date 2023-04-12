<!-- main  -->
<div class="m-content">
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Create Teams Tree
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <!--begin::Form-->

            <form class="m-form m-form--state m-form--fit m-form--label-align-right" id="m_form_add_tmember" method="post" action="{{route('CreateMember')}}" novalidate="novalidate">
                @csrf
                <div class="m-portlet__body">
                    <div class="m-form__content">
                        <div class="m-alert m-alert--icon alert alert-danger m--hide" role="alert" id="m_form_1_msg">
                            <div class="m-alert__icon">
                                <i class="la la-warning"></i>
                            </div>
                            <div class="m-alert__text">
                                Oh snap! Change a few things up and try submitting again.
                            </div>
                            <div class="m-alert__close">
                                <button type="button" class="close" data-close="alert" aria-label="Close">
                                </button>
                            </div>
                        </div>
                    </div>



                    <div class="form-group m-form__group row">
                        <label class="col-form-label col-lg-3 col-sm-12">Select Manager *</label>
                        <div class="col-lg-9 col-md-9 col-sm-12">

                            <select class="form-control m-select2" id="m_select2_3" name="param_manager">
                                <?php
                                $allUsers = AyraHelp::getMangers();

                                foreach ($allUsers as $key => $rowData) {
                                ?>
                                    <option value="{{$rowData->user_id}}">{{$rowData->name}}</option>
                                <?php
                                }
                                ?>
                            </select>

                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label class="col-form-label col-lg-3 col-sm-12">Select Member *</label>
                        <div class="col-lg-9 col-md-9 col-sm-12">
                            <select class="form-control m-select2 mangerIDSelect" id="m_select2_1" name="param_member">
                                <?php
                                $allUsers = AyraHelp::getSalesAgentAdmin();

                                foreach ($allUsers as $key => $rowData) {
                                    $users = DB::table('categories')->where('user_id', $rowData->id)->first();
                                    if ($users == null) {
                                ?>
                                        <option value="{{$rowData->id}}">{{$rowData->name}}</option>
                                <?php
                                    }
                                }



                                ?>

                            </select>
                        </div>
                    </div>

                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions">
                        <div class="row">
                            <div class="col-lg-9 ml-lg-auto">
                                <button type="submit" data-wizard-action="submitMT" class="btn btn-primary">Save</button>
                                <button type="reset" class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!--end::Form-->
            <hr>

            <div style="background-color: #ccc; width:1200px; height: 600px" class="chart" id="botreeLayout"></div>


        </div>
    </div>
</div>
<!-- main  -->