
$( "select.client_city" ).change( function ()
{
    var selectedcityid = $( this ).children( "option:selected" ).val();
    $( '#namecountry' ).html( '' );
    $.ajax( {
        url: BASE_URL + "/api/getCountry/" + selectedcityid,
        type: 'GET',
        success: function ( resp )
        {


            $( '#namecountry' ).append( '<option value="' + resp.id + '">' + resp.name + '<option>' );
        }
    } );


} );

//chkHandedOver

$('input[name="chkHandedOver"]').click(function(){

    if($(this).prop("checked") == true){

       $('#client_address').val('NA')
       .attr('readonly', true)
       .css('background-color', 'gray'); 

       $('#client_location').val('NA')
       .attr('readonly', true)
       .css('background-color', 'gray'); 

       $('#client_contact_phone').val('NA')
       .attr('readonly', true)
       .css('background-color', 'gray'); 
       $(this).val(1);



    }

    else if($(this).prop("checked") == false){

        $('#client_address').val('')
        .attr('readonly', false)
        .css('background-color', 'white'); 
 
        $('#client_location').val('')
        .attr('readonly', false)
        .css('background-color', 'white'); 
 
        $('#client_contact_phone').val('')
        .attr('readonly', false)
        .css('background-color', 'white');
        $(this).val(2);

    }

});

//chkHandedOver


