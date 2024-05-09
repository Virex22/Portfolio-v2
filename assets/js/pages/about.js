import "../../styles/pages/about.scss";
import "../utility/navbar";
import 'aos/dist/aos.css';
import AOS from 'aos';
AOS.init();

/* animate hero bubbles */
const bubbles = document.querySelectorAll(".circle-bubble");

bubbles.forEach((bubble) => {
    const delay = Math.floor(Math.random() * 10000);
    bubble.style.animationDelay = `-${delay}ms`;
    bubble.style.animationDuration = `40s`;
    bubble.style.animationIterationCount = "infinite";
    bubble.style.animationTimingFunction = "ease-in-out";
    bubble.style.animationName = "bubble";
});

/* handle circle button click */

let chatBubble = document.querySelector(".text-bubble-container");
let circleButton = document.querySelectorAll(".circle-button");

circleButton.forEach((button) => {
    button.addEventListener("click", () => {
        let h1 = chatBubble.querySelector("h1");
        let span = chatBubble.querySelector("span");
        let bubbleTitle = button.getAttribute("data-bubble-title");
        let bubbleContent = button.getAttribute("data-bubble-content");

        h1.innerText = bubbleTitle;
        span.innerText = bubbleContent;
        chatBubble.classList.remove("no-button-clicked");
    });
});

/* handle timeline scroll */
const realMeetMe = document.querySelector(".about-bottom-meet-me:not(.keep)");
const keepMeetMePosition = document.querySelector(".about-bottom-meet-me.keep");
let elemY = realMeetMe.getBoundingClientRect().top + window.scrollY;
elemY -= (window.innerHeight / 2) - (realMeetMe.offsetHeight / 2);
function resetElemY() {
    realMeetMe.classList.remove("fixed");
    keepMeetMePosition.style.display = "none";
    elemY = realMeetMe.getBoundingClientRect().top + window.scrollY;
    elemY -= (window.innerHeight / 2) - (realMeetMe.offsetHeight / 2);
}
window.resetElemY = resetElemY;
window.addEventListener("resize", () => {
    resetElemY();
});

window.addEventListener("scroll", () => {
        const inResponsive = window.getComputedStyle(document.querySelector(".about-bottom-container")).getPropertyValue("flex-direction") === "column";
        if (inResponsive && !realMeetMe.classList.contains("fixed")) {
            return;
        }
        if (window.scrollY > elemY) {
            realMeetMe.classList.add("fixed");
            keepMeetMePosition.style.display = "block";
        } else {
            realMeetMe.classList.remove("fixed");
            keepMeetMePosition.style.display = "none";
        }
    }
);