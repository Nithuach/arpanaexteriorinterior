window.addEventListener('scroll', function() {
    const nav = document.querySelector('.nav-bottom');
    if (window.scrollY > 0) {
        nav.classList.add('sticky');
    } else {
        nav.classList.remove('sticky');
    }
});

function openLightbox(src) {
    var lightbox = document.getElementById('lightbox');
    var lightboxImg = document.getElementById('lightbox-img');
    lightboxImg.src = src;
    lightbox.style.display = 'flex';
}

function closeLightbox() {
    var lightbox = document.getElementById('lightbox');
    lightbox.style.display = 'none';
}
