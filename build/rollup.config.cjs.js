import commonjs from '@rollup/plugin-commonjs';
import json from '@rollup/plugin-json';
import {nodeResolve} from '@rollup/plugin-node-resolve';


export default {
    input: 'src/assets/index.js',
    external: (id) => {
        return /^libphonenumber-js/u.test(id);
    },
    output: {
        dir: 'dist/commonjs',
        format: 'cjs',
        exports: 'auto',
        sourcemap: true,
        preserveModules: true,
    },
    plugins: [
        nodeResolve(),
        json(),
        commonjs(),
    ],
};
