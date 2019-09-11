/**
 * Checks for user's reduced motion preference
 */
export default () => window.matchMedia('(prefers-reduced-motion: reduce)').matches;
