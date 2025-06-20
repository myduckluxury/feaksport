$(document).ready(function() {
    $('.return-order').submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: 'PUT',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.status === 'success') {
                    toastr.success(response.message);
                }

                setTimeout(() => {
                    location.reload();
                }, 1500);
            }, 
            error: function(xhr) {
                if(xhr.responseJSON.status === 'error') {
                    toastr.error(xhr.responseJSON.message);
                }
            }
        });
    });
    $('.cancel-return').submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: 'PUT',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.status === 'success') {
                    toastr.success(response.message);
                }

                setTimeout(() => {
                    location.reload();
                }, 1500);
            }, 
            error: function(xhr) {
                if(xhr.responseJSON.status === 'error') {
                    toastr.error(xhr.responseJSON.message);
                }
            }
        });
    });
});