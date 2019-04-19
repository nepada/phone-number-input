import Nette from 'nette-forms';

export default () => {
    const clone = Object.assign({}, Nette);
    clone.validators = Object.assign({}, clone.validators);
    return clone;
};
