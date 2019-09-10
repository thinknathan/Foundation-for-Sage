/**
 * Checks for modern browser features
 */
export default () => typeof Promise != 'undefined' && typeof requestAnimationFrame != 'undefined' && typeof Object.assign == 'function';
