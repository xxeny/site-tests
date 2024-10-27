/*
константы, переменные
события формы
    смена вопросов 
    завершение теста
    заполнение данных для ajax запроса (почта)
    ajax запрос (почта)
получение текста результата, вывод попапа
ограничение выбора даты в input
проверка на правильный email
*/


if(document.querySelector('form')){

//отмена перезагрузки

function unload(event) {
    event.preventDefault()
    event.returnValue = ''
}

if(document.querySelector('form')){
    window.addEventListener('beforeunload', unload);
}

//константы, переменные
//объекты формы
const form = document.querySelector('.content-form-testing');
const radios = document.querySelectorAll('#radio-test');
const btnFinishTest = document.querySelector('.btn-finish-test');
const emailInput = document.querySelector('.email');
const allInput = document.querySelectorAll('input');

//смена вопросов
const question = document.querySelectorAll('.form-question');
const btnNext = document.querySelector('.next-question');
const btnPrev = document.querySelector('.prev-question');
let indexQ = 0;
let checkEnd = 0
let checkAge
let getCheckAge

//попап с результатом
const bodyResult = document.querySelector('.body-result');
const textResult = document.querySelector('.text-result');

const bodyAgeLimit = document.querySelector('.body-age-limit');

//объект данных для ajax запроса (почта)
let formData = new FormData();

//console.log(`${wpsite.template_url}/`)

//текущая дата
let today = new Date();
let dd = String(today.getDate()).padStart(2, '0')
let mm = String(today.getMonth() + 1).padStart(2, '0') //январь 0
let yyyy = today.getFullYear()

today = yyyy + '-' + mm + '-' + dd

function getAge(dateString) {
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}

//определяет выбраны ли ответы, чтобы отобразить кнопку далее
function checkValue() {
    
    let questionActive = document.querySelector('.active-question')

    let k

    if (questionActive.querySelector('input[name="birth"]')
        && questionActive.querySelector('input[name="gender"]')){
            if (questionActive.querySelector('input[name="birth"]').value
                && (questionActive.querySelectorAll('input[name="gender"]')[0].checked || questionActive.querySelectorAll('input[name="gender"]')[1].checked)){
                    getCheckAge = questionActive.querySelector('input[name="birth"]').value
                    btnNext.classList.remove('notvisible-btn')
                } else{
                    btnNext.classList.add('notvisible-btn')
                }
    } if(questionActive.querySelector('.answer input')){
        if (questionActive.querySelectorAll('.answer input')[0].checked || questionActive.querySelectorAll('.answer input')[1].checked) {
            btnNext.classList.remove('notvisible-btn')
        } else{
            btnNext.classList.add('notvisible-btn')
        }
    } 

}checkValue()

//отмена отправки формы при нажатии интер
form.addEventListener('keydown', function(event) {
    if(event.keyCode == 13) {
       event.preventDefault();
    }
 });

//события формы
form.addEventListener('click', (event) => {

    
    //смена вопросов 
    //next
    if(event.target.classList.contains('next-question')){
        event.preventDefault();
        btnNext.classList.add('notvisible-btn')
        if(indexQ < countQ){
            indexQ++;
            if(indexQ === countQ - 1){
                btnNext.classList.add('notvisible-btn')

            }
        }
        if(getCheckAge){
            checkAge = getAge(getCheckAge)
            if(checkAge < ageLimit){
                window.removeEventListener('beforeunload', unload)
                bodyAgeLimit.classList.add('show')

            } else{
                showQuestion();
            }
        } 

    }

    //prev
    if(event.target.classList.contains('prev-question')){
        event.preventDefault();
        if(indexQ > 0){
            indexQ--;
        }else{
            indexQ = 0;
        }
        
        showQuestion();
    }

    //завершение теста
    if(event.target.classList.contains('btn-finish-test')){
        event.preventDefault()
        checkEnd = 1
        btnPrev.classList.remove('notvisible-btn')
        window.removeEventListener('beforeunload', unload)
        event.disabled = true
        //подсчет результата
        let resultT = 0;
        for (let radio of radios) {
            if (radio.checked) {
                resultT += parseInt(radio.value);
            }
        }

    
        //заполнение объекта данными для ajax
        formData.append( 'action', 'test_result_action' );
        formData.append('for_id_test', id_test); 
        formData.append('name_test', nameTest);

        allInput.forEach((input) => {
            if(input.name == 'gender'){
                    if (input.checked) {
                        formData.append(input.name, input.value)                        
                    }
            }
            if(input.type != 'radio'){
                formData.append(input.name, input.value)
            }
        })

        formData.append('date', today);

        //вывод попап с текстом результата на экран 
        //и заполенение объекта id_result
        res = getResultTesting(dataResult, resultT);
        let err
        if(res == 'ne ok'){
            err = 'error'
            if (confirm('Произошла ошибка подсчета баллов, невозможно определить результат. Перезагрузить страницу и пройти тест заново?')) {
                window.location.reload()
            }
        }
        
        if(err != 'error'){
            
            // for (let [key, value] of formData) {
            //     console.log(`${key}: ${value}`)
            // }
        
            //ajax запрос presonDate
            fetch(ajax_object.ajax_url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if(data){
                    alert(data);
                    console.log(data);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    } else if(checkEnd != 1) {
        checkValue() 
    }
})

//получение текста результата, вывод попапа
function getResultTesting(arrResult, resultT){
    
    let valueResultOT
    let valueResultDO
    let txtResult
    let p = 0

    if(arrResult){
        arrResult.forEach((result) => {
            
            valueResultOT = result['value_ot']
            valueResultDO = result['value_do']
            
            if (valueResultOT <= resultT && resultT <= valueResultDO ) {
                p++
                txtResult = result.result
                bodyResult.classList.add('show')
                textResult.innerHTML = txtResult;

                const btnStay = document.querySelector('.stay')

                btnStay.addEventListener('click', () =>{
                    btnFinishTest.style.display = 'none'
                    allInput.forEach((input) => {
                        input.setAttribute("disabled", "")
                    });

                    bodyResult.classList.remove('show')

                });

                formData.append('for_id_result', result['id_result'])
                formData.append('result', txtResult)

                return 'ok'
            }

        });

        if(p == 0){
            return 'ne ok'
        }
    }   
}

//ограничение выбора даты в input, не позже текущей
function maxDateBirth(today) {
    let dateInput = document.querySelector('.date-birth')
    
    //console.log(today)
    dateInput.max = today;
};maxDateBirth(today);


//функция смены вопросов
function showQuestion() {

    question.forEach((q, index) => {
        if (index === indexQ) {
            if(index === 0){
                // console.log(index);
                btnPrev.classList.add('notvisible-btn');
            }
        
            if(index === (countQ  - 1)){
                btnNext.classList.add('notvisible-btn');
            }
            
            if (index != (countQ - 1) && checkEnd == 1) {
                btnNext.classList.remove('notvisible-btn');
            }
            if(index != 0 && checkEnd == 1) {
                btnPrev.classList.remove('notvisible-btn');
            }

            q.classList.add('active-question');

        } else {
            q.classList.remove('active-question');
        }
    });
}


let timer;
//проверка на правильный email
emailInput.addEventListener("input", () => {
    emailInput.style.background = '#fff'
    if (timer){
        clearTimeout(timer);
    }

    timer = setTimeout(() => {
        let valid = emailInput.value.match(
            /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            );
        if(!valid){
            emailInput.style.background = '#eaa'
        }
        else{
            emailInput.style.background = '#fff'
        }
    }, 1000);
    
})

}