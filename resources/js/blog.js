import'./bootstrap';

window.Echo.channel('blogAll')
    .listen('.blogAll', (e) => {
        toastr.success('Bài viết có sự thay đổi.');

        setTimeout(() => {
            location.reload();
        }, 1500);
    });