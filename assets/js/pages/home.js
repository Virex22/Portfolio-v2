import "../../styles/pages/home.scss";
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import 'swiper/css/effect-fade';
/* Swiper */

import Swiper from 'swiper';
import {Pagination, Autoplay, EffectFade} from 'swiper/modules';

Swiper.use([Pagination, Autoplay, EffectFade]);

new Swiper(".mySwiper", {
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