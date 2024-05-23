import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/fastclick.js', 'resources/js/webpack.js'],
            refresh: true,
            buildDirectory: 'assets',
            output: 'assets'
        }),
    ],
    build: {
        outDir: path.resolve(__dirname, 'public/assets'),
        rollupOptions: {
            output: {
                format: 'es',
                entryFileNames: '[hash].js',
                chunkFileNames: '[hash].js',
                assetFileNames: '[name]-[hash][extname]',
            },
        },
    },
});
