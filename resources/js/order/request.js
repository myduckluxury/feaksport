import '../bootstrap';

window.Echo.channel(`requestOrder.${orderId}`)
    .listen('.requestOrder', (e) => {
        toastr.success('Đơn hàng vừa có yêu cầu từ khách hàng.');

        setTimeout(() => {
            location.reload();
        }, 1500);
    });