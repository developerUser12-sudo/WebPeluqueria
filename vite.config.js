import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { viteStaticCopy } from 'vite-plugin-static-copy';
export default defineConfig({
    base: process.env.VITE_ASSET_URL + '/',
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        viteStaticCopy({
            targets: [
                {
                    src: 'node_modules/bootstrap-icons/font/fonts/*',
                    dest: 'assets/fonts'
                }
            ]
        })
    ],
});
