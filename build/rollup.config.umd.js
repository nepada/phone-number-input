import babel from 'rollup-plugin-babel';
import commonjs from '@rollup/plugin-commonjs';
import json from '@rollup/plugin-json';
import nodeBuiltins from 'rollup-plugin-node-builtins';
import nodeGlobals from 'rollup-plugin-node-globals';
import nodeResolve from '@rollup/plugin-node-resolve';
import {terser} from 'rollup-plugin-terser';


export default [
    {
        input: 'src/assets/index.umd.js',
        external: [
            'libphonenumber-js',
            'nette-forms',
        ],
        output: {
            file: 'dist/phone-number-input.js',
            format: 'umd',
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
            nodeBuiltins(),
            nodeGlobals(),
            babel({
                babelrc: false,
                presets: [['@babel/preset-env', {targets: '> 1%, cover 95%, not dead'}]],
            }),
        ],
    },
    {
        input: 'src/assets/index.umd.js',
        external: [
            'libphonenumber-js',
            'nette-forms',
        ],
        output: {
            file: 'dist/phone-number-input.min.js',
            format: 'umd',
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
            nodeBuiltins(),
            nodeGlobals(),
            babel({
                babelrc: false,
                presets: [['@babel/preset-env', {targets: '> 1%, cover 95%, not dead'}]],
            }),
            terser(),
        ],
    },
];
