$(document).ready(function () {
    $('#request-cancel').submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $(this).serialize(),
            success: function (response) {
                if (response.status === 'success') {
                    toastr.success(response.message);
                    $(".reason").val("");
                }
            },
            error: function (xhr) {
                if (xhr.responseJSON.status === 'error') {
                    toastr.error(xhr.responseJSON.message);
                    $(".reason").val("");
                }
            }
        });
    });

    $('#request-return').submit(function (e) {
        e.preventDefault();
    
        let formData = new FormData(this);

        // Xóa lỗi cũ trước khi hiện lỗi mới
        $(".error-image").text('');
    
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status === 'success') {
                    toastr.success(response.message);
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
    
                    if (errors.image) {
                        $(".error-image").text(errors.image[0]);
                    }
                    if (errors['image.0']) {
                        $(".error-image").text(errors['image.0']); 
                    }
                } else if (xhr.responseJSON.status === 'error') {
                    toastr.error(xhr.responseJSON.message);
                    $(".reason").val("");
                    $(".fullname").val("");
                    $(".image").val("");
                }
            }
        });
    });    
})

fetch('https://api.vietqr.io/v2/banks')
    .then(response => response.json())
    .then(data => {
        const select = document.getElementById('bankSelect');
        data.data.forEach(bank => {
            const option = document.createElement('option');
            option.value = bank.shortName + ' (' + bank.name + ')';
            option.text = `${bank.shortName} (${bank.name})`; // gắn shortName + name
            select.appendChild(option);
        });
    });

