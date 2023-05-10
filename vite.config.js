import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';
// import inject from '@rollup/plugin-inject';

export default defineConfig({
    plugins: [
        // inject({
        //     $: 'jquery',
        // }),
        laravel({
            input: [
                'resources/css/app.css',
                'resources/sass/app.scss',
                'resources/css/draw.css',
                'resources/scss/draw.scss',
                'resources/js/app.js',
                'resources/js/draw.ts',
            ],
            refresh: [
                ...refreshPaths,
                'app/Http/Livewire/**',
            ],
        }),
    ],
    resolve: {
        alias: {
            // '$': 'jquery',
            // 'confetti': 'confetti'
        },
    },
});
