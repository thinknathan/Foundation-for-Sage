import Tobi from 'tobii';

export default function () {
  if (!window.tobiiInstance) {
    window.tobiiInstance = new Tobi();
  }
}
