let menuBtn = document.querySelector('#menu-btn');
let navbar = document.querySelector('.header .flex .navbar');
menuBtn.onclick = () => {
menuBtn.classList.toggle('fa-times');
navbar.classList.toggle('active');
}




function startQuiz() {
  document.querySelector('.intro-section').style.display = 'none'; // إخفاء المقدمة
  document.getElementById('quizSection').style.display = 'block';  // إظهار الأسئلة
}

