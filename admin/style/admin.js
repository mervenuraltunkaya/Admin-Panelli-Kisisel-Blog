//scroll

// Sayfadaki belirli bölümleri seç
const sections = document.querySelectorAll(
  "section.admin, section.home,section.settings"
);

// Kaydırma olayı gerçekleştiğinde tetiklenecek fonksiyon
window.addEventListener("scroll", navHighlighter);

function navHighlighter() {
  // Sayfanın dikey kaydırma miktarını al
  let scrollY = window.pageYOffset;

  // Her bir bölüm için işlem yap
  sections.forEach((current) => {
    // Bölümün yüksekliğini al
    const sectionHeight = current.offsetHeight;
    // Bölümün sayfa üzerindeki konumunu belirle (sayfanın üstünden 50 piksel daha yukarıda)
    const sectionTop = current.offsetTop - 50;
    // Bölümün id'sini al
    const sectionId = current.getAttribute("id");

    // Eğer sayfanın dikey kaydırma miktarı, bölümün üstünden daha büyük ve bölümün altında ise
    if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
      // İlgili menü öğesine (link) "active-link" sınıfını ekle
      document
        .querySelector(".nav__menu a[href*=" + sectionId + "]")
        .classList.add("active-link");
    } else {
      // Eğer sayfanın dikey kaydırma miktarı, bölümün üstünden daha küçük veya bölümün altındaysa
      // İlgili menü öğesinden "active-link" sınıfını kaldır
      document
        .querySelector(".nav__menu a[href*=" + sectionId + "]")
        .classList.remove("active-link");
    }
  });
}
