document.addEventListener("DOMContentLoaded", () => {
    const slideCount = document.querySelectorAll(".product-swiper-main .swiper-slide").length;

    // MINIATURY
    const thumbs = slideCount > 1 ? new Swiper(".product-swiper-thumbs", {
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
    }) : null;

    // GŁÓWNY SLIDER — TYLKO JEDNO ZDJĘCIE, BEZ PRZEBITEK
    const main = new Swiper(".product-swiper-main", {
        slidesPerView: 1,
        loop: false,
        spaceBetween: 0,

        effect: "creative",
        creativeEffect: {
            prev: {
                opacity: 0,
                translate: ["-100%", 0, 0],
            },
            next: {
                opacity: 0,
                translate: ["100%", 0, 0],
            },
        },

        navigation: slideCount > 1 ? {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        } : false,

        thumbs: slideCount > 1 && thumbs ? {
            swiper: thumbs
        } : false,
    });

    if (slideCount <= 1) {
        document.querySelector(".swiper-button-next")?.remove();
        document.querySelector(".swiper-button-prev")?.remove();
    }
});
