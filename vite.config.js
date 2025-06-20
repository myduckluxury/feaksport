import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/product/list.js',
                'resources/js/product/detail.js',
                'resources/js/product-variant.js',
                'resources/js/category.js',
                'resources/js/brand.js',
                'resources/js/blog.js',
                'resources/js/order/status.js',
                'resources/js/order/request.js',
                'resources/js/order/list.js',
                'resources/js/voucher.js',
                'resources/js/user.js'
            ],
            refresh: true,
        }),
    ],
});