var FormControlsAyra = {
    init: function ()
    {

        $.validator.addMethod( "gst", function ( value3, element3 )
        {
            var gst_value = value3.toUpperCase();
            var reg = /^([0-9]{2}[a-zA-Z]{4}([a-zA-Z]{1}|[0-9]{1})[0-9]{4}[a-zA-Z]{1}([a-zA-Z]|[0-9]){3}){0,15}$/;
            if ( this.optional( element3 ) )
            {
                return true;
            }
            if ( gst_value.match( reg ) )
            {
                return true;
            } else
            {
                return false;
            }

        }, "Please specify a valid GSTTIN Number" );




        $( "#m_form_2_reset" ).validate( {
            rules: {
                email: {
                    required: !0,
                    email: !0
                },
                url: {
                    required: !0
                },
                digits: {
                    required: !0,
                    digits: !0
                },
                creditcard: {
                    required: !0,
                    creditcard: !0
                },
                phone: {
                    required: !0,
                    phoneUS: !0
                },
                option: {
                    required: !0
                },
                options: {
                    required: !0,
                    minlength: 2,
                    maxlength: 4
                },
                memo: {
                    required: !0,
                    minlength: 10,
                    maxlength: 100
                },
                checkbox: {
                    required: !0
                },
                checkboxes: {
                    required: !0,
                    minlength: 1,
                    maxlength: 2
                },
                radio: {
                    required: !0
                }
            },
            invalidHandler: function ( e, r )
            {
                mUtil.scrollTo( "m_form_2", -200 )
            },
            submitHandler: function ( e ) { }
        } ),
            $( "#frm_edit_raw_data" ).validate( {
                rules: {

                    name: {
                        required: !0
                    },



                },
                invalidHandler: function ( e, r )
                {
                    mUtil.scrollTo( "m_form_3", -200 ), swal( {
                        title: "",
                        text: "There are some errors in your submission. Please correct them.",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                        onClose: function ( e )
                        {
                            console.log( "on close event fired!" )
                        }
                    } ), e.preventDefault()
                },
                submitHandler: function ( form )
                {
                    var rowid = $( '#rowid_edit' ).val();
                    $.ajax( {
                        url: BASE_URL + '/rawclientdata/' + rowid,
                        type: 'POST',
                        data: $( form ).serialize(),
                        success: function ( res )
                        {
                            console.log( res );
                            swal( {
                                title: "",
                                text: "Data  modified successfully",
                                type: "success",
                                confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                                onClose: function ( e )
                                {

                                    window.location.href = BASE_URL + '/rawclientdata';
                                }
                            } ), !1

                        },
                        error: function ( res )
                        {

                            if ( res.responseJSON.errors.email[ 0 ] )
                            {
                                return swal( {
                                    title: res.responseJSON.errors.email[ 0 ],
                                    text: 'Please enter valid email',
                                    type: "error",
                                    confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                                } ), !1
                            }
                        },
                        dataType: 'json'
                    } );


                }
            } ), $( "#m_form_222" ).validate( {
                rules: {

                    name: {
                        required: !0
                    },

                    phone: {
                        required: !0

                    },
                    company: {
                        required: !0

                    }

                },
                invalidHandler: function ( e, r )
                {
                    mUtil.scrollTo( "m_form_3", -200 ), swal( {
                        title: "",
                        text: "There are some errors in your submission. Please correct them.",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                        onClose: function ( e )
                        {
                            console.log( "on close event fired!" )
                        }
                    } ), e.preventDefault()
                },
                submitHandler: function ( form )
                {
                    $.ajax( {
                        url: BASE_URL + '/edit/client',
                        type: 'POST',
                        data: $( form ).serialize(),
                        success: function ( res )
                        {
                            console.log( res );
                            swal( {
                                title: "",
                                text: "Client data modified successfully",
                                type: "success",
                                confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                                onClose: function ( e )
                                {
                                    location.reload();
                                }
                            } ), !1

                        },
                        error: function ( res )
                        {

                            if ( res.responseJSON.errors.email[ 0 ] )
                            {
                                return swal( {
                                    title: res.responseJSON.errors.email[ 0 ],
                                    text: 'Please enter valid email',
                                    type: "error",
                                    confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                                } ), !1
                            }
                        },
                        dataType: 'json'
                    } );


                }
            } ), 
            // save technical feeback lab
            $( "#m_form_3_sampleTechSubmitFeedback" ).validate( {
                rules: {
                    approved_msg: {
                        required: !0,
                        maxlength: 400
                    },
                    approved_status: {
                        required: !0
                    },
                   

                },
                invalidHandler: function ( e, r )
                {
                    mUtil.scrollTo( "m_form_3_sampleTechSubmitFeedback", -200 ), swal( {
                        title: "",
                        text: "There are some errors in your submission. Please correct them.",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                        onClose: function ( e )
                        {
                            console.log( "on close event fired!" )
                        }
                    } ), e.preventDefault()
                },
                submitHandler: function ( form )
                {
                    $.ajax( {
                        url: BASE_URL + '/saveSampleTechDocFeedback',
                        type: 'POST',
                        data: $( form ).serialize(),
                        success: function ( res )
                        {
                            console.log( res );
                            swal( {
                                title: "",
                                text: "Technical Document Feedback Submitted successfully",
                                type: "success",
                                confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                                onClose: function ( e )
                                {
                                    location.reload();
                                }
                            } ), !1

                        },
                        error: function ( res )
                        {

                            
                        },
                        dataType: 'json'
                    } );


                }
            } ),
            //m_form_3_sampleTechSubmitFeedbackDOC
            $( "#m_form_3_sampleTechSubmitFeedbackDOCS" ).validate( {
                rules: {
                    approved_msg: {
                        required: !0,
                        maxlength: 400
                    },
                    approved_status: {
                        required: !0
                    },
                   

                },
                invalidHandler: function ( e, r )
                {
                    mUtil.scrollTo( "m_form_3_sampleTechSubmitFeedbackDOC", -200 ), swal( {
                        title: "",
                        text: "There are some errors in your submission. Please correct them.",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                        onClose: function ( e )
                        {
                            console.log( "on close event fired!" )
                        }
                    } ), e.preventDefault()
                },
                submitHandler: function ( form )
                {
                    var formData = new FormData(forms);

                    $.ajax( {
                        url: BASE_URL + '/saveSampleTechDocFeedback_DOC',
                        type: 'POST',
                        data: formData,
                        success: function ( res )
                        {
                            console.log( res );
                            swal( {
                                title: "",
                                text: "Technical Document Uploaded successfully",
                                type: "success",
                                confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                                onClose: function ( e )
                                {
                                    location.reload();
                                }
                            } ), !1

                        },
                        error: function ( res )
                        {

                            
                        },
                        dataType: 'json'
                    } );


                }
            } ),
            //m_form_3_sampleTechSubmitFeedbackDOC

            // save technical feeback lab
            //sampleTechnical subit 
            $( "#m_form_3_sampleTechSubmit" ).validate( {
                rules: {
                    approved_msg: {
                        required: !0,
                        maxlength: 400
                    },
                    approved_status: {
                        required: !0
                    },
                   

                },
                invalidHandler: function ( e, r )
                {
                    mUtil.scrollTo( "m_form_3_sampleTechSubmit", -200 ), swal( {
                        title: "",
                        text: "There are some errors in your submission. Please correct them.",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                        onClose: function ( e )
                        {
                            console.log( "on close event fired!" )
                        }
                    } ), e.preventDefault()
                },
                submitHandler: function ( form )
                {
                    $.ajax( {
                        url: BASE_URL + '/saveSampleTechDoc',
                        type: 'POST',
                        data: $( form ).serialize(),
                        success: function ( res )
                        {
                            console.log( res );
                            toasterOptions();
                            toastr.success( 'Technical Document Submitted successfully', 'Success' )
                            window.location.href = BASE_URL + '/sample-technical-document-List';

                            // swal( {
                            //     title: "",
                            //     text: "Technical Document Submitted successfully",
                            //     type: "success",
                            //     confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                            //     onClose: function ( e )
                            //     {
                            //         //location.reload();
                                    
                            //     }
                            // } ), !1

                        },
                        error: function ( res )
                        {

                           
                        },
                        dataType: 'json'
                    } );


                }
            } ),
            $( "#m_form_3_OrderTechSubmit" ).validate( {
                rules: {
                    approved_msg: {
                        required: !0,
                        maxlength: 400
                    },
                    approved_status: {
                        required: !0
                    },
                   

                },
                invalidHandler: function ( e, r )
                {
                    mUtil.scrollTo( "m_form_3_OrderTechSubmit", -200 ), swal( {
                        title: "",
                        text: "There are some errors in your submission. Please correct them.",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                        onClose: function ( e )
                        {
                            console.log( "on close event fired!" )
                        }
                    } ), e.preventDefault()
                },
                submitHandler: function ( form )
                {
                    $.ajax( {
                        url: BASE_URL + '/saveOrderTechDoc',
                        type: 'POST',
                        data: $( form ).serialize(),
                        success: function ( res )
                        {
                            console.log( res );
                            toasterOptions();
                            toastr.success( 'Technical Document Submitted successfully', 'Success' )
                            window.location.href = BASE_URL + '/order-technical-document-List';

                            // swal( {
                            //     title: "",
                            //     text: "Technical Document Submitted successfully",
                            //     type: "success",
                            //     confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                            //     onClose: function ( e )
                            //     {
                            //         //location.reload();
                                    
                            //     }
                            // } ), !1

                        },
                        error: function ( res )
                        {

                           
                        },
                        dataType: 'json'
                    } );


                }
            } ),
            //sampleTechnical subit 
            //incetive Approval 
            $( "#m_form_3_IncetiveApproval" ).validate( {
                rules: {
                    approved_msg: {
                        required: !0,
                        maxlength: 400
                    },
                    approved_status: {
                        required: !0
                    },
                   

                },
                invalidHandler: function ( e, r )
                {
                    mUtil.scrollTo( "m_form_3_IncetiveApproval", -200 ), swal( {
                        title: "",
                        text: "There are some errors in your submission. Please correct them.",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                        onClose: function ( e )
                        {
                            console.log( "on close event fired!" )
                        }
                    } ), e.preventDefault()
                },
                submitHandler: function ( form )
                {
                    $.ajax( {
                        url: BASE_URL + '/setIncentiveApprovalStutus',
                        type: 'POST',
                        data: $( form ).serialize(),
                        success: function ( res )
                        {
                            console.log( res );
                            swal( {
                                title: "",
                                text: "Incentive Slab Submitted successfully",
                                type: "success",
                                confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                                onClose: function ( e )
                                {
                                    location.reload();
                                }
                            } ), !1

                        },
                        error: function ( res )
                        {

                            if ( res.responseJSON.errors.email[ 0 ] )
                            {
                                return swal( {
                                    title: res.responseJSON.errors.email[ 0 ],
                                    text: 'Please enter valid email',
                                    type: "error",
                                    confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                                } ), !1
                            }
                        },
                        dataType: 'json'
                    } );


                }
            } ), 

            //incetive Approval 
            
            //-----------------------------------------------
            $( "#m_form_incentive_Slab" ).validate( {
                rules: {
                    sample_details: {
                        required: !0,
                        maxlength: 400
                    },
                    sample_id: {
                        required: !0
                    },
                    client_name: {
                        required: !0,

                    },
                    client_address: {
                        required: !0,

                    },
                    courier_name: {
                        required: !0,

                    },
                    track_id: {
                        required: !0
                    }

                },
                invalidHandler: function ( e, r )
                {
                    mUtil.scrollTo( "m_form_3", -200 ), swal( {
                        title: "",
                        text: "There are some errors in your submission. Please correct them.",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                        onClose: function ( e )
                        {
                            console.log( "on close event fired!" )
                        }
                    } ), e.preventDefault()
                },
                submitHandler: function ( form )
                {
                    $.ajax( {
                        url: BASE_URL + '/setSaveIncentiveSlab',
                        type: 'POST',
                        data: $( form ).serialize(),
                        success: function ( res )
                        {
                            console.log( res );
                            swal( {
                                title: "",
                                text: "Incentive Slab Submitted successfully",
                                type: "success",
                                confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                                onClose: function ( e )
                                {
                                    location.reload();
                                }
                            } ), !1

                        },
                        error: function ( res )
                        {

                            if ( res.responseJSON.errors.email[ 0 ] )
                            {
                                return swal( {
                                    title: res.responseJSON.errors.email[ 0 ],
                                    text: 'Please enter valid email',
                                    type: "error",
                                    confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                                } ), !1
                            }
                        },
                        dataType: 'json'
                    } );


                }
            } ), 
            //------------------------------


            //-----------------------------------------------
             $( "#m_form_incentive_Type" ).validate( {
                rules: {
                    sample_details: {
                        required: !0,
                        maxlength: 400
                    },
                    sample_id: {
                        required: !0
                    },
                    client_name: {
                        required: !0,

                    },
                    client_address: {
                        required: !0,

                    },
                    courier_name: {
                        required: !0,

                    },
                    track_id: {
                        required: !0
                    }

                },
                invalidHandler: function ( e, r )
                {
                    mUtil.scrollTo( "m_form_3", -200 ), swal( {
                        title: "",
                        text: "There are some errors in your submission. Please correct them.",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                        onClose: function ( e )
                        {
                            console.log( "on close event fired!" )
                        }
                    } ), e.preventDefault()
                },
                submitHandler: function ( form )
                {
                    $.ajax( {
                        url: BASE_URL + '/setSaveIncentive',
                        type: 'POST',
                        data: $( form ).serialize(),
                        success: function ( res )
                        {
                            console.log( res );
                            swal( {
                                title: "",
                                text: "Incentive Submitted successfully",
                                type: "success",
                                confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                                onClose: function ( e )
                                {
                                    location.reload();
                                }
                            } ), !1

                        },
                        error: function ( res )
                        {

                            if ( res.responseJSON.errors.email[ 0 ] )
                            {
                                return swal( {
                                    title: res.responseJSON.errors.email[ 0 ],
                                    text: 'Please enter valid email',
                                    type: "error",
                                    confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                                } ), !1
                            }
                        },
                        dataType: 'json'
                    } );


                }
            } ), 
            //------------------------------
            $( "#m_form_12" ).validate( {
                rules: {
                    sample_details: {
                        required: !0,
                        maxlength: 400
                    },
                    sample_id: {
                        required: !0
                    },
                    client_name: {
                        required: !0,

                    },
                    client_address: {
                        required: !0,

                    },
                    courier_name: {
                        required: !0,

                    },
                    track_id: {
                        required: !0
                    }

                },
                invalidHandler: function ( e, r )
                {
                    mUtil.scrollTo( "m_form_3", -200 ), swal( {
                        title: "",
                        text: "There are some errors in your submission. Please correct them.",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                        onClose: function ( e )
                        {
                            console.log( "on close event fired!" )
                        }
                    } ), e.preventDefault()
                },
                submitHandler: function ( form )
                {
                    $.ajax( {
                        url: BASE_URL + '/samples/edits/datainfo',
                        type: 'POST',
                        data: $( form ).serialize(),
                        success: function ( res )
                        {
                            console.log( res );
                            swal( {
                                title: "",
                                text: "Sample modified successfully",
                                type: "success",
                                confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                                onClose: function ( e )
                                {
                                    location.reload();
                                }
                            } ), !1

                        },
                        error: function ( res )
                        {

                            if ( res.responseJSON.errors.email[ 0 ] )
                            {
                                return swal( {
                                    title: res.responseJSON.errors.email[ 0 ],
                                    text: 'Please enter valid email',
                                    type: "error",
                                    confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                                } ), !1
                            }
                        },
                        dataType: 'json'
                    } );


                }
            } ), $( "#m_form_1" ).validate( {
                rules: {
                    sample_details: {
                        required: !0,
                        maxlength: 400
                    },
                    sample_id: {
                        required: !0
                    },
                    client_name: {
                        required: !0,

                    },
                    client_address: {
                        required: !0,

                    },
                    client_city: {
                        required: !0,

                    },
                    txtDiscrption: {
                        required: !0,

                    },
                    track_id: {
                        required: !0
                    }

                },
                invalidHandler: function ( e, r )
                {
                    mUtil.scrollTo( "m_form_3", -200 ), swal( {
                        title: "",
                        text: "There are some errors in your submission. Please correct them.",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                        onClose: function ( e )
                        {
                            console.log( "on close event fired!" )
                        }
                    } ), e.preventDefault()
                },
                submitHandler: function ( form )
                {
                    $.ajax( {
                        url: BASE_URL + '/sample',
                        type: 'POST',
                        data: $( form ).serialize(),
                        success: function ( res )
                        {
                            console.log( res );
                            swal( {
                                title: "",
                                text: "Sample Added successfully",
                                type: "success",
                                confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                                onClose: function ( e )
                                {
                                    location.reload();
                                    window.location.href = BASE_URL + '/sample'
                                }
                            } ), !1

                        },
                        error: function ( res )
                        {

                            if ( res.responseJSON.errors.email[ 0 ] )
                            {
                                return swal( {
                                    title: res.responseJSON.errors.email[ 0 ],
                                    text: 'Please enter valid email',
                                    type: "error",
                                    confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                                } ), !1
                            }
                        },
                        dataType: 'json'
                    } );


                }
            } ), $( "#m_form_2" ).validate( {
                rules: {
                    name: {
                        required: !0
                    },
                    phone: {
                        required: !0

                    },
                    company: {
                        required: !0
                    }

                },
                invalidHandler: function ( e, r )
                {
                    mUtil.scrollTo( "m_form_3", -200 ), swal( {
                        title: "",
                        text: "There are some errors in your submission. Please correct them.",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                        onClose: function ( e )
                        {
                            console.log( "on close event fired!" )
                        }
                    } ), e.preventDefault()
                },
                submitHandler: function ( form )
                {
                    $.ajax( {
                        url: BASE_URL + '/client',
                        type: 'POST',
                        data: $( form ).serialize(),
                        success: function ( res )
                        {
                            console.log( res );
                            swal( {
                                title: "",
                                text: "Client Added successfully",
                                type: "success",
                                confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                                onClose: function ( e )
                                {
                                    location.reload();
                                }
                            } ), !1

                        },
                        error: function ( res )
                        {

                            if ( res.responseJSON.errors.email[ 0 ] )
                            {
                                return swal( {
                                    title: res.responseJSON.errors.email[ 0 ],
                                    text: 'Please enter valid email',
                                    type: "error",
                                    confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                                } ), !1
                            }
                        },
                        dataType: 'json'
                    } );


                }
            } ), $( "#m_form_3" ).validate( {
                rules: {
                    name: {
                        required: !0
                    },

                },
                invalidHandler: function ( e, r )
                {
                    mUtil.scrollTo( "m_form_3", -200 ), swal( {
                        title: "",
                        text: "There are some errors in your submission. Please correct them.",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                        onClose: function ( e )
                        {
                            console.log( "on close event fired!" )
                        }
                    } ), e.preventDefault()
                },
                submitHandler: function ( e )
                {
                    return swal( {
                        title: "",
                        text: "Form validation passed. All good!",
                        type: "success",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                    } ), !1
                }
            } ),
            //m_form_3PaymentRequest
            $( "#m_form_3PaymentRequestSS" ).validate( {
                rules: {
                    client_select: {
                        required: !0
                    },
                    pay_date_recieved: {
                        required: !0
                    },
                    payAmt: {
                        required: !0
                    },
                    bank_name: {
                        required: !0
                    },
                    order_destination: {
                        required: !0
                    },
                    vLogistic: {
                        required: !1
                    },
                    termsDelivery: {
                        required: !0
                    },
                    Vno_of_cartons: {
                        required: !0
                    },
                    paid_by: {
                        required: !0
                    },
                    paid_by: {
                        required: !0
                    },
                    Vno_of_unit: {
                        required: !0
                    },
                    txtShippingCharge:{
                        required: !0
                      }


                },
                invalidHandler: function ( e, r )
                {
                    mUtil.scrollTo( "m_form_3", -200 ), swal( {
                        title: "",
                        text: "There are some errors in your submission. Please correct them.",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                        onClose: function ( e )
                        {
                            console.log( "on close event fired!" )
                        }
                    } ), e.preventDefault()
                },
                submitHandler: function ( e )
                {


                    $( '#m_form_3PaymentRequest' ).on( 'submit', ( function ( e )
                    {
                        e.preventDefault();
                        var formData = new FormData( this );

                        $.ajax( {
                            type: 'POST',
                            url: BASE_URL + '/savePaymentRecivedClient',
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function ( data )
                            {
                                if ( data.status == 1 )
                                {
                                    toasterOptions();
                                    toastr.success( 'Submitted  successfully', 'Success' )
                                    // $('#m_modal_QuickNav_1').modal('toggle');
                                    location.reload( 1 );

                                } else
                                {
                                    toasterOptions();
                                    toastr.error( 'Already Submitted', 'Alert' )

                                }

                            },
                            dataType: 'json',
                            error: function ( data )
                            {
                                console.log( "error" );
                                console.log( data );
                            }
                        } );
                    } ) );



                    // $.ajax({
                    //     url: BASE_URL+'/savePaymentRecivedClient',
                    //     type: 'POST',
                    //     data: $(e).serialize(),
                    //     success: function(res) {

                    //         if(res.status==1){
                    //             toasterOptions();
                    //           toastr.success('Submitted  successfully', 'Success')
                    //          // $('#m_modal_QuickNav_1').modal('toggle');
                    //             location.reload(1);

                    //         }else{
                    //         toasterOptions();
                    //         toastr.error('Already Submitted', 'Alert')

                    //         }



                    //     },
                    //     error: function(res) {


                    //     },
                    //      dataType : 'json'
                    // });



                }
            } ),
            //m_form_3PaymentRequest
            // sampleIgredentSave
            $( "#m_form_3_sampleIngredntSave" ).validate( {
                rules: {
                    ticketType: {
                        required: !0
                    },
                    ticketPriority: {
                        required: !0
                    },
                    ticket_user: {
                        required: !0
                    },
                    ticket_subject: {
                        required: !0
                    },
                    txtTicketMessage: {
                        required: !0
                    },



                },
                invalidHandler: function ( e, r )
                {
                    mUtil.scrollTo( "m_form_3", -200 ), swal( {
                        title: "",
                        text: "There are some errors in your submission. Please correct them.",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                        onClose: function ( e )
                        {
                            console.log( "on close event fired!" )
                        }
                    } ), e.preventDefault()
                },
                submitHandler: function ( e )
                {
                    $.ajax( {
                        url: BASE_URL + '/saveSampleFormulations',
                        type: 'POST',
                        data: $( e ).serialize(),
                        success: function ( res )
                        {

                            if ( res.status == 1 )
                            {
                                toasterOptions();
                                //  $('#m_modal_BOSupportReport_1').modal('toggle');
                                toastr.success( 'Submitted Successfully', 'Sample Formulation' );
                                setTimeout( function ()
                                {

                                    location.reload( 1 );
                                }, 500 );




                            } else
                            {
                                toasterOptions();
                                toastr.error( 'Already completed', 'Alert' )

                            }



                        },
                        error: function ( res )
                        {


                        },
                        dataType: 'json'
                    } );



                }
            } ),
            $( "#m_form_3_sampleIngredntSaveFormulation" ).validate( {
                rules: {
                    ticketType: {
                        required: !0
                    },
                    ticketPriority: {
                        required: !0
                    },
                    ticket_user: {
                        required: !0
                    },
                    ticket_subject: {
                        required: !0
                    },
                    txtTicketMessage: {
                        required: !0
                    },



                },
                invalidHandler: function ( e, r )
                {
                    mUtil.scrollTo( "m_form_3", -200 ), swal( {
                        title: "",
                        text: "There are some errors in your submission. Please correct them.",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                        onClose: function ( e )
                        {
                            console.log( "on close event fired!" )
                        }
                    } ), e.preventDefault()
                },
                submitHandler: function ( e )
                {
                    $.ajax( {
                        url: BASE_URL + '/saveSampleFormulationsF',
                        type: 'POST',
                        data: $( e ).serialize(),
                        success: function ( res )
                        {

                            if ( res.status == 1 )
                            {
                                toasterOptions();
                                //  $('#m_modal_BOSupportReport_1').modal('toggle');
                                toastr.success( 'Submitted Successfully', 'Sample Formulation' );
                                setTimeout( function ()
                                {

                                    // location.reload( 1 );
                                }, 500 );




                            } else
                            {
                                toasterOptions();
                                toastr.error( 'Already completed', 'Alert' )

                            }



                        },
                        error: function ( res )
                        {


                        },
                        dataType: 'json'
                    } );



                }
            } ),

            // sampleIgredentSave
            // m_form_3_ticketRequest
            $( "#m_form_3_ticketRequest" ).validate( {
                rules: {
                    ticketType: {
                        required: !0
                    },
                    ticketPriority: {
                        required: !0
                    },
                    ticket_user: {
                        required: !0
                    },
                    ticket_subject: {
                        required: !0
                    },
                    txtTicketMessage: {
                        required: !0
                    },



                },
                invalidHandler: function ( e, r )
                {
                    mUtil.scrollTo( "m_form_3", -200 ), swal( {
                        title: "",
                        text: "There are some errors in your submission. Please correct them.",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                        onClose: function ( e )
                        {
                            console.log( "on close event fired!" )
                        }
                    } ), e.preventDefault()
                },
                submitHandler: function ( e )
                {
                    $.ajax( {
                        url: BASE_URL + '/sentTicketRequest',
                        type: 'POST',
                        data: $( e ).serialize(),
                        success: function ( res )
                        {

                            if ( res.status == 1 )
                            {
                                toasterOptions();
                                //  $('#m_modal_BOSupportReport_1').modal('toggle');
                                toastr.success( 'Ticket Submitted Successfully', 'Wait For Response' );
                                setTimeout( function ()
                                {

                                    location.reload( 1 );
                                }, 500 );




                            } else
                            {
                                toasterOptions();
                                toastr.error( 'Error', 'Alert' )

                            }



                        },
                        error: function ( res )
                        {


                        },
                        dataType: 'json'
                    } );



                }
            } ),

            // m_form_3_ticketRequest
            //m_form_3_ticketFromOrder
            $( "#m_form_3_ticketFromOrder" ).validate( {
                rules: {
                    formID: {
                        required: !0
                    },
                    client_name: {
                        required: !0
                    },
                    complain_date: {
                        required: !0
                    },
                    assignedUserID: {
                        required: !0
                    },
                    ticket_subject: {
                        required: !0
                    },
                    ticket_item_name: {
                        required: !0
                    },
                    txtTicketMessage: {
                        required: !0
                    },



                },
                invalidHandler: function ( e, r )
                {
                    mUtil.scrollTo( "m_form_3", -200 ), swal( {
                        title: "",
                        text: "There are some errors in your submission. Please correct them.",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                        onClose: function ( e )
                        {
                            console.log( "on close event fired!" )
                        }
                    } ), e.preventDefault()
                },
                submitHandler: function ( e )
                {
                    var fd = new FormData();
                    _token = $( 'meta[name="csrf-token"]' ).attr( 'content' );
                    var formID = $('.myOrderListSelectTicket option:selected').val();
                   
                   
                    var assignedUserID = $('.assignedUserID option:selected').val();
                    var ticket_cm_typeID = $('.ticket_cm_type option:selected').val();
                    var ticket_cm_typeName = $('.ticket_cm_type option:selected').text();

                    var client_email=$('#client_email').val();
                    var m_datepicker_1=$('#m_datepicker_1').val();
                    var ticket_subject=$('#ticket_subject').val();
                    var ticket_item_name=$('#ticket_item_name').val();
                    var ticketPriority=$('#ticketPriority').val();
                    var ticketPriorityName=$('#ticketPriority').text();
                    var txtTicketMessage=$('textarea#txtTicketMessage').val();

                    var files = $('#fileAttach')[0].files; 
                    fd.append('fileAttach',files[0]); 
                    fd.append('_token',_token); 
                    fd.append('client_email',client_email); 
                    fd.append('m_datepicker_1',m_datepicker_1); 
                    fd.append('formID',formID); 
                    fd.append('assignedUserID',assignedUserID); 
                    fd.append('ticket_subject',ticket_subject); 
                    fd.append('ticket_item_name',ticket_item_name); 
                    fd.append('ticket_cm_typeID',ticket_cm_typeID); 
                    fd.append('ticket_cm_typeName',ticket_cm_typeName); 
                    fd.append('ticketPriority',ticketPriority); 
                    fd.append('ticketPriorityName',ticketPriorityName); 
                    fd.append('txtTicketMessage',txtTicketMessage); 
                    
                    // formData.append("file", fileAttach.files[0]);

                    $.ajax( {
                        url: BASE_URL + '/sentTicketRequestOrder',
                        type: 'POST',
                        data: fd,
                        processData: false,
                        contentType: false,
                        success: function ( res )
                        {

                            if ( res.status == 1 )
                            {
                                toasterOptions();
                                //  $('#m_modal_BOSupportReport_1').modal('toggle');
                                toastr.success( 'Ticket Submitted Successfully', 'Wait For Response' );
                                setTimeout( function ()
                                {

                                    location.reload( 1 );
                                }, 500 );




                            } else
                            {
                                toasterOptions();
                                toastr.error( 'Error', 'Alert' )

                            }



                        },
                        error: function ( res )
                        {


                        },
                        dataType: 'json'
                    } );



                }
            } ),

            //m_form_3_ticketFromOrder

            $( "#m_form_3_salesInvoiceRequest" ).validate( {
                rules: {
                    txtMyGSTNO: {
                        required: !0
                    },
                    txtMyContactNO: {
                        required: !0
                    },
                    complete_buyer_address: {
                        required: !0
                    },
                    delivery_address: {
                        required: !0
                    },
                    order_destination: {
                        required: !0
                    },
                    vLogistic: {
                        required: !1
                    },
                    termsDelivery: {
                        required: !0
                    },
                    Vno_of_cartons: {
                        required: !0
                    },
                    paid_by: {
                        required: !0
                    },
                    paid_by: {
                        required: !0
                    },
                    Vno_of_unit: {
                        required: !0
                    },
                    txtShippingCharge:{
                        required: !0
                      }


                },
                invalidHandler: function ( e, r )
                {
                    mUtil.scrollTo( "m_form_3", -200 ), swal( {
                        title: "",
                        text: "There are some errors in your submission. Please correct them.",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                        onClose: function ( e )
                        {
                            console.log( "on close event fired!" )
                        }
                    } ), e.preventDefault()
                },
                submitHandler: function ( e )
                {
                    $.ajax( {
                        url: BASE_URL + '/saveSalesInvoiceRequest',
                        type: 'POST',
                        data: $( e ).serialize(),
                        success: function ( res )
                        {

                            if ( res.status == 1 )
                            {
                                toasterOptions();
                                toastr.success( 'Submitted  successfully', 'Success' )
                                // $('#m_modal_QuickNav_1').modal('toggle');
                                location.reload( 1 );

                            } else
                            {
                                toasterOptions();
                                toastr.error( 'Already Submitted', 'Alert' )

                            }



                        },
                        error: function ( res )
                        {


                        },
                        dataType: 'json'
                    } );



                }
            } ),
            //new form submit validation and form submit code
            $( "#m_form_item_submit" ).validate( {
                rules: {
                    item_cat: {
                        required: !0
                    },
                    item_id: {
                        required: !0
                    },
                    item_qty: {
                        required: !0
                    },

                },
                invalidHandler: function ( e, r )
                {
                    mUtil.scrollTo( "m_form_item_submit", -200 ),
                        toasterOptions();
                    toastr.error( 'There are some errors in your submission. Please correct them.', 'Error' )
                    // setTimeout(function() {
                    //     window.location.href = BASE_URL + '/orders'
                    // }, 2000),
                    e.preventDefault()
                },
                submitHandler: function ( e )
                {
                    $.ajax( {
                        url: BASE_URL + '/saveOrderItem',
                        type: 'POST',
                        data: $( e ).serialize(),
                        success: function ( res )
                        {
                            console.log( res );
                            toasterOptions();
                            toastr.success( 'Item added successfully', 'Success' )
                            setTimeout( function ()
                            {
                                location.reload();
                            }, 500 ),
                                e.preventDefault()

                        },
                        error: function ( res )
                        {


                        },
                        dataType: 'json'
                    } );



                }
            } )
        //new form submit validation and form submit code
        //new form submit validation and form submit code
        $( "#m_form_KPIData" ).validate( {
            rules: {
                job_roledata: {
                    required: !0
                },
                department_data: {
                    required: !0
                },


            },
            invalidHandler: function ( e, r )
            {
                mUtil.scrollTo( "m_form_item_submit", -200 ),
                    toasterOptions();
                toastr.error( 'There are some errors in your submission. Please correct them.', 'Error' )
                // setTimeout(function() {
                //     window.location.href = BASE_URL + '/orders'
                // }, 2000),
                e.preventDefault()
            },
            submitHandler: function ( e )
            {
                $.ajax( {
                    url: BASE_URL + '/saveKPIData',
                    type: 'POST',
                    data: $( e ).serialize(),
                    success: function ( res )
                    {
                        console.log( res );
                        toasterOptions();
                        toastr.success( 'Item added successfully', 'Success' )
                        setTimeout( function ()
                        {
                            location.reload();
                        }, 500 ),
                            e.preventDefault()

                    },
                    error: function ( res )
                    {


                    },
                    dataType: 'json'
                } );



            }
        } )
        //new form submit validation and form submit code

        //new form submit validation and form submit code
        $( "#m_form_KPIDataSubmitReport" ).validate( {
            rules: {
                kpi_date: {
                    required: !0
                },
                goal_for_month: {
                    required: !0
                },
                goal_for_today: {
                    required: !0
                },



            },
            invalidHandler: function ( e, r )
            {
                mUtil.scrollTo( "m_form_item_submit", -200 ),
                    toasterOptions();
                toastr.error( 'There are some errors in your submission. Please correct them.', 'Error' )
                // setTimeout(function() {
                //     window.location.href = BASE_URL + '/orders'
                // }, 2000),
                e.preventDefault()
            },
            submitHandler: function ( e )
            {
                $.ajax( {
                    url: BASE_URL + '/saveKPIReportSubmit',
                    type: 'POST',
                    data: $( e ).serialize(),
                    success: function ( res )
                    {

                        toasterOptions();
                        toastr.success( 'Item added successfully', 'Success' )
                        setTimeout( function ()
                        {
                            location.reload( 1 );
                        }, 1000 ),
                            e.preventDefault()

                    },
                    error: function ( res )
                    {


                    },
                    dataType: 'json'
                } );



            }
        } )
        //new form submit validation and form submit code

        $( "#m_form_3_salesInvoiceRequestAccess" ).validate( {
            rules: {
                kpi_date: {
                    required: !0
                },
                goal_for_month: {
                    required: !0
                },
                goal_for_today: {
                    required: !0
                },



            },
            invalidHandler: function ( e, r )
            {
                mUtil.scrollTo( "m_form_item_submit", -200 ),
                    toasterOptions();
                toastr.error( 'There are some errors in your submission. Please correct them.', 'Error' )
                // setTimeout(function() {
                //     window.location.href = BASE_URL + '/orders'
                // }, 2000),
                e.preventDefault()
            },
            submitHandler: function ( e )
            {
                $.ajax( {
                    url: BASE_URL + '/saveKPIRepfortSubmit',
                    type: 'POST',
                    data: $( e ).serialize(),
                    success: function ( res )
                    {

                        toasterOptions();
                        toastr.success( 'Item added successfully', 'Success' )
                        setTimeout( function ()
                        {
                            location.reload( 1 );
                        }, 1000 ),
                            e.preventDefault()

                    },
                    error: function ( res )
                    {


                    },
                    dataType: 'json'
                } );



            }
        } )







    }
};

