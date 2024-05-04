import "../../styles/pages/home.scss";
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import 'swiper/css/effect-fade';
/* Swiper */

import Swiper from 'swiper';
import {Pagination, Autoplay, EffectFade, Navigation} from 'swiper/modules';
import "../utility/navbar";

Swiper.use([Pagination, Autoplay, EffectFade, Navigation]);

function centerSwiperIfFewSlides(swiper) {
    const swiperWrapper = swiper.el.querySelector('.swiper-wrapper');
    const totalWith = swiper.params.spaceBetween * (swiper.slidesSizesGrid.length) + swiper.slidesSizesGrid.reduce((a, b) => a + b, 0);
    swiperWrapper.style.justifyContent = totalWith > window.innerWidth ? 'flex-start' : 'center';
    if (totalWith > window.innerWidth) {
        swiper.autoplay.start();
    }
}

/* Swiper for hero section */
new Swiper(".hero-swiper", {
    loop: true,
    effect: "fade",
    fadeEffect: {
        crossFade: true,
    },
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    speed: 1000,
    pagination: {
        el: ".swiper-pagination",
    },
});

/* Swiper for services section */

new Swiper(".services-swiper", {
    loop: true,
    spaceBetween: 20,
    slidesPerView: "auto",
    speed: 250,
    slidesOffsetBefore: 50,
    slidesOffsetAfter: 50,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    on: {
        resize: centerSwiperIfFewSlides,
        init: centerSwiperIfFewSlides
    }
});

/* Swiper for skills section */

new Swiper(".skills-swiper", {
    loop: true,
    spaceBetween: 20,
    slidesPerView: "auto",
    speed: 500,
    allowTouchMove: false,
    autoplay: {
        delay: 0,
        disableOnInteraction: false,
    },
    on: {
        resize: centerSwiperIfFewSlides,
        init: centerSwiperIfFewSlides
    }
});
