import '../bootstrap';import '../bootstrap';
console.log(productId);
window.Echo.channel(`product.${productId}`)
    .listen('.productChange', (e) => {
        toastr.success('Sản phẩm vừa có sự thay đổi.');
        setTimeout(() => {
            location.reload();
        }, 1500);
    })