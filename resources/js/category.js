import './bootstrap'

window.Echo.channel('categories')
    .listen('.categoryChange', (e) => {
        toastr.success('Danh mục có sự thay đổi.');

        setTimeout(() => {
            location.reload()
        }, 1500);
    });