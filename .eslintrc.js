module.exports = {
    'env': {
        'browser': true,
        'es6': true,
        'jest/globals': true,
    },
    'parserOptions': {
        'ecmaVersion': 2018,
        'sourceType': 'module',
    },
    'plugins': [
        'import',
        'jest',
    ],
    'extends': [
        '@nepada',
        'plugin:jest/recommended',
    ],
};
