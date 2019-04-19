import NetteCjs from './bootstrap.cjs';
import NetteEsm from './bootstrap.esm';
import NetteUmd from './bootstrap.umd';

const testInstances = [
    ['src/assets/index.esm.js', NetteEsm],
    ['dist/commonjs/index.cjs.js', NetteCjs],
    ['dist/phone-number-input.js', NetteUmd],
];

export {testInstances};
