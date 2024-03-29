import "../../styles/pages/home.scss";
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import 'swiper/css/effect-fade';
/* Swiper */

import Swiper from 'swiper';
import {Pagination, Autoplay, EffectFade, Navigation} from 'swiper/modules';

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
    autoplay: {
        delay: 0,
        disableOnInteraction: false,
    },
    on: {
        resize: centerSwiperIfFewSlides,
        init: centerSwiperIfFewSlides
    }
});

/* Mobile Navbar */

const mobileNavbarButton = document.querySelector(".mobile-lines");

const obfuscatePage = () => {
    const obfuscate = document.createElement("div");
    obfuscate.classList.add("obfuscate-page");
    document.querySelector("main").appendChild(obfuscate);

    obfuscate.addEventListener("click", () => {
        obfuscate.remove();
        mobileNavbarButton.click();
    });
};

const unobfuscatePage = () => {
    document.querySelector(".obfuscate-page").remove();
};

mobileNavbarButton.addEventListener("click", () => {
    const ul = mobileNavbarButton.parentNode.querySelector("ul");
    ul.classList.toggle("active");
    mobileNavbarButton.classList.toggle("active");
    ul.style.opacity = "0";

    setTimeout(() => {
        ul.style.opacity = "1";
    }, 10);

    if (ul.classList.contains("active")) {
        obfuscatePage();
    } else {
        unobfuscatePage();
    }
});