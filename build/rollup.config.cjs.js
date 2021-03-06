import commonjs from '@rollup/plugin-commonjs';
import json from '@rollup/plugin-json';
import nodeBuiltins from 'rollup-plugin-node-builtins';
import nodeGlobals from 'rollup-plugin-node-globals';
import nodeResolve from '@rollup/plugin-node-resolve';


export default {
    input: 'src/assets/index.js',
    external: (id) => {
        return /^libphonenumber-js/u.test(id);
    },
    output: {
        dir: 'dist/commonjs',
        format: 'cjs',
        sourcemap: true,
    },
    preserveModules: true,
    plugins: [
        nodeResolve(),
        json(),
        commonjs(),
        nodeBuiltins(),
        nodeGlobals(),
    ],
};
