
var KTDropzoneDemo = function ()
{
    // Private functions
    var demos = function ()
    {
        // single file upload
        Dropzone.options.kDropzoneOne = {
            paramName: "file", // The name that will be used to transfer the file
            maxFiles: 1,
            maxFilesize: 5, // MB
            addRemoveLinks: true,
            accept: function ( file, done )
            {
                if ( file.name == "justinbieber.jpg" )
                {
                    done( "Naha, you don't." );
                } else
                {
                    done();
                }
            }
        };

        // multiple file upload
        Dropzone.options.imajkumar = {
            paramName: "file",
            maxFiles: 1,
            maxFilesize: 1000888,
            addRemoveLinks: !0,
            //acceptedFiles: "image/*,application/png,.jpg",
            acceptedFiles: ".pdf,.mkv,.avi",
            accept: function ( e, o )
            {
                "justinbieber.jpg" == e.name ? o( "Naha, you don't." ) : o()
            },
            sending: function ( file, xhr, formData )
            {

                var publish_on = $( 'input[name="txtPayOrderIDInvAdd"]' ).val();
                var txtAdminAccountOCInvoice = $( '#txtAdminAccountOCInvoice' ).val();

                var  _token = $( 'meta[name="csrf-token"]' ).attr( 'content' );
                formData.append( 'orderid', publish_on );
                formData.append( 'notes', txtAdminAccountOCInvoice );
                formData.append( '_token', _token );

            }
        };

        // file type validation
        Dropzone.options.kDropzoneThree = {
            paramName: "file", // The name that will be used to transfer the file
            maxFiles: 10,
            maxFilesize: 10, // MB
            addRemoveLinks: true,
            acceptedFiles: "image/*,application/pdf,.psd",
            accept: function ( file, done )
            {
                if ( file.name == "justinbieber.jpg" )
                {
                    done( "Naha, you don't." );
                } else
                {
                    done();
                }
            }
        };
    }

    return {
        // public functions
        init: function ()
        {
            demos();
        }
    };
}();

KTDropzoneDemo.init();