//---------------------------------------
var iWords = [ 'zero', ' one', ' two', ' three', ' four', ' five', ' six', ' seven', ' eight', ' nine' ];
var ePlace = [ 'ten', ' eleven', ' twelve', ' thirteen', ' fourteen', ' fifteen', ' sixteen', ' seventeen', ' eighteen', ' nineteen' ];
var tensPlace = [ '', ' ten', ' twenty', ' thirty', ' forty', ' fifty', ' sixty', ' seventy', ' eighty', ' ninety' ];
var inWords = [];

var numReversed, inWords, actnumber, i, j;

function tensComplication()
{
    if ( actnumber[ i ] == 0 )
    {
        inWords[ j ] = '';
    } else if ( actnumber[ i ] == 1 )
    {
        inWords[ j ] = ePlace[ actnumber[ i - 1 ] ];
    } else
    {
        inWords[ j ] = tensPlace[ actnumber[ i ] ];
    }
}

function convertAmount( rsamt )
{
    var numericValue = rsamt;
    numericValue = parseFloat( numericValue ).toFixed( 2 );

    var amount = numericValue.toString().split( '.' );
    var taka = amount[ 0 ];
    var paisa = amount[ 1 ];
    var rsData = convert( taka ) + " Rupees and " + convert( paisa ) + " paisa only";


    document.getElementById( 'rsWords' ).value = rsData.charAt( 0 ).toUpperCase() + rsData.slice( 1 )


}
function convert( numericValue )
{
    inWords = []
    if ( numericValue == "00" || numericValue == "0" )
    {
        return 'zero';
    }
    var obStr = numericValue.toString();
    numReversed = obStr.split( '' );
    actnumber = numReversed.reverse();


    if ( Number( numericValue ) == 0 )
    {
        document.getElementById( 'container' ).innerHTML = 'BDT Zero';
        return false;
    }

    var iWordsLength = numReversed.length;
    var finalWord = '';
    j = 0;
    for ( i = 0; i < iWordsLength; i++ )
    {
        switch ( i )
        {
            case 0:
                if ( actnumber[ i ] == '0' || actnumber[ i + 1 ] == '1' )
                {
                    inWords[ j ] = '';
                } else
                {
                    inWords[ j ] = iWords[ actnumber[ i ] ];
                }
                inWords[ j ] = inWords[ j ] + '';
                break;
            case 1:
                tensComplication();
                break;
            case 2:
                if ( actnumber[ i ] == '0' )
                {
                    inWords[ j ] = '';
                } else if ( actnumber[ i - 1 ] !== '0' && actnumber[ i - 2 ] !== '0' )
                {
                    inWords[ j ] = iWords[ actnumber[ i ] ] + ' hundred';
                } else
                {
                    inWords[ j ] = iWords[ actnumber[ i ] ] + ' hundred';
                }
                break;
            case 3:
                if ( actnumber[ i ] == '0' || actnumber[ i + 1 ] == '1' )
                {
                    inWords[ j ] = '';
                } else
                {
                    inWords[ j ] = iWords[ actnumber[ i ] ];
                }
                if ( actnumber[ i + 1 ] !== '0' || actnumber[ i ] > '0' )
                {
                    inWords[ j ] = inWords[ j ] + ' thousand';
                }
                break;
            case 4:
                tensComplication();
                break;
            case 5:
                if ( actnumber[ i ] == '0' || actnumber[ i + 1 ] == '1' )
                {
                    inWords[ j ] = '';
                } else
                {
                    inWords[ j ] = iWords[ actnumber[ i ] ];
                }
                if ( actnumber[ i + 1 ] !== '0' || actnumber[ i ] > '0' )
                {
                    inWords[ j ] = inWords[ j ] + ' lakh';
                }
                break;
            case 6:
                tensComplication();
                break;
            case 7:
                if ( actnumber[ i ] == '0' || actnumber[ i + 1 ] == '1' )
                {
                    inWords[ j ] = '';
                } else
                {
                    inWords[ j ] = iWords[ actnumber[ i ] ];
                }
                inWords[ j ] = inWords[ j ] + ' crore';
                break;
            case 8:
                tensComplication();
                break;
            default:
                break;
        }
        j++;
    }


    inWords.reverse();
    for ( i = 0; i < inWords.length; i++ )
    {
        finalWord += inWords[ i ];
    }
    return finalWord;
}

