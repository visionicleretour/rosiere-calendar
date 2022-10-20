document.addEventListener('DOMContentLoaded', function () {
  const splide = new Splide('.splide', {
    type: 'loop',
    perPage: 3,
    breakpoints: {
      /* 900: {
        perPage: 2,
      }, */
      750: {
        perPage: 1,
      },
    },
  });
  splide.mount(/* window.splide.Extensions */); /* // TODO: Check how to do auto-scroll */
});