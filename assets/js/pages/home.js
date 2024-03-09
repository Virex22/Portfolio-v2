import "../../styles/pages/home.scss";
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
/* Swiper */

import Swiper from 'swiper';
import {Pagination} from 'swiper/modules';

Swiper.use([Pagination]);

new Swiper(".mySwiper", {
    pagination: {
        el: ".swiper-pagination",
    },
});