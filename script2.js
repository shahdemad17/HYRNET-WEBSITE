function setupVideoModal(modalId, videoId) {
    var videoModal = document.getElementById(modalId);
    var videoPlayer = document.getElementById(videoId);
  
    videoModal.addEventListener('shown.bs.modal', function () {
        videoPlayer.play();
    });
  
    videoModal.addEventListener('hidden.bs.modal', function () {
        videoPlayer.pause();
        videoPlayer.currentTime = 0;
    });
  }
  
  
  // Setup for all modals
  setupVideoModal('commVideoModal1', 'commVideoPlayer1');
  setupVideoModal('commVideoModal2', 'commVideoPlayer2');
  setupVideoModal('commVideoModal3', 'commVideoPlayer3');
  
  setupVideoModal('persVideoModal1', 'persVideoPlayer1');
  setupVideoModal('persVideoModal2', 'persVideoPlayer2');
  setupVideoModal('persVideoModal3', 'persVideoPlayer3');
  
  setupVideoModal('engVideoModal1', 'engVideoPlayer1');
  setupVideoModal('engVideoModal2', 'engVideoPlayer2');
  setupVideoModal('engVideoModal3', 'engVideoPlayer3');
  
  
  new Swiper(".swiper-container", {
    loop: true,
    spaceBetween: 30,
  
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
      pauseOnMouseEnter: true,
    },
  
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
      dynamicBullets: true,
    },
  
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  
    breakpoints: {
      0: {
        slidesPerView: 1,
      },
      768: {
        slidesPerView: 2,
      },
      1024: {
        slidesPerView: 3,
      },
    },
  });
  document.querySelectorAll('.btn-danger').forEach(button => {
    button.addEventListener('click', function () {
      const card = this.closest('.card');
      const form = card.querySelector('.payment-box');
      form.classList.toggle('d-none');
    });
  });
  const form = document.getElementById('paymentForm');
  const message = document.getElementById('confirmationMessage');
  
  form.addEventListener('submit', function (e) {
    e.preventDefault();
  
    // إظهار رسالة النجاح
     message.innerText = "Payment has been Completed successfully";
     message.classList.remove('d-none');
  
  
    // إعادة تعيين الفورم بعد ثانيتين
    setTimeout(() => {
      form.reset();
    }, 2000);
  });




  