//---------------------------------------


jQuery( document ).ready( function ()
{
    FormControlsAyra.init();
    $( '#payAmt' ).focusout( function ()
    {
        var rsAmt = $( this ).val();
        console.log( convertAmount( rsAmt ) );

    } );

} );


var Select2 = {
    init: function ()
    {
        $( "#m_select2_1,#pre_orderno,#myOrderListSelectA,#m_select2_1_technical,#m_select2_1_invoiceOrder,#item_fm_sample_no_bulk_N,#item_fm_sample_no,#item_fm_sample_bulk_N, #m_select2_1_validate" ).select2( {
            placeholder: "Select "
        } ), $( "#m_select2_2, #m_select2_2_validate" ).select2( {
            placeholder: "Select a state"
        } ), $( "#m_select2_3,#m_select2_3_baseFormula, #m_select2_3_validate" ).select2( {
            placeholder: "Select "
        } ), $( "#m_select2_3Aj, #m_select2_3AJ_validate" ).select2( {
            placeholder: "Select Users"
        } ), $( "#m_select2_4" ).select2( {
            placeholder: "Select a state",
            allowClear: !1
        } ), $( "#m_select2_5" ).select2( {
            placeholder: "Select a Item name",

        } ),
        $( "#m_select2_1_salesPar" ).select2( {
            placeholder: "Select Seles Person",

        } )
        $( "#m_select2_55" ).select2( {
            placeholder: "Select a value",
            data: [ {
                id: 0,
                text: "Enhancement"
            }, {
                id: 1,
                text: "Bug"
            }, {
                id: 2,
                text: "Duplicate"
            }, {
                id: 3,
                text: "Invalid"
            }, {
                id: 4,
                text: "Wontfix"
            } ]
        } ), $( "#m_select2_6" ).select2( {
            placeholder: "Search for git repositories",
            allowClear: !0,

            ajax: {
                url: "https://api.github.com/search/repositories",
                dataType: "json",
                delay: 250,
                data: function ( e )
                {
                    return {
                        q: e.term,
                        page: e.page
                    }
                },
                processResults: function ( e, t )
                {
                    return t.page = t.page || 1, {
                        results: e.items,
                        pagination: {
                            more: 30 * t.page < e.total_count
                        }
                    }
                },
                cache: !0
            },
            escapeMarkup: function ( e )
            {
                return e
            },
            minimumInputLength: 1,
            templateResult: function ( e )
            {
                if ( e.loading ) return e.text;
                var t = "<div class='select2-result-repository clearfix'><div class='select2-result-repository__meta'><div class='select2-result-repository__title'>" + e.full_name + "</div>";

                return e.description && ( t += "<div class='select2-result-repository__description'>" + e.description + "</div>" ), t += "<div class='select2-result-repository__statistics'><div class='select2-result-repository__forks'><i class='fa fa-flash'></i> " + e.forks_count + " Forks</div><div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> " + e.stargazers_count + " Stars</div><div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> " + e.watchers_count + " Watchers</div></div></div></div>"
            },
            templateSelection: function ( e )
            {
                return e.full_name || e.text
            }
        } ),
        $( "#m_select2_6_team" ).select2( {
            placeholder: "Search for Users",
            allowClear: !0,

            ajax: {
                url: "https://api.github.com/search/repositories",
                dataType: "json",
                delay: 250,
                data: function ( e )
                {
                    return {
                        q: e.term,
                        page: e.page
                    }
                },
                processResults: function ( e, t )
                {
                    return t.page = t.page || 1, {
                        results: e.items,
                        pagination: {
                            more: 30 * t.page < e.total_count
                        }
                    }
                },
                cache: !0
            },
            escapeMarkup: function ( e )
            {
                return e
            },
            minimumInputLength: 1,
            templateResult: function ( e )
            {
                if ( e.loading ) return e.text;
                var t = "<div class='select2-result-repository clearfix'><div class='select2-result-repository__meta'><div class='select2-result-repository__title'>" + e.full_name + "</div>";

                return `<div class="m-list-pics m-list-pics--l m--padding-left-10" style="backgroud-color:#FFFFFF">
                <a href="#"><img style="border:3px dotted red" src="http://demo.local/local/public/img/avatar.jpg" title=""></a>
                
</div>`
            },
            templateSelection: function ( e )
            {
                return e.full_name || e.text
            }
        } ),
         $( "#m_select2_12_1, #m_select2_12_2, #m_select2_12_3, #m_select2_12_4" ).select2( {
            placeholder: "Select an option"
        } ), $( "#m_select2_7" ).select2( {
            placeholder: "Select an option"
        } ), $( "#m_select2_8" ).select2( {
            placeholder: "Select an option"
        } ), $( "#m_select2_9" ).select2( {
            placeholder: "Select an option",
            maximumSelectionLength: 50
        } ),
            $( "#m_select2_9A" ).select2( {
                placeholder: "Select an Item",
                maximumSelectionLength: 50
            } ),
            $( "#m_select2_10" ).select2( {
                placeholder: "Select an option",
                minimumResultsForSearch: 1 / 0
            } ), $( "#m_select2_11" ).select2( {
                placeholder: "Add a tag",
                tags: !0
            } ), $( ".m-select2-general" ).select2( {
                placeholder: "Select an option"
            } ), $( "#m_select2_modal" ).on( "shown.bs.modal", function ()
            {
                $( "#m_select2_1_modal" ).select2( {
                    placeholder: "Select a city",
                    allowClear: !1,
                    ajax: {
                        url: BASE_URL + '/api/getCity',
                        dataType: "json",
                        delay: 250,
                        data: function ( e )
                        {
                            return {
                                q: e.term,
                                page: e.page
                            }
                        },
                        processResults: function ( e, t )
                        {
                            return t.page = t.page || 1, {
                                results: e.items,
                                pagination: {
                                    more: 30 * t.page < e.total_count
                                }
                            }
                        },
                        cache: !0
                    },
                    escapeMarkup: function ( e )
                    {
                        return e
                    },
                    minimumInputLength: 1,
                    templateResult: function ( e )
                    {
                        if ( e.loading ) return e.name;
                        var t = "<option>" + e.name + "</value>";
                        return t;
                    },
                    templateSelection: function ( e )
                    {
                        return e.name || e.id
                    }

                } ), $( "#m_select2_1_modal_edit" ).select2( {
                    placeholder: "Select a city",
                    allowClear: !1,
                    ajax: {
                        url: BASE_URL + '/api/getCity',
                        dataType: "json",
                        delay: 250,
                        data: function ( e )
                        {
                            return {
                                q: e.term,
                                page: e.page
                            }
                        },
                        processResults: function ( e, t )
                        {
                            return t.page = t.page || 1, {
                                results: e.items,
                                pagination: {
                                    more: 30 * t.page < e.total_count
                                }
                            }
                        },
                        cache: !0
                    },
                    escapeMarkup: function ( e )
                    {
                        return e
                    },
                    minimumInputLength: 1,
                    templateResult: function ( e )
                    {
                        if ( e.loading ) return e.name;
                        var t = "<option>" + e.name + "</value>";
                        return t;
                    },
                    templateSelection: function ( e )
                    {
                        return e.name || e.id
                    }

                } ), $( "#m_select2_2_modal" ).select2( {
                    placeholder: "Select a state"
                } ), $( "#m_select2_3_modal" ).select2( {
                    placeholder: "Select a state"
                } ), $( "#m_select2_4_modal" ).select2( {
                    placeholder: "Select a state",
                    allowClear: !1
                } )
            } )
    }
};
jQuery( document ).ready( function ()
{
    Select2.init()
} );


//== Class definition
var FormRepeater = function ()
{

    //== Private functions
    var demo1 = function ()
    {
        $( '#m_repeater_1' ).repeater( {
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function ()
            {
                $( this ).slideDown();
            },

            hide: function ( deleteElement )
            {
                $( this ).slideUp( deleteElement );
            },
            isFirstItemUndeletable: false
        } );
    }

    var demo2 = function ()
    {
        $( '#m_repeater_2' ).repeater( {
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function ()
            {
                $( this ).slideDown();
            },

            hide: function ( deleteElement )
            {
                if ( confirm( 'Are you sure you want to delete this element?' ) )
                {
                    $( this ).slideUp( deleteElement );
                }
            }
        } );
    }


    var demo3 = function ()
    {
        $( '#m_repeater_3' ).repeater( {
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function ()
            {
                $( this ).slideDown();
            },

            hide: function ( deleteElement )
            {
                if ( confirm( 'Are you sure you want to delete this element?' ) )
                {
                    $( this ).slideUp( deleteElement );
                }
            }
        } );
    }

    var demo4 = function ()
    {
        $( '#m_repeater_4' ).repeater( {
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function ()
            {
                $( this ).slideDown();
            },

            hide: function ( deleteElement )
            {
                $( this ).slideUp( deleteElement );
            }
        } );
    }

    var demo5 = function ()
    {
        $( '#m_repeater_5' ).repeater( {
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function ()
            {
                $( this ).slideDown();
            },

            hide: function ( deleteElement )
            {
                $( this ).slideUp( deleteElement );
            }
        } );
    }

    var demo6 = function ()
    {
        $( '#m_repeater_6' ).repeater( {
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function ()
            {
                $( this ).slideDown();
            },

            hide: function ( deleteElement )
            {
                $( this ).slideUp( deleteElement );
            }
        } );
    }
    return {
        // public functions
        init: function ()
        {
            demo1();
            demo2();
            demo3();
            demo4();
            demo5();
            demo6();
        }
    };
}();

jQuery( document ).ready( function ()
{
    FormRepeater.init();
} );

/*var DropzoneDemo = {
    init: function ()
    {
       // alert(55555);
        Dropzone.options.mDropzoneOne = {
            paramName: "file",
            maxFiles: 1,
            maxFilesize: 5,
            addRemoveLinks: !0,
            accept: function ( e, o )
            {
                "justinbieber.jpg" == e.name ? o( "Naha, you don't." ) : o()
            }
        }, Dropzone.options.mDropzoneTwo = {
            paramName: "file",
            maxFiles: 10,
            maxFilesize: 10,
            addRemoveLinks: !0,
            accept: function ( e, o )
            {
                "justinbieber.jpg" == e.name ? o( "Naha, you don't." ) : o()
            }
        }, Dropzone.options.mDropzoneThree = {
            paramName: "file",
            maxFiles: 10,
            maxFilesize: 10,
            addRemoveLinks: !0,
            acceptedFiles: "image/*,application/pdf,.psd",
            accept: function ( e, o )
            {
                "justinbieber.jpg" == e.name ? o( "Naha, you don't." ) : o()
            }
        },
            // multiple file upload
            Dropzone.options.imajkumar = {
                paramName: "file",
                maxFiles: 15,
                maxFilesize: 1000888,
                addRemoveLinks: !0,
                acceptedFiles: "image/*,application/png,.jpg",
                request.setRequestHeader("X-Requested-With", "XMLHttpRequest");
                //acceptedFiles: ".pdf",
                accept: function ( e, o )
                {
                    "justinbieber.jpg" == e.name ? o( "Naha, you don't." ) : o()
                },
                sending: function ( file, xhr, formData )
                {

                  //  publish_on = $( 'input[name="txtPayOrderIDInvAdd"]' ).val();
                    _token = $( 'meta[name="csrf-token"]' ).attr( 'content' );
                    alert(_token);
                    //formData.append( 'orderid', publish_on );
                    formData.append( '_token', _token );
                   
                }
            }

    }
};
DropzoneDemo.init();
*/

var BootstrapDatepicker = function ()
{
    var t;
    t = mUtil.isRTL() ? {
        leftArrow: '<i class="la la-angle-right"></i>',
        rightArrow: '<i class="la la-angle-left"></i>'
    } : {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        };
    return {
        init: function ()
        {
            $( "#m_datepicker_1,#m_datepicker_1ETA,#m_datepicker_1PAY, #shdate_input,#m_datepicker_1_validate" ).datepicker( {
                rtl: mUtil.isRTL(),
                todayHighlight: !0,
                orientation: "bottom left",
                templates: t,
                autoclose: true,
                format: 'yyyy-mm-dd',

            } ), $( "#m_datepicker_1_st,#m_datepicker_1_stE" ).datepicker( {
                rtl: mUtil.isRTL(),
                todayHighlight: !0,
                orientation: "bottom left",
                templates: t,
                autoclose: true,
                format: 'yyyy-mm-dd',

            } ), $( "#m_datepicker_1_modal" ).datepicker( {
                rtl: mUtil.isRTL(),
                todayHighlight: !0,
                orientation: "bottom left",
                templates: t
            } ), $( "#m_datepicker_2, #m_datepicker_2_validate" ).datepicker( {
                rtl: mUtil.isRTL(),
                todayHighlight: !0,
                orientation: "bottom left",
                templates: t
            } ), $( "#m_datepicker_2_modal" ).datepicker( {
                rtl: mUtil.isRTL(),
                todayHighlight: !0,
                orientation: "bottom left",
                templates: t
            } ), $( "#m_datepicker_3,#m_datepicker_3_5,#m_datepicker_3A,#m_datepicker_3AB, #m_datepicker_3_validate" ).datepicker( {
                rtl: mUtil.isRTL(),
                todayBtn: "linked",
                clearBtn: !0,
                todayHighlight: !0,
                templates: t,
                setDate: new Date(),
                autoclose: true,
                format: 'dd-M-yyyy',

            } ), $( "#m_datepicker_3_modal" ).datepicker( {
                rtl: mUtil.isRTL(),
                todayBtn: "linked",
                clearBtn: !0,
                todayHighlight: !0,
                templates: t
            } ), $( "#m_datepicker_4_1" ).datepicker( {
                rtl: mUtil.isRTL(),
                orientation: "top left",
                todayHighlight: !0,
                templates: t
            } ), $( "#m_datepicker_4_2" ).datepicker( {
                rtl: mUtil.isRTL(),
                orientation: "top right",
                todayHighlight: !0,
                templates: t
            } ), $( "#m_datepicker_4_3" ).datepicker( {
                rtl: mUtil.isRTL(),
                orientation: "bottom left",
                todayHighlight: !0,
                templates: t
            } ), $( "#m_datepicker_4_4" ).datepicker( {
                rtl: mUtil.isRTL(),
                orientation: "bottom right",
                todayHighlight: !0,
                templates: t
            } ), $( "#m_datepicker_5" ).datepicker( {
                rtl: mUtil.isRTL(),
                todayHighlight: !0,
                templates: t
            } ), $( "#m_datepicker_6" ).datepicker( {
                rtl: mUtil.isRTL(),
                todayHighlight: !0,
                templates: t
            } ),
            $( "#m_datepicker_8" ).datepicker( {
                rtl: mUtil.isRTL(),
                todayBtn: "linked",
                clearBtn: !0,
                todayHighlight: !0,
                templates: t,
                setDate: new Date(),
                autoclose: true,
                format: 'yyyy-mm-dd',
            } )
        }
    }
}();
jQuery( document ).ready( function ()
{
    BootstrapDatepicker.init()
} );

