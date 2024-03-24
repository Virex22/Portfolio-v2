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


const elem = document.querySelector(".about-bottom-meet-me");
let elemY = elem.getBoundingClientRect().top + window.scrollY;

elemY -= (window.innerHeight / 2) - (elem.offsetHeight / 2);
window.addEventListener("scroll", () => {
    if (window.scrollY > elemY) {
        elem.classList.add("fixed");
    } else {
        elem.classList.remove("fixed");
    }
}
);