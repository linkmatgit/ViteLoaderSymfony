import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
import {resolve} from 'path'

const twigRefreshPlugin = {
    name: 'twig-refresh',
    configureServer({watcher, ws}) {
        watcher.add(resolve('templates/**/*.twig'))
        watcher.on('change', function (path) {
            if (path.endsWith('.twig')) {
                ws.send({
                    type: 'full-reload'
                })
            }
        })
    }
}
// https://vitejs.dev/config/
export default defineConfig({
    plugins: [react(), twigRefreshPlugin],
    root: './assets',
    base: '/assets',
    cors: false,
    emitManifest: true,
    build: {
        polyfillDynamicImport: false,
        manifest: true,
        assetsDir: '',
        outDir: '../public/assets',
        rollupOptions: {
            output: {
                manualChunks: undefined
            },
            input: {
                app: resolve(__dirname, 'assets/app.js'),
            }
        }
    },
    server: {
        watch: {
            disableGlobbing: false
        },
        host: '0.0.0.0',
        port: 5173,
        hmr: {
            port: 5173,
            clientPort: 5173,
            host: 'localhost'
        }
    }
})