var ToastrDemo = function ()
{
    var t = function ()
    {
        var t, o = -1,
            e = 0;
        $( "#showtoast" ).click( function ()
        {
            var n, a = $( "#toastTypeGroup input:radio:checked" ).val(),
                i = $( "#message" ).val(),
                s = $( "#title" ).val() || "",
                r = $( "#showDuration" ),
                l = $( "#hideDuration" ),
                c = $( "#timeOut" ),
                p = $( "#extendedTimeOut" ),
                u = $( "#showEasing" ),
                d = $( "#hideEasing" ),
                h = $( "#showMethod" ),
                v = $( "#hideMethod" ),
                g = e++,
                f = $( "#addClear" ).prop( "checked" );
            toastr.options = {
                closeButton: $( "#closeButton" ).prop( "checked" ),
                debug: $( "#debugInfo" ).prop( "checked" ),
                newestOnTop: $( "#newestOnTop" ).prop( "checked" ),
                progressBar: $( "#progressBar" ).prop( "checked" ),
                positionClass: $( "#positionGroup input:radio:checked" ).val() || "toast-top-right",
                preventDuplicates: $( "#preventDuplicates" ).prop( "checked" ),
                onclick: null
            }, $( "#addBehaviorOnToastClick" ).prop( "checked" ) && ( toastr.options.onclick = function ()
            {
                alert( "You can perform some custom action after a toast goes away" )
            } ), r.val().length && ( toastr.options.showDuration = r.val() ), l.val().length && ( toastr.options.hideDuration = l.val() ), c.val().length && ( toastr.options.timeOut = f ? 0 : c.val() ), p.val().length && ( toastr.options.extendedTimeOut = f ? 0 : p.val() ), u.val().length && ( toastr.options.showEasing = u.val() ), d.val().length && ( toastr.options.hideEasing = d.val() ), h.val().length && ( toastr.options.showMethod = h.val() ), v.val().length && ( toastr.options.hideMethod = v.val() ), f && ( i = function ( t )
            {
                return t = t || "Clear itself?", t += '<br /><br /><button type="button" class="btn btn-outline-light btn-sm m-btn m-btn--air m-btn--wide clear">Yes</button>'
            }( i ), toastr.options.tapToDismiss = !1 ), i || ( ++o === ( n = [ "New order has been placed!", "Are you the six fingered man?", "Inconceivable!", "I do not think that means what you think it means.", "Have fun storming the castle!" ] ).length && ( o = 0 ), i = n[ o ] ), $( "#toastrOptions" ).text( "toastr.options = " + JSON.stringify( toastr.options, null, 2 ) + ";\n\ntoastr." + a + '("' + i + ( s ? '", "' + s : "" ) + '");' );
            var k = toastr[ a ]( i, s );
            t = k, void 0 !== k && ( k.find( "#okBtn" ).length && k.delegate( "#okBtn", "click", function ()
            {
                alert( "you clicked me. i was toast #" + g + ". goodbye!" ), k.remove()
            } ), k.find( "#surpriseBtn" ).length && k.delegate( "#surpriseBtn", "click", function ()
            {
                alert( "Surprise! you clicked me. i was toast #" + g + ". You could perform an action here." )
            } ), k.find( ".clear" ).length && k.delegate( ".clear", "click", function ()
            {
                toastr.clear( k, {
                    force: !0
                } )
            } ) )
        } ), $( "#clearlasttoast" ).click( function ()
        {
            toastr.clear( t )
        } ), $( "#cleartoasts" ).click( function ()
        {
            toastr.clear()
        } )
    };
    return {
        init: function ()
        {
            t()
        }
    }
}();
jQuery( document ).ready( function ()
{
    ToastrDemo.init()
} );


var BlockUIDemo = {
    init: function ()
    {
        $( "#m_blockui_1_1" ).click( function ()
        {
            mApp.block( "#m_blockui_1_content", {} ), setTimeout( function ()
            {
                mApp.unblock( "#m_blockui_1_content" )
            }, 2e3 )
        } ), $( "#m_blockui_1_2" ).click( function ()
        {
            mApp.block( "#m_blockui_1_content", {
                overlayColor: "#000000",
                state: "primary"
            } ), setTimeout( function ()
            {
                mApp.unblock( "#m_blockui_1_content" )
            }, 2e3 )
        } ), $( "#m_blockui_1_3" ).click( function ()
        {
            mApp.block( "#m_blockui_1_content", {
                overlayColor: "#000000",
                type: "loader",
                state: "success",
                size: "lg"
            } ), setTimeout( function ()
            {
                mApp.unblock( "#m_blockui_1_content" )
            }, 2e3 )
        } ), $( "#m_blockui_1_4" ).click( function ()
        {
            mApp.block( "#m_blockui_1_content", {
                overlayColor: "#000000",
                type: "loader",
                state: "success",
                message: "Please wait..."
            } ), setTimeout( function ()
            {
                mApp.unblock( "#m_blockui_1_content" )
            }, 2e3 )
        } ), $( "#m_blockui_1_5" ).click( function ()
        {
            mApp.block( "#m_blockui_1_content", {
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Processing..."
            } ), setTimeout( function ()
            {
                mApp.unblock( "#m_blockui_1_content" )
            }, 2e3 )
        } ), $( "#m_blockui_2_1" ).click( function ()
        {
            mApp.block( "#m_blockui_2_portlet", {} ), setTimeout( function ()
            {
                mApp.unblock( "#m_blockui_2_portlet" )
            }, 2e3 )
        } ), $( "#m_blockui_2_2" ).click( function ()
        {
            mApp.block( "#m_blockui_2_portlet", {
                overlayColor: "#000000",
                state: "primary"
            } ), setTimeout( function ()
            {
                mApp.unblock( "#m_blockui_2_portlet" )
            }, 2e3 )
        } ), $( "#m_blockui_2_3" ).click( function ()
        {
            mApp.block( "#m_blockui_2_portlet", {
                overlayColor: "#000000",
                type: "loader",
                state: "success",
                size: "lg"
            } ), setTimeout( function ()
            {
                mApp.unblock( "#m_blockui_2_portlet" )
            }, 2e3 )
        } ), $( "#m_blockui_2_4" ).click( function ()
        {
            mApp.block( "#m_blockui_2_portlet", {
                overlayColor: "#000000",
                type: "loader",
                state: "success",
                message: "Please wait..."
            } ), setTimeout( function ()
            {
                mApp.unblock( "#m_blockui_2_portlet" )
            }, 2e3 )
        } ), $( "#m_blockui_2_5" ).click( function ()
        {
            mApp.block( "#m_blockui_2_portlet", {
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Processing..."
            } ), setTimeout( function ()
            {
                mApp.unblock( "#m_blockui_2_portlet" )
            }, 2e3 )
        } ), $( "#m_blockui_3_1" ).click( function ()
        {
            mApp.blockPage(), setTimeout( function ()
            {
                mApp.unblockPage()
            }, 2e3 )
        } ), $( "#m_blockui_3_2" ).click( function ()
        {
            mApp.blockPage( {
                overlayColor: "#000000",
                state: "primary"
            } ), setTimeout( function ()
            {
                mApp.unblockPage()
            }, 2e3 )
        } ), $( "#m_blockui_3_3" ).click( function ()
        {
            mApp.blockPage( {
                overlayColor: "#000000",
                type: "loader",
                state: "success",
                size: "lg"
            } ), setTimeout( function ()
            {
                mApp.unblockPage()
            }, 2e3 )
        } ), $( "#m_blockui_3_4" ).click( function ()
        {
            mApp.blockPage( {
                overlayColor: "#000000",
                type: "loader",
                state: "success",
                message: "Please wait..."
            } ), setTimeout( function ()
            {
                mApp.unblockPage()
            }, 2e3 )
        } ), $( "#m_blockui_3_5" ).click( function ()
        {
            mApp.blockPage( {
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Processing..."
            } ), setTimeout( function ()
            {
                mApp.unblockPage()
            }, 2e3 )
        } ), $( "#m_blockui_4_1" ).click( function ()
        {
            mApp.block( "#m_blockui_4_1_modal .modal-content", {} ), setTimeout( function ()
            {
                mApp.unblock( "#m_blockui_4_1_modal .modal-content" )
            }, 2e3 )
        } ), $( "#m_blockui_4_2" ).click( function ()
        {
            mApp.block( "#m_blockui_4_2_modal .modal-content", {
                overlayColor: "#000000",
                state: "primary"
            } ), setTimeout( function ()
            {
                mApp.unblock( "#m_blockui_4_2_modal .modal-content" )
            }, 2e3 )
        } ), $( "#m_blockui_4_3" ).click( function ()
        {
            mApp.block( "#m_blockui_4_3_modal .modal-content", {
                overlayColor: "#000000",
                type: "loader",
                state: "success",
                size: "lg"
            } ), setTimeout( function ()
            {
                mApp.unblock( "#m_blockui_4_3_modal .modal-content" )
            }, 2e3 )
        } ), $( "#m_blockui_4_4" ).click( function ()
        {
            mApp.block( "#m_blockui_4_4_modal .modal-content", {
                overlayColor: "#000000",
                type: "loader",
                state: "success",
                message: "Please wait..."
            } ), setTimeout( function ()
            {
                mApp.unblock( "#m_blockui_4_4_modal .modal-content" )
            }, 2e3 )
        } ), $( "#m_blockui_4_5" ).click( function ()
        {
            mApp.block( "#m_blockui_4_5_modal .modal-content", {
                overlayColor: "#000000",
                type: "loader",
                state: "primary",
                message: "Processing..."
            } ), setTimeout( function ()
            {
                mApp.unblock( "#m_blockui_4_5_modal .modal-content" )
            }, 2e3 )
        } )
    }
};
jQuery( document ).ready( function ()
{
    BlockUIDemo.init()

} );







