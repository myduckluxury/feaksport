$(document).ready(function () {
    let clickedAction = '';
    $('#update-cart button[type=submit]').click(function () {
        clickedAction = $(this).val();
    });

    $('#update-cart').submit(function (e) {
        e.preventDefault();


        $('#update-cart input[name=action]').remove();

        $('#update-cart').append(`<input type="hidden" name="action" value="${clickedAction}">`);

        $.ajax({
            url: $(this).attr('action'),
            type: 'PUT',
            data: $(this).serialize(),
            success: function (response) {
                if (response.status === 'success') {
                    if (clickedAction === 'filter') {
                        setTimeout(() => {
                            window.location.href = orderIndexUrl;
                        }, 500);
                    } else {
                        toastr.success(response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    }


                }
            },
            error: function (xhr) {
                console.log(xhr);
                toastr.error(xhr.responseJSON?.message);
            }
        });
    });

    $('.delete-item-cart').submit(function (e) {
        e.preventDefault();
        console.log("Form delete đã được submit!");

        var url = $(this).attr('action');
        var method = 'DELETE';
        var token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: url,
            type: method,
            data: {
                _token: token
            },
            success: function (response) {
                if (response.status === 'success') {
                    toastr.success(response.message);

                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
            },
            error: function (xhr) {
                if (xhr.responseJSON && xhr.responseJSON.status === 'error') {
                    toastr.error(xhr.responseJSON.message);
                } else {
                    toastr.error('Có lỗi xảy ra khi xóa sản phẩm.');
                }
            }
        });
    });
});

$(document).ready(function () {
    let checkboxes = $(".cart-checkbox");
    let selectedTotal = $("#selected-total");
    let selectedPrice = $("#selected-price");
    const shippingFee = 50000;

    function updateTotal() {
        let totalPrice = 0;
        let hasSelected = false;

        checkboxes.each(function () {
            if ($(this).prop("checked")) {
                hasSelected = true;
                let row = $(this).closest(".cart-product-item");
                let priceText = row.find(".product-subtotal .price").text().trim();
                let price = parseInt(priceText.replace(/\D/g, ""));
                totalPrice += price;
            }
        });

        selectedPrice.text(totalPrice.toLocaleString("vi-VN") + "đ");

        let finalTotal = hasSelected ? totalPrice + shippingFee : 0;
        selectedTotal.text(finalTotal.toLocaleString("vi-VN") + "đ");
    }

    checkboxes.change(updateTotal);

    updateTotal();
});










