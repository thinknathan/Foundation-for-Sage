/*
 * Utililty to check if site was launched via installed PWA
 *
 * @returns Boolean
 */
export default () => window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
