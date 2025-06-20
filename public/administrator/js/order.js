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
    $('#payment-status').submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: 'PUT',
            data: $(this).serialize(),
            success: function (response) {
                if (response.status === 'success') {
                    toastr.success(response.message);

                    setTimeout(() => {
                        location.reload()
                    }, 2000)
                }
            },
            error: function(xhr) {
                if(xhr.responseJSON.status === 'error') {
                    toastr.error(xhr.responseJSON.message);
                }
            }
        });
    });

    $('#confirm-order').submit(function(e) {
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

    $('#custom-info').submit(function(e) {
        e.preventDefault();

        $(".text-danger").text("");

        $.ajax({
            url: $(this).attr('action'),
            type: 'PUT',
            data: $(this).serialize(),
            success: function (response) {
                if(response.status === 'success') {
                    toastr.success(response.message);

                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
            }, 
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;

                    if (errors.fullname) {
                        $(".error-fullname").text(errors.fullname[0]);
                    }

                    if (errors.phone_number) {
                        $(".error-phone-number").text(errors.phone_number[0]);
                    }

                    if (errors.email) {
                        $(".error-email").text(errors.email[0]);
                    }

                    if (errors.address) {
                        $(".error-address").text(errors.address[0]);
                    }
                }
            }
        });
    });

    $('.cancel-order').submit(function(e) {
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
    $('.fail-order').submit(function(e) {
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