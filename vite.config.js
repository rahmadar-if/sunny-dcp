import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { glob } from 'glob';
import path from 'path';

const isJsEntry = (f) => {
    const name = f.replace(/\\/g, '/').split('/').pop()
    return (
        name === 'page.js'  ||
        name === 'list.js'  ||
        name === 'index.js' ||
        /^.+-index\.js$/.test(name)
    )
}

const pageJsEntries = (base) =>
    glob.sync(`${base}/resources/js/pages/**/*.js`).filter(isJsEntry)

const vendorCss = (pkg) =>
    glob.sync([
        `vendor/solaris/${pkg}/resources/css/*.css`,
        `vendor/solaris/${pkg}/resources/css/*.scss`,
        `vendor/solaris/${pkg}/resources/css/pages/**/*.css`,
        `vendor/solaris/${pkg}/resources/css/pages/**/*.scss`,
    ]).filter(f => !f.replace(/\\/g, '/').endsWith('css/app.scss'))

const vendors = [
    'solaris-laravel-core',
    'solaris-laravel-masterdata',
    'solaris-laravel-basecrm',
    'solaris-laravel-sales',
    'solaris-laravel-marketing',
    'solaris-laravel-crm',
]

const cssFiles = glob.sync([
    'resources/css/*.css',
    'resources/css/*.scss',
    'resources/css/pages/**/*.css',
    'resources/css/pages/**/*.scss',
]).filter(f => !f.replace(/\\/g, '/').endsWith('css/app.scss'))
cssFiles.push('resources/css/app.scss')

const coreBase = 'vendor/solaris/solaris-laravel-core/resources/js'
const coreExtraEntries = [
    `${coreBase}/main.js`,
    `${coreBase}/push-notification-check.js`,
]

const jsFiles = pageJsEntries('.')
jsFiles.push('resources/js/app.js')

export default defineConfig({
    plugins: [
        laravel({
            input: [
                ...cssFiles,
                ...jsFiles,
                ...coreExtraEntries,
                ...vendors.flatMap(pkg => [
                    ...pageJsEntries(`vendor/solaris/${pkg}`),
                    ...vendorCss(pkg),
                ]),
            ],
            refresh: [
                { paths: ['resources/views/**', 'resources/views/.solaris-hmr'] }
            ],
        })
    ],
    resolve: {
        alias: {
            '@js': path.resolve(__dirname, 'resources/js'),
            '@css': path.resolve(__dirname, 'resources/css'),
            '@core-js': path.resolve(__dirname, 'vendor/solaris/solaris-laravel-core/resources/js'),
            '@core-css': path.resolve(__dirname, 'vendor/solaris/solaris-laravel-core/resources/css'),
            '@master-data-js': path.resolve(__dirname, 'vendor/solaris/solaris-laravel-masterdata/resources/js'),
            '@master-data-css': path.resolve(__dirname, 'vendor/solaris/solaris-laravel-masterdata/resources/css'),
            '@base-crm-js': path.resolve(__dirname, 'vendor/solaris/solaris-laravel-basecrm/resources/js'),
            '@base-crm-css': path.resolve(__dirname, 'vendor/solaris/solaris-laravel-basecrm/resources/css'),
            '@sales-js': path.resolve(__dirname, 'vendor/solaris/solaris-laravel-sales/resources/js'),
            '@sales-css': path.resolve(__dirname, 'vendor/solaris/solaris-laravel-sales/resources/css'),
            '@marketing-js': path.resolve(__dirname, 'vendor/solaris/solaris-laravel-marketing/resources/js'),
            '@marketing-css': path.resolve(__dirname, 'vendor/solaris/solaris-laravel-marketing/resources/css'),
            '@crm-js': path.resolve(__dirname, 'vendor/solaris/solaris-laravel-crm/resources/js'),
            '@crm-css': path.resolve(__dirname, 'vendor/solaris/solaris-laravel-crm/resources/css'),
        }
    },
    build: {
        rollupOptions: {
            output: {
                manualChunks(id) {
                    const norm = id.replace(/\\/g, '/')

                    // node_modules: one chunk per package
                    if (norm.includes('node_modules')) {
                        return norm.split('node_modules/')[1].split('/')[0]
                    }

                    // Vendor Solaris library files (solaris/, libs/) → one chunk per package
                    const libMatch = norm.match(/\/vendor\/solaris\/([^/]+)\/resources\/js\/(solaris|libs)\//)
                    if (libMatch) {
                        const pkg = libMatch[1].replace('solaris-laravel-', '')
                        return `lib-${pkg}`
                    }
                }
            }
        }
    },
    define: {
        "global": 'globalThis',
    }
})