import Glider from 'glider-js';
import prefersReducedMotion from '../util/prefersReducedMotion.js';

export default function () {
  // Motion and defaults
  let sliderDuration = 1;
  if (prefersReducedMotion()) {
    sliderDuration = 0;
  }

  let carousels = [];

  let dotsEle = this.querySelector('.carousel__dots');
  let prevEle = this.querySelector('.carousel__control--prev');
  let nextEle = this.querySelector('.carousel__control--next');
  let trackEle = this.querySelector('.carousel__track');
  let options = {
    // Mobile-first defaults
    slidesToShow: 1.2,
    slidesToScroll: 1,
    scrollLock: true,
    duration: sliderDuration,
    dots: dotsEle,
    arrows: {
      prev: prevEle,
      next: nextEle,
    },
    responsive: [
      {
        // screens greater than >= 775px
        breakpoint: 775,
        settings: {
          slidesToShow: 2.5,
          slidesToScroll: 1,
        },
        },
      {
        // screens greater than >= 1024px
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1,
        },
        },
      ],
  };
  carousels.push(new Glider(trackEle, options));
  this.classList.remove('carousel--load');
  this.classList.add('carousel--loaded');
}
