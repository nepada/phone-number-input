import {babel} from '@rollup/plugin-babel';
import commonjs from '@rollup/plugin-commonjs';
import json from '@rollup/plugin-json';
import {nodeResolve} from '@rollup/plugin-node-resolve';
import rollupTerser from '@rollup/plugin-terser';


export default [
    {
        input: 'src/assets/phone-number-input.js',
        external: [
            'libphonenumber-js',
            'nette-forms',
        ],
        output: {
            file: 'dist/phone-number-input.js',
            format: 'umd',
            exports: 'auto',
            sourcemap: true,
            globals: {
                'libphonenumber-js': 'libphonenumber',
                'nette-forms': 'Nette',
            },
        },
        plugins: [
            nodeResolve(),
            json(),
            commonjs(),
            babel({
                babelrc: false,
                babelHelpers: 'bundled',
                presets: [['@babel/preset-env', {targets: '> 1%, cover 95%, not dead'}]],
            }),
        ],
    },
    {
        input: 'src/assets/phone-number-input.js',
        external: [
            'libphonenumber-js',
            'nette-forms',
        ],
        output: {
            file: 'dist/phone-number-input.min.js',
            format: 'umd',
            exports: 'auto',
            sourcemap: true,
            globals: {
                'libphonenumber-js': 'libphonenumber',
                'nette-forms': 'Nette',
            },
        },
        plugins: [
            nodeResolve(),
            json(),
            commonjs(),
            babel({
                babelrc: false,
                babelHelpers: 'bundled',
                presets: [['@babel/preset-env', {targets: '> 1%, cover 95%, not dead'}]],
            }),
            rollupTerser(),
        ],
    },
];
