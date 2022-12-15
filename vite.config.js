import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    watch: {
        usePolling:true,
        origin: 'http://laravel.test'
    },
    server:{
        hmr:{
            host: 'localhost'
        }
    }
});
