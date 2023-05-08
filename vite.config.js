import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
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
            '$': 'jQuery',
            // 'confetti': 'confetti'
        },
    },
});
