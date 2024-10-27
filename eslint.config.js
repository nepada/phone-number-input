import globals from 'globals';
import config from '@nepada/eslint-config';
import jestPlugin from 'eslint-plugin-jest';

const languageOptions = {
    globals: {
        ...globals.browser,
    },
};

export default [
    ...config.default,
    jestPlugin.configs['flat/recommended'],
    {
        languageOptions,
    },
];
