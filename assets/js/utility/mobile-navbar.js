
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