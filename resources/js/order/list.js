import '../bootstrap';

window.Echo.channel(`orderCreate`)
    .listen('.orderCreate', (e) => {
        toastr.success('Có đơn hàng mới.');

        setTimeout(() => {
            location.reload();
        }, 1500);
    });