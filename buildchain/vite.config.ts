import { build, defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import vueJsx from '@vitejs/plugin-vue-jsx';
import ViteRestart from 'vite-plugin-restart';
import viteCompression from 'vite-plugin-compression';
import manifestSRI from 'vite-plugin-manifest-sri';
import { visualizer } from 'rollup-plugin-visualizer';
import eslintPlugin from 'vite-plugin-eslint';
import { nodeResolve } from '@rollup/plugin-node-resolve';
import path from 'path';

export default defineConfig(({ command }) => ({
  base: command === 'serve' ? '/patternlib/' : '/dist/',
  build: {
    emptyOutDir: true,
    manifest: true,
    outDir: '../src/web/assets/dist',
    rollupOptions: {
      input: {
        app: 'src/js/app.ts',
      },
      output: {
        sourcemap: true,
      },
    },
  },
  plugins: [
    nodeResolve({
      moduleDirectories: [path.resolve('./node_modules')],
    }),
    ViteRestart({
      reload: ['./src/templates/**/*.{twig,html}'],
    }),
    vue(),
    vueJsx(),
    viteCompression({
      filter: /\.(js|mjs|json|css|map)$/i,
    }),
    manifestSRI(),
    visualizer({
      filename: '../src/web/assets/dist/stats.html',
      template: 'treemap',
      sourcemap: true,
    }),
    eslintPlugin({
      cache: false,
    }),
  ],
  publicDir: '../src/web/assets/public',
  resolve: {
    alias: {
      '@': path.resolve(__dirname, './src'),
    },
    preserveSymlinks: true,
  },
  server: {
    fs: {
      strict: false,
    },
    host: '0.0.0.0',
    origin: 'http://localhost:3001',
    port: 3001,
    strictPort: true,
  },
}));
