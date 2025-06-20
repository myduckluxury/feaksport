import '../bootstrap';

window.Echo.channel(`order.${orderId}`)
    .listen('.orderChange', (e) => {
        toastr.success('Đơn hàng vừa được cập nhật.');

        setTimeout(() => {
            location.reload();
        }, 1500);
    });