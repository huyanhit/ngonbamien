import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from "@vitejs/plugin-vue";
import path from "path";
import Components from 'unplugin-vue-components/vite'
import { BootstrapVueNextResolver } from 'unplugin-vue-components/resolvers'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/admin.css',
                'resources/css/app.css',
                'resources/js/admin.js',
                'resources/js/app.js',
                'resources/js/chat.js',
                'resources/js/cbox.js',
                'resources/js/notify.js',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    includeAbsolute: false,
                },
            },
        }),
        Components({
            resolvers: [
                BootstrapVueNextResolver()
            ],
        }),
    ],
    server: {
        host: 'localhost',
        port: 8080,
        headers: {
            'Access-Control-Allow-Origin': '*',
        },
    },
    alias: {
        '$': 'jQuery'
    },
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
            "@": path.resolve("./app/Modules/Chat/App"),
        },
    },
    optimizeDeps: {
        include: ["quill"],
    },
    build: {
        outDir: 'public/build', 
    },
});
