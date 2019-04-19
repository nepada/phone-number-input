import metadata from 'libphonenumber-js/metadata.full';
import init from '../../dist/commonjs/index.cjs';
import NetteFactory from './netteFactory';

const Nette = NetteFactory();
init(Nette, metadata);

export default Nette;
