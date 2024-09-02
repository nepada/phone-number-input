import Nette from 'nette-forms';

export default () => {
    const clone = Object.assign(Object.create(Object.getPrototypeOf(Nette)), Nette);
    clone.validators = Object.assign(Object.create(Object.getPrototypeOf(clone.validators)), clone.validators);
    return clone;
};
