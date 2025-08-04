document.addEventListener("DOMContentLoaded", function () {
    const carousel = document.querySelector('.carousel-inner');
    const items = carousel.querySelectorAll('.carousel-item');
    const thumbnails = document.querySelectorAll('.thumbnail .item');
    const prevBtn = document.getElementById('prev');
    const nextBtn = document.getElementById('next');
    let currentIndex = 0;

    function showSlide(index) {
        items.forEach((item, i) => {
            item.classList.remove('active');
            if (i === index) {
                item.classList.add('active');
            }
        });
        currentIndex = index;
    }

    thumbnails.forEach((thumb, index) => {
        thumb.addEventListener('click', () => {
            showSlide(index);
        });
    });

    nextBtn.addEventListener('click', () => {
        let nextIndex = (currentIndex + 1) % items.length;
        showSlide(nextIndex);
    });

    prevBtn.addEventListener('click', () => {
        let prevIndex = (currentIndex - 1 + items.length) % items.length;
        showSlide(prevIndex);
    });
});




  