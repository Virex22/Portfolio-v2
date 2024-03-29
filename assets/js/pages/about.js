import "../../styles/pages/about.scss";

/* animate hero bubbles */
const bubbles = document.querySelectorAll(".circle-bubble");

bubbles.forEach((bubble) => {
    const delay = Math.floor(Math.random() * 10000);
    bubble.style.animationDelay = `${delay}ms`;
    bubble.style.animationDuration = `20s`;
    bubble.style.animationIterationCount = "infinite";
    bubble.style.animationTimingFunction = "linear";
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
const elem = document.querySelector(".about-bottom-meet-me:not(.keep)");
const keepElem = document.querySelector(".about-bottom-meet-me.keep");
let elemY = elem.getBoundingClientRect().top + window.scrollY;
elemY -= (window.innerHeight / 2) - (elem.offsetHeight / 2);

window.addEventListener("resize", () => {
    elemY = elem.getBoundingClientRect().top + window.scrollY;
    elemY -= (window.innerHeight / 2) - (elem.offsetHeight / 2);
});

window.addEventListener("scroll", () => {
    const inResponsive = window.getComputedStyle(document.querySelector(".about-bottom-container")).getPropertyValue("flex-direction") === "column";
    console.log(inResponsive);
    if (inResponsive && !elem.classList.contains("fixed")) {
        return;
    }
    if (window.scrollY > elemY) {
        elem.classList.add("fixed");
        keepElem.style.display = "block";
    } else {
        elem.classList.remove("fixed");
        keepElem.style.display = "none";
    }
}
);