var BootstrapDaterangepicker = {
    init: function ()
    {
        ! function ()
        {
            $( "#m_daterangepicker_1, #m_daterangepicker_1_modal" ).daterangepicker( {
                buttonClasses: "m-btn btn",
                applyClass: "btn-primary",
                cancelClass: "btn-secondary"
            } ), $( "#m_daterangepicker_2" ).daterangepicker( {
                buttonClasses: "m-btn btn",
                applyClass: "btn-primary",
                cancelClass: "btn-secondary"
            }, function ( a, t, n )
            {
                $( "#m_daterangepicker_2 .form-control" ).val( a.format( "YYYY-MM-DD" ) + " / " + t.format( "YYYY-MM-DD" ) )
            } ), $( "#m_daterangepicker_2_modal" ).daterangepicker( {
                buttonClasses: "m-btn btn",
                applyClass: "btn-primary",
                cancelClass: "btn-secondary"
            }, function ( a, t, n )
            {
                $( "#m_daterangepicker_2 .form-control" ).val( a.format( "YYYY-MM-DD" ) + " / " + t.format( "YYYY-MM-DD" ) )
            } ), $( "#m_daterangepicker_3" ).daterangepicker( {
                buttonClasses: "m-btn btn",
                applyClass: "btn-primary",
                cancelClass: "btn-secondary"
            }, function ( a, t, n )
            {
                $( "#m_daterangepicker_3 .form-control" ).val( a.format( "YYYY-MM-DD" ) + " / " + t.format( "YYYY-MM-DD" ) )
            } ), $( "#m_daterangepicker_3_modal" ).daterangepicker( {
                buttonClasses: "m-btn btn",
                applyClass: "btn-primary",
                cancelClass: "btn-secondary"
            }, function ( a, t, n )
            {
                $( "#m_daterangepicker_3 .form-control" ).val( a.format( "YYYY-MM-DD" ) + " / " + t.format( "YYYY-MM-DD" ) )
            } ), $( "#m_daterangepicker_4" ).daterangepicker( {
                buttonClasses: "m-btn btn",
                applyClass: "btn-primary",
                cancelClass: "btn-secondary",
                timePicker: !0,
                timePickerIncrement: 30,
                locale: {
                    format: "MM/DD/YYYY h:mm A"
                }
            }, $( "#m_datetimepicker_aj" ).datetimepicker( {
                format: "dd-mm-yyyy  HH:ii P",
                showMeridian: !0,
                todayHighlight: !0,
                autoclose: !0,
                pickerPosition: "bottom-left"
            } ),
                function ( a, t, n )
                {
                    $( "#m_daterangepicker_4 .form-control" ).val( a.format( "MM/DD/YYYY h:mm A" ) + " / " + t.format( "MM/DD/YYYY h:mm A" ) )
                } ), $( "#m_daterangepicker_5" ).daterangepicker( {
                    buttonClasses: "m-btn btn",
                    applyClass: "btn-primary",
                    cancelClass: "btn-secondary",
                    singleDatePicker: !0,
                    showDropdowns: !0,
                    locale: {
                        format: "MM/DD/YYYY"
                    }
                }, function ( a, t, n )
                {
                    $( "#m_daterangepicker_5 .form-control" ).val( a.format( "MM/DD/YYYY" ) + " / " + t.format( "MM/DD/YYYY" ) )
                } );
            var a = moment().subtract( 29, "days" ),
                t = moment();

            $( "#m_daterangepicker_6_note" ).daterangepicker( {
                buttonClasses: "m-btn btn",
                applyClass: "btn-primary",
                cancelClass: "btn-secondary",
                locale: {
                    format: "DD/MM/YYYY"
                },

                startDate: moment(),
                endDate: moment().add( 3, "days" ),
                ranges: {
                    Today: [ moment(), moment() ],
                    Tomorrow: [ moment().add( 1, "days" ), moment().add( 1, "days" ) ],
                    "3 Days": [ moment(), moment().add( 3, "days" ) ],
                    "7 Days": [ moment(), moment().add( 6, "days" ) ],
                    "15 Days": [ moment(), moment().add( 15, "days" ) ],
                    "30 Days": [ moment(), moment().add( 30, "days" ) ]


                }
            }, function ( t, a, n )
            {

                // $("#m_daterangepicker_6_note").val(t.format("DD/MM/YYYY") + " To " + a.format("DD/MM/YYYY"))
            } ),
                $( "#m_daterangepicker_6" ).daterangepicker( {
                    buttonClasses: "m-btn btn",
                    applyClass: "btn-primary",
                    cancelClass: "btn-secondary",
                    startDate: a,
                    endDate: t,
                    ranges: {
                        Today: [ moment(), moment() ],
                        Tomorrow: [ moment().add( 1, "days" ), moment().add( 1, "days" ) ],
                        "7 Days": [ moment().add( 6, "days" ), moment() ],
                        "15 Days": [ moment().add( 15, "days" ), moment() ],

                        "30 Days": [ moment().add( 29, "days" ), moment() ],
                        "This Month": [ moment().startOf( "month" ), moment().endOf( "month" ) ],
                        "Next Month": [ moment().add( 1, "month" ).startOf( "month" ), moment().add( 1, "month" ).endOf( "month" ) ]
                    }
                }, function ( a, t, n )
                {
                    $( "#m_daterangepicker_6 .form-control" ).val( a.format( "DD/MM/YYYY" ) + " - " + t.format( "DD/MM/YYYY" ) )
                } )
        }(), $( "#m_daterangepicker_1_validate" ).daterangepicker( {
            buttonClasses: "m-btn btn",
            applyClass: "btn-primary",
            cancelClass: "btn-secondary"
        }, function ( a, t, n )
        {
            $( "#m_daterangepicker_1_validate .form-control" ).val( a.format( "YYYY-MM-DD" ) + " / " + t.format( "YYYY-MM-DD" ) )
        } ), $( "#m_daterangepicker_2_validate" ).daterangepicker( {
            buttonClasses: "m-btn btn",
            applyClass: "btn-primary",
            cancelClass: "btn-secondary"
        }, function ( a, t, n )
        {
            $( "#m_daterangepicker_3_validate .form-control" ).val( a.format( "YYYY-MM-DD" ) + " / " + t.format( "YYYY-MM-DD" ) )
        } ), $( "#m_daterangepicker_3_validate" ).daterangepicker( {
            buttonClasses: "m-btn btn",
            applyClass: "btn-primary",
            cancelClass: "btn-secondary"
        }, function ( a, t, n )
        {
            $( "#m_daterangepicker_3_validate .form-control" ).val( a.format( "YYYY-MM-DD" ) + " / " + t.format( "YYYY-MM-DD" ) )
        } )
    }
};
jQuery( document ).ready( function ()
{
    BootstrapDaterangepicker.init()
} );




var USERLISTHTML_INDMART = {
    init: function ()
    {
        $( "#m_table_usersListINDMART" ).DataTable( {
            responsive: !0,
            order: [ [ 0, 'asc' ], [ 1, 'asc' ] ],
            columnDefs: [
                {
                    targets: [ 0 ],
                    visible: !1
                },
                {
                    targets: -1,
                    title: "Actions",

                    render: function ( a, t, e, n )
                    {
                        //console.log(e[0]);
                        var edit_URL = 'users/lead/' + e[ 0 ] + '/edit';
                        var userPer_URL = 'users/permission/' + e[ 0 ];

                        //     return `<a href="${edit_URL}" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                        //     <i class="fa flaticon-edit"></i>
                        // </a>
                        // <a href="${userPer_URL}" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                        // 											<i class="fa flaticon-rotate"></i>
                        // 										</a>
                        // <a href="javascript::void(0)" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                        // 											<i class="fa flaticon-delete "></i>
                        // 										</a>`




                        return ` <a href="javascript::void(0)" onclick="viewAllINDMartData(${ e[ 0 ] })" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="fa flaticon-eye "></i>
                 </a>

                 <span class="dropdown"><a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                 <i class="la la-ellipsis-h"></i></a>
                 <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAssignModel(${e[ 0 ] })" ><i class="la la-user"></i> Assign</a>
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadIrrelevantModel(${e[ 0 ] })" ><i class="la la-leaf"></i> Irrelevant</a>
                  <a class="dropdown-item" href="javascript::void(0)" onclick="LeadAddNotesModel(${e[ 0 ] })" ><i class="la la-plus"></i> Add Notes</a>
                  </div></span>
                  <a href="${edit_URL }" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">
                  <i class="la la-edit"></i> </a>`;
                    }
                }, {
                    targets: 6,
                    render: function ( a, t, e, n )
                    {
                        var s = {
                            1: {
                                title: "Active",
                                class: "m-badge--success"
                            },
                            2: {
                                title: "Block",
                                class: " m-badge--danger"
                            },
                            3: {
                                title: "Canceled",
                                class: " m-badge--primary"
                            },
                            4: {
                                title: "Success",
                                class: " m-badge--success"
                            },
                            5: {
                                title: "Info",
                                class: " m-badge--info"
                            },
                            6: {
                                title: "Danger",
                                class: " m-badge--danger"
                            },
                            7: {
                                title: "Warning",
                                class: " m-badge--warning"
                            }
                        };
                        return void 0 === s[ a ] ? a : '<span class="m-badge ' + s[ a ].class + ' m-badge--wide">' + s[ a ].title + "</span>"
                    }
                }, {
                    targets: 7,
                    render: function ( a, t, e, n )
                    {
                        var s = {
                            1: {
                                title: "Active",
                                state: "success"
                            },
                            2: {
                                title: "Block",
                                state: "Danger"
                            }

                        };
                        return void 0 === s[ a ] ? a : '<span class="m-badge m-badge--' + s[ a ].state + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + s[ a ].state + '">' + s[ a ].title + "</span>"
                    }
                } ]
        } )
    }
};






//HTML DataSource
var USERLISTHTML = {
    init: function ()
    {
        $( "#m_table_usersList" ).DataTable( {
            responsive: !0,
            order: [ [ 0, 'asc' ], [ 1, 'asc' ] ],
            columnDefs: [ {
                targets: -1,
                title: "Actions",

                render: function ( a, t, e, n )
                {
                    //console.log(e[0]);
                    var edit_URL = 'users/' + e[ 0 ] + '/edit';
                    var userPer_URL = 'users/permission/' + e[ 0 ];

                    return `<a href="${ edit_URL }" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="fa flaticon-edit"></i>
                </a>
                <a href="${userPer_URL }" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
															<i class="fa flaticon-rotate"></i>
														</a>
                <a href="javascript::void(0)"  onclick="UserDelleteSoft(${e[0]})"  class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
															<i class="fa flaticon-delete "></i>
														</a>
                <a href="javascript::void(0)" title="Authorize login parmanent "  onclick="UserActivate(${e[0]})"  class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="fa flaticon-lock "></i>
                 </a>
                 <a href="javascript::void(0)" title="Authorize login Today only "  onclick="UserActivateTemp(${e[0]})"  class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                 <i class="fa flaticon-lock "></i>
                  </a>
                  <a href="javascript::void(0)" title="Activate or Block "  onclick="UserActivateOrBlock(${e[0]})"  class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa flaticon-lock "></i>
                   </a>
                 `;

                                                        

                }
            }, {
                targets: 6,
                render: function ( a, t, e, n )
                {
                    var s = {
                        1: {
                            title: "Active",
                            class: "m-badge--success"
                        },
                        2: {
                            title: "Block",
                            class: " m-badge--danger"
                        },
                        3: {
                            title: "Canceled",
                            class: " m-badge--primary"
                        },
                        4: {
                            title: "Success",
                            class: " m-badge--success"
                        },
                        5: {
                            title: "Info",
                            class: " m-badge--info"
                        },
                        6: {
                            title: "Danger",
                            class: " m-badge--danger"
                        },
                        7: {
                            title: "Warning",
                            class: " m-badge--warning"
                        }
                    };
                    return void 0 === s[ a ] ? a : '<span class="m-badge ' + s[ a ].class + ' m-badge--wide">' + s[ a ].title + "</span>"
                }
            }, {
                targets: 7,
                render: function ( a, t, e, n )
                {
                    var s = {
                        1: {
                            title: "Active",
                            state: "success"
                        },
                        2: {
                            title: "Block",
                            state: "Danger"
                        }

                    };
                    return void 0 === s[ a ] ? a : '<span class="m-badge m-badge--' + s[ a ].state + ' m-badge--dot"></span>&nbsp;<span class="m--font-bold m--font-' + s[ a ].state + '">' + s[ a ].title + "</span>"
                }
            } ]
        } )
    }
};

var ROLESLISTHTML = {
    init: function ()
    {
        $( "#m_table_rolesList" ).DataTable( {
            responsive: !0,
            order: [ [ 0, 'asc' ], [ 1, 'asc' ] ],
            columnDefs: [ {
                targets: -1,
                title: "Actions",

                render: function ( a, t, e, n )
                {
                    //console.log(e[0]);
                    var edit_URL = 'roles/' + e[ 0 ] + '/edit';
                    return `<a href="${ edit_URL }" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="fa flaticon-edit"></i>
                </a>
                <a href="javascript::void(0)" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
															<i class="fa flaticon-delete "></i>
														</a>`

                }
            },
            ]
        } )
    }
};

var PERMISSIONSLISTHTML = {
    init: function ()
    {
        $( "#m_table_permissionList" ).DataTable( {
            responsive: !0,
            order: [ [ 0, 'asc' ], [ 1, 'asc' ] ],
            columnDefs: [ {
                targets: -1,
                title: "Actions",
                render: function ( a, t, e, n )
                {
                    //console.log(e[0]);
                    var edit_URL_P = 'permissions/' + e[ 0 ] + '/edit';
                    return `<a href="${ edit_URL_P }" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="fa flaticon-edit"></i>
                </a>
                <a href="javascript::void(0)" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
															<i class="fa flaticon-delete "></i>
														</a>`

                }
            },
            ]
        } )
    }
};

jQuery( document ).ready( function ()
{
    USERLISTHTML.init();
    ROLESLISTHTML.init();
    PERMISSIONSLISTHTML.init();
    USERLISTHTML_INDMART.init();
} );
//HTML DataSource


var BootstrapSwitch = {
    init: function ()
    {
        //$("[data-switch=true]").bootstrapSwitch();
        $( ".status" ).bootstrapSwitch();
        $( ".status" ).on( 'switchChange.bootstrapSwitch', function ( event, state )
        {
            // var permi=this.attr('data').val();


            var perm_data = this.attributes.data.nodeValue;
            var perm_state = state;
            //ajax call
            var formData = {
                'perm_data': perm_data,
                'perm_state': perm_state,
                '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
                'user_id': $( '#p_userid' ).val()
            };
            $.ajax( {
                url: BASE_URL + '/setUserPermission',
                type: 'POST',
                data: formData,
                success: function ( res )
                {

                    swal( {
                        title: "Permissions",
                        text: res.Message,
                        type: res.type,
                        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
                        onClose: function ( e )
                        {
                            // location.reload();
                        }
                    } )

                },
                dataType: 'json'
            } );
            //ajax call       
            event.preventDefault();
        } );

    }
};
jQuery( document ).ready( function ()
{
    BootstrapSwitch.init()
} );

/*!
 * Validator v0.11.5 for Bootstrap 3, by @1000hz
 * Copyright 2016 Cina Saffary
 * Licensed under http://opensource.org/licenses/MIT
 *
 * https://github.com/1000hz/bootstrap-validator
 */

