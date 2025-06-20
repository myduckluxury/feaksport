import './bootstrap';

window.Echo.channel('users')
    .listen('.user', (e) => {
        location.reload();
    });