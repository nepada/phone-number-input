import metadata from 'libphonenumber-js/metadata.full';
import init from '../../src/assets';
import NetteFactory from './netteFactory';

const Nette = NetteFactory();
init(Nette, metadata);

export default Nette;