+function ( a ) { "use strict"; function b( b ) { return b.is( '[type="checkbox"]' ) ? b.prop( "checked" ) : b.is( '[type="radio"]' ) ? !!a( '[name="' + b.attr( "name" ) + '"]:checked' ).length : b.val() } function c( b ) { return this.each( function () { var c = a( this ), e = a.extend( {}, d.DEFAULTS, c.data(), "object" == typeof b && b ), f = c.data( "bs.validator" ); ( f || "destroy" != b ) && ( f || c.data( "bs.validator", f = new d( this, e ) ), "string" == typeof b && f[ b ]() ) } ) } var d = function ( c, e ) { this.options = e, this.validators = a.extend( {}, d.VALIDATORS, e.custom ), this.$element = a( c ), this.$btn = a( 'button[type="submit"], input[type="submit"]' ).filter( '[form="' + this.$element.attr( "id" ) + '"]' ).add( this.$element.find( 'input[type="submit"], button[type="submit"]' ) ), this.update(), this.$element.on( "input.bs.validator change.bs.validator focusout.bs.validator", a.proxy( this.onInput, this ) ), this.$element.on( "submit.bs.validator", a.proxy( this.onSubmit, this ) ), this.$element.on( "reset.bs.validator", a.proxy( this.reset, this ) ), this.$element.find( "[data-match]" ).each( function () { var c = a( this ), d = c.data( "match" ); a( d ).on( "input.bs.validator", function () { b( c ) && c.trigger( "input.bs.validator" ) } ) } ), this.$inputs.filter( function () { return b( a( this ) ) } ).trigger( "focusout" ), this.$element.attr( "novalidate", !0 ), this.toggleSubmit() }; d.VERSION = "0.11.5", d.INPUT_SELECTOR = ':input:not([type="hidden"], [type="submit"], [type="reset"], button)', d.FOCUS_OFFSET = 20, d.DEFAULTS = { delay: 500, html: !1, disable: !0, focus: !0, custom: {}, errors: { match: "Does not match", minlength: "Not long enough" }, feedback: { success: "glyphicon-ok", error: "glyphicon-remove" } }, d.VALIDATORS = { "native": function ( a ) { var b = a[ 0 ]; return b.checkValidity ? !b.checkValidity() && !b.validity.valid && ( b.validationMessage || "error!" ) : void 0 }, match: function ( b ) { var c = b.data( "match" ); return b.val() !== a( c ).val() && d.DEFAULTS.errors.match }, minlength: function ( a ) { var b = a.data( "minlength" ); return a.val().length < b && d.DEFAULTS.errors.minlength } }, d.prototype.update = function () { return this.$inputs = this.$element.find( d.INPUT_SELECTOR ).add( this.$element.find( '[data-validate="true"]' ) ).not( this.$element.find( '[data-validate="false"]' ) ), this }, d.prototype.onInput = function ( b ) { var c = this, d = a( b.target ), e = "focusout" !== b.type; this.$inputs.is( d ) && this.validateInput( d, e ).done( function () { c.toggleSubmit() } ) }, d.prototype.validateInput = function ( c, d ) { var e = ( b( c ), c.data( "bs.validator.errors" ) ); c.is( '[type="radio"]' ) && ( c = this.$element.find( 'input[name="' + c.attr( "name" ) + '"]' ) ); var f = a.Event( "validate.bs.validator", { relatedTarget: c[ 0 ] } ); if ( this.$element.trigger( f ), !f.isDefaultPrevented() ) { var g = this; return this.runValidators( c ).done( function ( b ) { c.data( "bs.validator.errors", b ), b.length ? d ? g.defer( c, g.showErrors ) : g.showErrors( c ) : g.clearErrors( c ), e && b.toString() === e.toString() || ( f = b.length ? a.Event( "invalid.bs.validator", { relatedTarget: c[ 0 ], detail: b } ) : a.Event( "valid.bs.validator", { relatedTarget: c[ 0 ], detail: e } ), g.$element.trigger( f ) ), g.toggleSubmit(), g.$element.trigger( a.Event( "validated.bs.validator", { relatedTarget: c[ 0 ] } ) ) } ) } }, d.prototype.runValidators = function ( c ) { function d( a ) { return c.data( a + "-error" ) } function e() { var a = c[ 0 ].validity; return a.typeMismatch ? c.data( "type-error" ) : a.patternMismatch ? c.data( "pattern-error" ) : a.stepMismatch ? c.data( "step-error" ) : a.rangeOverflow ? c.data( "max-error" ) : a.rangeUnderflow ? c.data( "min-error" ) : a.valueMissing ? c.data( "required-error" ) : null } function f() { return c.data( "error" ) } function g( a ) { return d( a ) || e() || f() } var h = [], i = a.Deferred(); return c.data( "bs.validator.deferred" ) && c.data( "bs.validator.deferred" ).reject(), c.data( "bs.validator.deferred", i ), a.each( this.validators, a.proxy( function ( a, d ) { var e = null; ( b( c ) || c.attr( "required" ) ) && ( c.data( a ) || "native" == a ) && ( e = d.call( this, c ) ) && ( e = g( a ) || e, !~h.indexOf( e ) && h.push( e ) ) }, this ) ), !h.length && b( c ) && c.data( "remote" ) ? this.defer( c, function () { var d = {}; d[ c.attr( "name" ) ] = b( c ), a.get( c.data( "remote" ), d ).fail( function ( a, b, c ) { h.push( g( "remote" ) || c ) } ).always( function () { i.resolve( h ) } ) } ) : i.resolve( h ), i.promise() }, d.prototype.validate = function () { var b = this; return a.when( this.$inputs.map( function () { return b.validateInput( a( this ), !1 ) } ) ).then( function () { b.toggleSubmit(), b.focusError() } ), this }, d.prototype.focusError = function () { if ( this.options.focus ) { var b = a( ".has-error:first :input" ); 0 !== b.length && ( a( "html, body" ).animate( { scrollTop: b.offset().top - d.FOCUS_OFFSET }, 250 ), b.focus() ) } }, d.prototype.showErrors = function ( b ) { var c = this.options.html ? "html" : "text", d = b.data( "bs.validator.errors" ), e = b.closest( ".form-group" ), f = e.find( ".help-block.with-errors" ), g = e.find( ".form-control-feedback" ); d.length && ( d = a( "<ul/>" ).addClass( "list-unstyled" ).append( a.map( d, function ( b ) { return a( "<li/>" )[ c ]( b ) } ) ), void 0 === f.data( "bs.validator.originalContent" ) && f.data( "bs.validator.originalContent", f.html() ), f.empty().append( d ), e.addClass( "has-error has-danger" ), e.hasClass( "has-feedback" ) && g.removeClass( this.options.feedback.success ) && g.addClass( this.options.feedback.error ) && e.removeClass( "has-success" ) ) }, d.prototype.clearErrors = function ( a ) { var c = a.closest( ".form-group" ), d = c.find( ".help-block.with-errors" ), e = c.find( ".form-control-feedback" ); d.html( d.data( "bs.validator.originalContent" ) ), c.removeClass( "has-error has-danger has-success" ), c.hasClass( "has-feedback" ) && e.removeClass( this.options.feedback.error ) && e.removeClass( this.options.feedback.success ) && b( a ) && e.addClass( this.options.feedback.success ) && c.addClass( "has-success" ) }, d.prototype.hasErrors = function () { function b() { return !!( a( this ).data( "bs.validator.errors" ) || [] ).length } return !!this.$inputs.filter( b ).length }, d.prototype.isIncomplete = function () { function c() { var c = b( a( this ) ); return !( "string" == typeof c ? a.trim( c ) : c ) } return !!this.$inputs.filter( "[required]" ).filter( c ).length }, d.prototype.onSubmit = function ( a ) { this.validate(), ( this.isIncomplete() || this.hasErrors() ) && a.preventDefault() }, d.prototype.toggleSubmit = function () { this.options.disable && this.$btn.toggleClass( "disabled", this.isIncomplete() || this.hasErrors() ) }, d.prototype.defer = function ( b, c ) { return c = a.proxy( c, this, b ), this.options.delay ? ( window.clearTimeout( b.data( "bs.validator.timeout" ) ), void b.data( "bs.validator.timeout", window.setTimeout( c, this.options.delay ) ) ) : c() }, d.prototype.reset = function () { return this.$element.find( ".form-control-feedback" ).removeClass( this.options.feedback.error ).removeClass( this.options.feedback.success ), this.$inputs.removeData( [ "bs.validator.errors", "bs.validator.deferred" ] ).each( function () { var b = a( this ), c = b.data( "bs.validator.timeout" ); window.clearTimeout( c ) && b.removeData( "bs.validator.timeout" ) } ), this.$element.find( ".help-block.with-errors" ).each( function () { var b = a( this ), c = b.data( "bs.validator.originalContent" ); b.removeData( "bs.validator.originalContent" ).html( c ) } ), this.$btn.removeClass( "disabled" ), this.$element.find( ".has-error, .has-danger, .has-success" ).removeClass( "has-error has-danger has-success" ), this }, d.prototype.destroy = function () { return this.reset(), this.$element.removeAttr( "novalidate" ).removeData( "bs.validator" ).off( ".bs.validator" ), this.$inputs.off( ".bs.validator" ), this.options = null, this.validators = null, this.$element = null, this.$btn = null, this }; var e = a.fn.validator; a.fn.validator = c, a.fn.validator.Constructor = d, a.fn.validator.noConflict = function () { return a.fn.validator = e, this }, a( window ).on( "load", function () { a( 'form[data-toggle="validator"]' ).each( function () { var b = a( this ); c.call( b, b.data() ) } ) } ) }( jQuery );




/*!
 * SmartWizard v4.3.1
 * The awesome jQuery step wizard plugin with Bootstrap support
 * http://www.techlaboratory.net/smartwizard
 *
 * Created by Dipu Raj
 * http://dipuraj.me
 *
 * Licensed under the terms of the MIT License
 * https://github.com/techlab/SmartWizard/blob/master/LICENSE
 */
