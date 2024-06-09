//SHOW SİDEBAR//
const navMenu = document.getElementById("sidebar"),
  navToggle = document.getElementById("nav-toggle"),
  navClose = document.getElementById("nav-close");

if (navToggle) {
  navToggle.addEventListener("click", () => {
    navMenu.classList.add("show-sidebar");
  });
}

if (navClose) {
  navClose.addEventListener("click", () => {
    navMenu.classList.remove("show-sidebar");
  });
}

/*SKİLLS*/
const tabs = document.querySelectorAll("[data-target]"),
  tabContent = document.querySelectorAll("[data-content]");

tabs.forEach((tab) => {
  tab.addEventListener("click", () => {
    const target = document.querySelector(tab.dataset.target);

    tabContent.forEach((tabContents) => {
      tabContents.classList.remove("skills__active");
    });

    target.classList.add("skills__active");

    tabs.forEach((tab) => {
      tab.classList.remove("skills__active");
    });
    tab.classList.add("skills__active");
  });
});

/*MIXITUP FILTER PORTFOLIO*/
let mixerProje = mixitup(".proje__container", {
  selectors: {
    target: ".proje__card",
  },
  animation: {
    duration: 300,
  },
});

/*Link Active Proje*/

const linkProje = document.querySelectorAll(".proje__item");

function activeProje() {
  linkProje.forEach((l) => l.classList.remove("active-proje"));
  this.classList.add("active-proje");
}

linkProje.forEach((l) => l.addEventListener("click", activeProje));

/*PORTFOLIO POPUP*/
document.addEventListener("click", (e) => {
  if (e.target.classList.contains("proje__button")) {
    toggleProjePopup();
    projeItemDetails(e.target.parentElement);
  }
});

function toggleProjePopup() {
  document.querySelector(".proje__popup").classList.toggle("open");
}

document
  .querySelector(".proje__popup-close")
  .addEventListener("click", toggleProjePopup);

function projeItemDetails(projeItem) {
  document.querySelector(".pp__thumbnail img").src =
    projeItem.querySelector(".proje__img").src;

  document.querySelector(".proje__popup-subtitle span").innerHTML =
    projeItem.querySelector(".proje__title").innerHTML;

  document.querySelector(".proje__popup-body ").innerHTML =
    projeItem.querySelector(".proje__item-details").innerHTML;
}

/*SERTİFİKA POPUP*/
document.addEventListener("click", (e) => {
  if (e.target.classList.contains("sertifika__button")) {
    toggleSertifikaPopup();
    sertifikaItemDetails(e.target.parentElement);
  }
});

function toggleSertifikaPopup() {
  document.querySelector(".sertifika__popup").classList.toggle("open");
}

document
  .querySelector(".sertifika__popup-close")
  .addEventListener("click", toggleSertifikaPopup);

function sertifikaItemDetails(sertifikaItem) {
  document.querySelector(".sertifika__thumbnail img").src =
    sertifikaItem.querySelector(".sertifika__img").src;

  document.querySelector(".sertifika__popup-body").innerHTML =
    sertifikaItem.querySelector(".sertifika__item-details").innerHTML;
}

// SWIPER
//sertifika
let swiper = new Swiper(".sertifika__container", {
  spaceBetween: 24,
  loop: true,
  grabCursor: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  breakpoints: {
    576: {
      slidesPerView: 1,
    },
    768: {
      slidesPerView: 3,
      spaceBetween: 48,
    },
  },
});

//Referance
let swiperr = new Swiper(".referance__container", {
  spaceBetween: 24,
  loop: true,
  grabCursor: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  breakpoints: {
    576: {
      slidesPerView: 1,
    },
    768: {
      slidesPerView: 2,
      spaceBetween: 48,
    },
  },
});

//INPUT

const inputs = document.querySelectorAll(".input");

function focusFunc() {
  let parent = this.parentNode;
  parent.classList.add("focus");
}

function blurFunc() {
  let parent = this.parentNode;
  if (this.value == "") {
    parent.classList.remove("focus");
  }
}

inputs.forEach((input) => {
  input.addEventListener("focus", focusFunc);
  input.addEventListener("blur", blurFunc);
});

//scroll
const sections = document.querySelectorAll("section[id]");

window.addEventListener("scroll", navHighlighter);

function navHighlighter() {
  let scrollY = window.pageYOffset;

  sections.forEach((current) => {
    const sectionHeight = current.offsetHeight;
    const sectionTop = current.offsetTop - 50;
    const sectionId = current.getAttribute("id");

    if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
      document
        .querySelector(".nav__menu a[href*=" + sectionId + "]")
        .classList.add("active-link");
    } else {
      document
        .querySelector(".nav__menu a[href*=" + sectionId + "]")
        .classList.remove("active-link");
    }
  });
}
