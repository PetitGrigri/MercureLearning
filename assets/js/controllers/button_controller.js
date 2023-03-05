import { Controller } from '@hotwired/stimulus';

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

    const { dataset } = this.element;
    const { target } = dataset;

    if (target) this.element.addEventListener("click", this.handleClick(target))
  }

  handleClick = (target) => () => {
    this.element.classList.add('is-loading');

    fetch(target)
      .then(() => console.info(`Success when fetching ${target}`))
      .catch((error) => console.error(`error when fetching ${target}`, error))
      .finally(() => this.element.classList.remove('is-loading'))
  }
}
