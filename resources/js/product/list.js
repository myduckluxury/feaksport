import '../bootstrap';

window.Echo.channel('products')
    .listen('.productChange', (e) => {
        toastr.success('Sản phẩm vừa có sự thay đổi.');
        setTimeout(() => {
            location.reload();
        }, 1500);
    })