import TomSelect from 'tom-select';

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

/* Select language */

const langSelect = document.querySelector('.tom-select-lang');

if (langSelect) {
    new TomSelect(langSelect, {
        mode: 'single',
        controlInput: null,
        render: {
            option: function(data) {
                return `<div class="ts-container"><img alt="${data.text}" src="${data.imgSrc}">${data.text}</div>`;
            },
            item: function(item) {
                return `<div class="ts-container"><img alt="${item.text}" src="${item.imgSrc}">${item.text}</div>`;
            },
        },
    });
}

/* Handle langSelect url change */

langSelect.addEventListener('change', (e) => {
    console.log(e.target.options[e.target.selectedIndex].getAttribute('data-url'));
    window.location.href = e.target.options[e.target.selectedIndex].getAttribute('data-url');
});