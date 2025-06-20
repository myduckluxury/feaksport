import './bootstrap';

window.Echo.channel(`voucherChange`)
    .listen('.voucher', (e) => {
        toastr.success('Voucher vừa được cập nhật.');

        setTimeout(() => {
            location.reload();
        }, 1200);
    });