import { Controller } from '@hotwired/stimulus';
import {debounce} from "lodash";

/**
 * Stimulus controller that handle Navbar
 * @see https://stimulus.hotwired.dev/ for more information about stimulus
 *
 * @property {boolean} hasMenuTarget
 * @property {HTMLElement|null} menuTarget
 */
export default class extends Controller {
  static targets = ["menu"];

  connect() {
    super.connect();
    this.handleResizeDebounced = debounce(this.handleResize, 100, { leading: true, trailing: false });
  }

  disconnect() {
    super.disconnect();
    window.removeEventListener('resize', this.handleResizeDebounced)
  }

  toggleMenu() {
    if (this.hasMenuTarget) {
      this.menuTarget.classList.toggle('is-active')
      window.addEventListener('resize', this.handleResizeDebounced)
    }
  }

  handleResize = () => {
    if (this.hasMenuTarget) {
      this.menuTarget.classList.remove('is-active')
      window.removeEventListener('resize', this.handleResizeDebounced)
    }
  }
}
