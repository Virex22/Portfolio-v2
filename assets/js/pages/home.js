import "../../styles/pages/home.scss";
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
/* Swiper */

import Swiper from 'swiper';
import {Pagination, Autoplay} from 'swiper/modules';

Swiper.use([Pagination, Autoplay]);

new Swiper(".mySwiper", {
    loop: true,
    // autoplay: {
    //     delay: 4000,
    //     disableOnInteraction: false,
    // },
    speed: 1000,
    pagination: {
        el: ".swiper-pagination",
    },
});