!function ( t, s, e, n ) { "use strict"; function i( s, e ) { this.options = t.extend( !0, {}, o, e ), this.main = t( s ), this.nav = this.main.children( "ul" ), this.steps = t( "li > a", this.nav ), this.container = this.main.children( "div" ), this.pages = this.container.children( "div" ), this.current_index = null, this.options.toolbarSettings.toolbarButtonPosition = "right" === this.options.toolbarSettings.toolbarButtonPosition ? "end" : this.options.toolbarSettings.toolbarButtonPosition, this.options.toolbarSettings.toolbarButtonPosition = "left" === this.options.toolbarSettings.toolbarButtonPosition ? "start" : this.options.toolbarSettings.toolbarButtonPosition, this.options.theme = null === this.options.theme || "" === this.options.theme ? "default" : this.options.theme, this.init() } var o = { selected: 0, keyNavigation: !0, autoAdjustHeight: !0, cycleSteps: !1, backButtonSupport: !0, useURLhash: !0, showStepURLhash: !0, lang: { next: "Next", previous: "Previous" }, toolbarSettings: { toolbarPosition: "bottom", toolbarButtonPosition: "end", showNextButton: !0, showPreviousButton: !0, toolbarExtraButtons: [] }, anchorSettings: { anchorClickable: !0, enableAllAnchors: !1, markDoneStep: !0, markAllPreviousStepsAsDone: !0, removeDoneStepOnNavigateBack: !1, enableAnchorOnDoneStep: !0 }, contentURL: null, contentCache: !0, ajaxSettings: {}, disabledSteps: [], errorSteps: [], hiddenSteps: [], theme: "default", transitionEffect: "none", transitionSpeed: "400" }; t.extend( i.prototype, { init: function () { this._setElements(), this._setToolbar(), this._setEvents(); var e = this.options.selected; if ( this.options.useURLhash ) { var n = s.location.hash; if ( n && n.length > 0 ) { var i = t( "a[href*='" + n + "']", this.nav ); if ( i.length > 0 ) { var o = this.steps.index( i ); e = o >= 0 ? o : e } } } e > 0 && this.options.anchorSettings.markDoneStep && this.options.anchorSettings.markAllPreviousStepsAsDone && this.steps.eq( e ).parent( "li" ).prevAll().addClass( "done" ), this._showStep( e ) }, _setElements: function () { this.main.addClass( "sw-main sw-theme-" + this.options.theme ), this.nav.addClass( "nav nav-tabs step-anchor" ).children( "li" ).addClass( "nav-item" ).children( "a" ).addClass( "nav-link" ), this.options.anchorSettings.enableAllAnchors !== !1 && this.options.anchorSettings.anchorClickable !== !1 && this.steps.parent( "li" ).addClass( "clickable" ), this.container.addClass( "sw-container tab-content" ), this.pages.addClass( "tab-pane step-content" ); var s = this; return this.options.disabledSteps && this.options.disabledSteps.length > 0 && t.each( this.options.disabledSteps, function ( t, e ) { s.steps.eq( e ).parent( "li" ).addClass( "disabled" ) } ), this.options.errorSteps && this.options.errorSteps.length > 0 && t.each( this.options.errorSteps, function ( t, e ) { s.steps.eq( e ).parent( "li" ).addClass( "danger" ) } ), this.options.hiddenSteps && this.options.hiddenSteps.length > 0 && t.each( this.options.hiddenSteps, function ( t, e ) { s.steps.eq( e ).parent( "li" ).addClass( "hidden" ) } ), !0 }, _setToolbar: function () { if ( "none" === this.options.toolbarSettings.toolbarPosition ) return !0; var s = this.options.toolbarSettings.showNextButton !== !1 ? t( "<button></button>" ).text( this.options.lang.next ).addClass( "btn btn-secondary sw-btn-next" ).attr( "type", "button" ) : null, e = this.options.toolbarSettings.showPreviousButton !== !1 ? t( "<button></button>" ).text( this.options.lang.previous ).addClass( "btn btn-secondary sw-btn-prev" ).attr( "type", "button" ) : null, n = t( "<div></div>" ).addClass( "btn-group mr-2 sw-btn-group" ).attr( "role", "group" ).append( e, s ), i = null; this.options.toolbarSettings.toolbarExtraButtons && this.options.toolbarSettings.toolbarExtraButtons.length > 0 && ( i = t( "<div></div>" ).addClass( "btn-group mr-2 sw-btn-group-extra" ).attr( "role", "group" ), t.each( this.options.toolbarSettings.toolbarExtraButtons, function ( t, s ) { i.append( s.clone( !0 ) ) } ) ); var o, a; switch ( this.options.toolbarSettings.toolbarPosition ) { case "top": o = t( "<div></div>" ).addClass( "btn-toolbar sw-toolbar sw-toolbar-top justify-content-" + this.options.toolbarSettings.toolbarButtonPosition ), o.append( n ), "start" === this.options.toolbarSettings.toolbarButtonPosition ? o.prepend( i ) : o.append( i ), this.container.before( o ); break; case "bottom": a = t( "<div></div>" ).addClass( "btn-toolbar sw-toolbar sw-toolbar-bottom justify-content-" + this.options.toolbarSettings.toolbarButtonPosition ), a.append( n ), "start" === this.options.toolbarSettings.toolbarButtonPosition ? a.prepend( i ) : a.append( i ), this.container.after( a ); break; case "both": o = t( "<div></div>" ).addClass( "btn-toolbar sw-toolbar sw-toolbar-top justify-content-" + this.options.toolbarSettings.toolbarButtonPosition ), o.append( n ), "start" === this.options.toolbarSettings.toolbarButtonPosition ? o.prepend( i ) : o.append( i ), this.container.before( o ), a = t( "<div></div>" ).addClass( "btn-toolbar sw-toolbar sw-toolbar-bottom justify-content-" + this.options.toolbarSettings.toolbarButtonPosition ), a.append( n.clone( !0 ) ), null !== i && ( "start" === this.options.toolbarSettings.toolbarButtonPosition ? a.prepend( i.clone( !0 ) ) : a.append( i.clone( !0 ) ) ), this.container.after( a ); break; default: a = t( "<div></div>" ).addClass( "btn-toolbar sw-toolbar sw-toolbar-bottom justify-content-" + this.options.toolbarSettings.toolbarButtonPosition ), a.append( n ), this.options.toolbarSettings.toolbarButtonPosition, a.append( i ), this.container.after( a ) }return !0 }, _setEvents: function () { var n = this; return t( this.steps ).on( "click", function ( t ) { if ( t.preventDefault(), n.options.anchorSettings.anchorClickable === !1 ) return !0; var s = n.steps.index( this ); if ( n.options.anchorSettings.enableAnchorOnDoneStep === !1 && n.steps.eq( s ).parent( "li" ).hasClass( "done" ) ) return !0; s !== n.current_index && ( n.options.anchorSettings.enableAllAnchors !== !1 && n.options.anchorSettings.anchorClickable !== !1 ? n._showStep( s ) : n.steps.eq( s ).parent( "li" ).hasClass( "done" ) && n._showStep( s ) ) } ), t( ".sw-btn-next", this.main ).on( "click", function ( t ) { t.preventDefault(), n._showNext() } ), t( ".sw-btn-prev", this.main ).on( "click", function ( t ) { t.preventDefault(), n._showPrevious() } ), this.options.keyNavigation && t( e ).keyup( function ( t ) { n._keyNav( t ) } ), this.options.backButtonSupport && t( s ).on( "hashchange", function ( e ) { if ( !n.options.useURLhash ) return !0; if ( s.location.hash ) { var i = t( "a[href*='" + s.location.hash + "']", n.nav ); i && i.length > 0 && ( e.preventDefault(), n._showStep( n.steps.index( i ) ) ) } } ), !0 }, _showNext: function () { for ( var t = this.current_index + 1, s = t; s < this.steps.length; s++ )if ( !this.steps.eq( s ).parent( "li" ).hasClass( "disabled" ) && !this.steps.eq( s ).parent( "li" ).hasClass( "hidden" ) ) { t = s; break } if ( this.steps.length <= t ) { if ( !this.options.cycleSteps ) return !1; t = 0 } return this._showStep( t ), !0 }, _showPrevious: function () { for ( var t = this.current_index - 1, s = t; s >= 0; s-- )if ( !this.steps.eq( s ).parent( "li" ).hasClass( "disabled" ) && !this.steps.eq( s ).parent( "li" ).hasClass( "hidden" ) ) { t = s; break } if ( 0 > t ) { if ( !this.options.cycleSteps ) return !1; t = this.steps.length - 1 } return this._showStep( t ), !0 }, _showStep: function ( t ) { return !!this.steps.eq( t ) && ( t != this.current_index && ( !this.steps.eq( t ).parent( "li" ).hasClass( "disabled" ) && !this.steps.eq( t ).parent( "li" ).hasClass( "hidden" ) && ( this._loadStepContent( t ), !0 ) ) ) }, _loadStepContent: function ( s ) { var e = this, n = this.steps.eq( this.current_index ), i = "", o = this.steps.eq( s ), a = o.data( "content-url" ) && o.data( "content-url" ).length > 0 ? o.data( "content-url" ) : this.options.contentURL; if ( null !== this.current_index && this.current_index !== s && ( i = this.current_index < s ? "forward" : "backward" ), null !== this.current_index && this._triggerEvent( "leaveStep", [ n, this.current_index, i ] ) === !1 ) return !1; if ( !( a && a.length > 0 ) || o.data( "has-content" ) && this.options.contentCache ) this._transitPage( s ); else { var r = o.length > 0 ? t( o.attr( "href" ), this.main ) : null, h = t.extend( !0, {}, { url: a, type: "POST", data: { step_number: s }, dataType: "text", beforeSend: function () { e._loader( "show" ) }, error: function ( s, n, i ) { e._loader( "hide" ), t.error( i ) }, success: function ( t ) { t && t.length > 0 && ( o.data( "has-content", !0 ), r.html( t ) ), e._loader( "hide" ), e._transitPage( s ) } }, this.options.ajaxSettings ); t.ajax( h ) } return !0 }, _transitPage: function ( s ) { var e = this, n = this.steps.eq( this.current_index ), i = n.length > 0 ? t( n.attr( "href" ), this.main ) : null, o = this.steps.eq( s ), a = o.length > 0 ? t( o.attr( "href" ), this.main ) : null, r = ""; null !== this.current_index && this.current_index !== s && ( r = this.current_index < s ? "forward" : "backward" ); var h = "middle"; return 0 === s ? h = "first" : s === this.steps.length - 1 && ( h = "final" ), this.options.transitionEffect = this.options.transitionEffect.toLowerCase(), this.pages.finish(), "slide" === this.options.transitionEffect ? i && i.length > 0 ? i.slideUp( "fast", this.options.transitionEasing, function () { a.slideDown( e.options.transitionSpeed, e.options.transitionEasing ) } ) : a.slideDown( this.options.transitionSpeed, this.options.transitionEasing ) : "fade" === this.options.transitionEffect ? i && i.length > 0 ? i.fadeOut( "fast", this.options.transitionEasing, function () { a.fadeIn( "fast", e.options.transitionEasing, function () { t( this ).show() } ) } ) : a.fadeIn( this.options.transitionSpeed, this.options.transitionEasing, function () { t( this ).show() } ) : ( i && i.length > 0 && i.hide(), a.show() ), this._setURLHash( o.attr( "href" ) ), this._setAnchor( s ), this._setButtons( s ), this._fixHeight( s ), this.current_index = s, this._triggerEvent( "showStep", [ o, this.current_index, r, h ] ), !0 }, _setAnchor: function ( t ) { return this.steps.eq( this.current_index ).parent( "li" ).removeClass( "active" ), this.options.anchorSettings.markDoneStep !== !1 && null !== this.current_index && ( this.steps.eq( this.current_index ).parent( "li" ).addClass( "done" ), this.options.anchorSettings.removeDoneStepOnNavigateBack !== !1 && this.steps.eq( t ).parent( "li" ).nextAll().removeClass( "done" ) ), this.steps.eq( t ).parent( "li" ).removeClass( "done" ).addClass( "active" ), !0 }, _setButtons: function ( s ) { return this.options.cycleSteps || ( 0 >= s ? t( ".sw-btn-prev", this.main ).addClass( "disabled" ) : t( ".sw-btn-prev", this.main ).removeClass( "disabled" ), this.steps.length - 1 <= s ? t( ".sw-btn-next", this.main ).addClass( "disabled" ) : t( ".sw-btn-next", this.main ).removeClass( "disabled" ) ), !0 }, _keyNav: function ( t ) { var s = this; switch ( t.which ) { case 37: s._showPrevious(), t.preventDefault(); break; case 39: s._showNext(), t.preventDefault(); break; default: return } }, _fixHeight: function ( s ) { if ( this.options.autoAdjustHeight ) { var e = this.steps.eq( s ).length > 0 ? t( this.steps.eq( s ).attr( "href" ), this.main ) : null; this.container.finish().animate( { minHeight: e.outerHeight() }, this.options.transitionSpeed, function () { } ) } return !0 }, _triggerEvent: function ( s, e ) { var n = t.Event( s ); return this.main.trigger( n, e ), !n.isDefaultPrevented() && n.result }, _setURLHash: function ( t ) { this.options.showStepURLhash && s.location.hash !== t && ( s.location.hash = t ) }, _loader: function ( t ) { switch ( t ) { case "show": this.main.addClass( "sw-loading" ); break; case "hide": this.main.removeClass( "sw-loading" ); break; default: this.main.toggleClass( "sw-loading" ) } }, theme: function ( t ) { if ( this.options.theme === t ) return !1; this.main.removeClass( "sw-theme-" + this.options.theme ), this.options.theme = t, this.main.addClass( "sw-theme-" + this.options.theme ), this._triggerEvent( "themeChanged", [ this.options.theme ] ) }, next: function () { this._showNext() }, prev: function () { this._showPrevious() }, reset: function () { if ( this._triggerEvent( "beginReset" ) === !1 ) return !1; this.container.stop( !0 ), this.pages.stop( !0 ), this.pages.hide(), this.current_index = null, this._setURLHash( this.steps.eq( this.options.selected ).attr( "href" ) ), t( ".sw-toolbar", this.main ).remove(), this.steps.removeClass(), this.steps.parents( "li" ).removeClass(), this.steps.data( "has-content", !1 ), this.init(), this._triggerEvent( "endReset" ) }, stepState: function ( s, e ) { s = t.isArray( s ) ? s : [ s ]; var n = t.grep( this.steps, function ( e, n ) { return t.inArray( n, s ) !== -1 } ); if ( n && n.length > 0 ) switch ( e ) { case "disable": t( n ).parents( "li" ).addClass( "disabled" ); break; case "enable": t( n ).parents( "li" ).removeClass( "disabled" ); break; case "hide": t( n ).parents( "li" ).addClass( "hidden" ); break; case "show": t( n ).parents( "li" ).removeClass( "hidden" ); break; case "error-on": t( n ).parents( "li" ).addClass( "danger" ); break; case "error-off": t( n ).parents( "li" ).removeClass( "danger" ) } } } ), t.fn.smartWizard = function ( s ) { var e, n = arguments; return void 0 === s || "object" == typeof s ? this.each( function () { t.data( this, "smartWizard" ) || t.data( this, "smartWizard", new i( this, s ) ) } ) : "string" == typeof s && "_" !== s[ 0 ] && "init" !== s ? ( e = t.data( this[ 0 ], "smartWizard" ), "destroy" === s && t.data( this, "smartWizard", null ), e instanceof i && "function" == typeof e[ s ] ? e[ s ].apply( e, Array.prototype.slice.call( n, 1 ) ) : this ) : void 0 } }( jQuery, window, document );


$( document ).ready( function ()
{

    // Toolbar extra buttons
    var btnFinish = $( '<button></button>' ).text( 'Finish' )
        .addClass( 'btn btn-info' )
        .on( 'click', function ()
        {
            if ( !$( this ).hasClass( 'disabled' ) )
            {
                var elmForm = $( "#myForm" );
                if ( elmForm )
                {
                    elmForm.validator( 'validate' );
                    var elmErr = elmForm.find( '.has-error' );
                    if ( elmErr && elmErr.length > 0 )
                    {
                        alert( 'Oops we still have error in the form' );
                        return false;
                    } else
                    {
                        alert( 'Great! we are ready to submit form' );
                        elmForm.submit();
                        return false;
                    }
                }
            }
        } );
    var btnCancel = $( '<button></button>' ).text( 'Cancel' )
        .addClass( 'btn btn-danger' )
        .on( 'click', function ()
        {
            $( '#smartwizard' ).smartWizard( "reset" );
            $( '#myForm' ).find( "input, textarea" ).val( "" );
        } );



    // Smart Wizard
    $( '#smartwizard' ).smartWizard( {
        selected: 0,
        theme: 'dots',
        transitionEffect: 'fade',
        toolbarSettings: {
            toolbarPosition: 'bottom',
            toolbarExtraButtons: [ btnFinish, btnCancel ]
        },
        anchorSettings: {
            markDoneStep: true, // add done css
            markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
            removeDoneStepOnNavigateBack: true, // While navigate back done step after active step will be cleared
            enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
        }
    } );

    $( "#smartwizard" ).on( "leaveStep", function ( e, anchorObject, stepNumber, stepDirection )
    {
        var elmForm = $( "#form-step-" + stepNumber );
        // stepDirection === 'forward' :- this condition allows to do the form validation
        // only on forward navigation, that makes easy navigation on backwards still do the validation when going next
        if ( stepDirection === 'forward' && elmForm )
        {
            elmForm.validator( 'validate' );
            var elmErr = elmForm.children( '.has-error' );
            if ( elmErr && elmErr.length > 0 )
            {
                // Form validation failed
                return false;
            }
        }
        return true;
    } );

    $( "#smartwizard" ).on( "showStep", function ( e, anchorObject, stepNumber, stepDirection )
    {
        // Enable finish button only on last step
        if ( stepNumber == 3 )
        {
            $( '.btn-finish' ).removeClass( 'disabled' );
        } else
        {
            $( '.btn-finish' ).addClass( 'disabled' );
        }
    } );

} );





//orderlistStages

var datalistOrderListStages = {
    init: function ()
    {
        $( "#m_table_OrderListStages" ).DataTable( {
            responsive: !0,
            paging: !0,
            scrollX: "500px",


        } )
    }
};
jQuery( document ).ready( function ()
{
    datalistOrderListStages.init()
} );
