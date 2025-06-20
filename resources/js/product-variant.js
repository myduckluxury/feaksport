import './bootstrap';

window.Echo.channel(`productVariants.${productId}`)
    .listen('.productVariant', (e) => {
        toastr.success('Sản phẩm vừa có sự thay đổi.');
        setTimeout(() => {
            location.reload();
        }, 1500);
    })