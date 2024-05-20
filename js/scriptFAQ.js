document.addEventListener('DOMContentLoaded', function() {
    let questions = document.querySelectorAll('.question');

    questions.forEach(question => {
        question.addEventListener('click', () => {
            question.classList.toggle('active');
            let answer = question.nextElementSibling;
            if (question.classList.contains('active')) {
                answer.style.height = answer.scrollHeight + 'px';
            } else {
                answer.style.height = '0';
            }
        });
    });
});

let volver = document.querySelector('.atras img');

volver.addEventListener("click",()=>{
    history.back();
})
