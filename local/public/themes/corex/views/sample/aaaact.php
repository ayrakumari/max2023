<div class="m-form__section m-form__section--first">

<!-- repeater -->

<div id="m_repeater_1">
    <div class="form-group  m-form__group row" id="m_repeater_1">
        <label class="col-lg-2 col-form-label">
            Sample Details:
        </label>
        <div data-repeater-list="aj" class="col-lg-12">
            @foreach (json_decode($samples->sample_details) as $sample)

            <div data-repeater-item class="form-group m-form__group row align-items-center">
                <div class="col-md-4">
                    <div class="m-form__group m-form__group--inline">
                        <div class="m-form__label">
                            <label>
                                Item
                            </label>

                        </div>

                        <div class="m-form__control">

                            <input type="text" name="txtItem" value="{{ $sample->txtItem }}" class="form-control m-input" placeholder="Item Name">
                        </div>

                    </div>
                    <div class="d-md-none m--margin-bottom-2"></div>
                </div>
                <div class="col-md-6">
                    <div class="m-form__group m-form__group--inline">
                        <div class="m-form__label">
                            <label class="m-label m-label--single">
                                Description:
                            </label>
                        </div>
                        <div class="m-form__control">
                            <input type="text" name="txtDiscrption" value="{{ $sample->txtDiscrption }}" class="form-control m-input" placeholder="Description">
                        </div>
                    </div>
                    <div class="d-md-none m--margin-bottom-10"></div>
                </div>

                <div class="col-md-1">
                    <div data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">
                        <span>
                            <i class="la la-trash-o"></i>
                            <span>
                                Delete
                            </span>
                        </span>
                    </div>
                </div>
            </div>


            @endforeach






        </div>
    </div>
    <div class="m-form__group form-group row">
        <label class="col-lg-2 col-form-label"></label>
        <div class="col-lg-4">
            <div data-repeater-create="" class="btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
                <span>
                    <i class="la la-plus"></i>
                    <span>
                        Add
                    </span>
                </span>
            </div>
        </div>
    </div>
</div>
<!-- repeater -->
</div>