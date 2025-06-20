import './bootstrap';

window.Echo.channel('brands')
    .listen('.brandChange', (e) => {
        toastr.success('Thương hiệu có sự thay đổi.');

        setTimeout(() => {
            location.reload();
        }, 1500);
    });