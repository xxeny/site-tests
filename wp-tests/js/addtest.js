/*
отмена перезагрузки
добавление/удаление результатов
добавление/удаление вопросов
добавление/удаление ответов
обработка формы
    проверка основной информации теста
    проверка результата теста
    проверка общих ответов


*/

//отмена перезагрузки
function unload(event) {
    event.preventDefault()
    event.returnValue = ''
}

if(document.querySelector('form .content-form')){    
    window.addEventListener('beforeunload', unload)
}

//добавление/удаление результатов
const addResult = document.querySelector('#add-result')
const deletResult = document.querySelector('#delet-result')
const bodyResults = document.querySelector('.body-results')
let allElResult = document.querySelectorAll('.add-result')
let lastResult = ''
let numberResult = allElResult.length

addResult.addEventListener('click', (e) => {
    allElResult = document.querySelectorAll('.add-result')
    numberResult = allElResult.length
    bodyResults.insertAdjacentHTML('beforeend',`
                <div class="add-result"><a class="delet" id="delet-result">X</a>
                    <div class="result-and-value">    
                        <div class="text-result">
                            <label  id="numberResult">Текст результата ${++numberResult}</label>
                            <textarea name="result"  rows="3"></textarea>
                        </div>

                        <div class="container-value-results">
                            <label>Значение</label>
                            <div class="value-results">
                                <input name="valueOT" type="number" placeholder="от">
                                <input name="valueDO" type="number" placeholder="до">
                            </div>
                        </div>
                    </div>
                </div>`)
    
    allElResult = document.querySelectorAll('.add-result')
    
    deleteResult(allElResult[allElResult.length - 1])
  
})

allElResult.forEach(el => {
    deleteResult(el)
});

function deleteResult(el){

    el.querySelector('.delet').addEventListener('click', (e) => {
        el.remove();

        let numberAnswer = document.querySelectorAll('.add-result #numberResult')
        let k = 1
        numberAnswer.forEach(el => {
            //console.log(k)
            el.innerHTML = `Текст результата ${k}`
            k++
        });
    })

}


//добавление/удаление ответов ко всем вопросам
const addMainAnswer = document.querySelector('#add-main-answer')
const bodyMainAnswers = document.querySelector('.body-main-answer')
let allElMainAnswer = document.querySelectorAll('.add-main-answer')
let lastMainAnswer = ''
let numberMainAnswer = allElMainAnswer.length


addMainAnswer.addEventListener('click', (e) => {
    allElMainAnswer = document.querySelectorAll('.add-main-answer')
    numberMainAnswer = allElMainAnswer.length
    bodyMainAnswers.insertAdjacentHTML('beforeend',`
                    <div class="add-main-answer"><a class="delet" id="delet-main-answer">X</a>
                        <div class="answer-and-value">
                            <div class="text-main-answer">
                                <label id="numberMainAnswer">${++numberMainAnswer} ответ</label>
                                <input name="answer" type="text">
                            </div>

                            <div class="value-main-answer">
                                <label>Значение</label>
                            <input name="value" type="number">
                            </div>
                        </div>
                    </div>
    `)
    
    allElMainAnswer = document.querySelectorAll('.add-main-answer')
    deleteMainAnswer(allElMainAnswer[allElMainAnswer.length - 1])

})

allElMainAnswer.forEach(el => {
    deleteMainAnswer(el)
});

function deleteMainAnswer(el){

    el.querySelector('.delet').addEventListener('click', (e) => {
        el.remove();

        let numberAnswer = document.querySelectorAll('.add-main-answer #numberMainAnswer')
        let k = 1
        numberAnswer.forEach(el => {
            //console.log(k)
            el.innerHTML = `${k} ответ`
            k++
        });
    })

}


//добавление/удаление вопросов
const addQuestion = document.querySelector('#add-question')
const deletQuestion = document.querySelector('#delet-question')
const bodyQuestion = document.querySelector('.body-questions')
let allElQuestion = document.querySelectorAll('.add-question')
let lastQuestion = ''
let numberQuestion = allElQuestion.length


addQuestion.addEventListener('click', () => {
    allElQuestion = document.querySelectorAll('.add-question')
    numberQuestion = allElQuestion.length
    bodyQuestion.insertAdjacentHTML('beforeend',`
                <div class="add-question"><a class="delet" id="delet-question">X</a>
                    <div class="question-and-answers">
                        <label id="numberQuestion">${++numberQuestion} вопрос</label>
                        <textarea name="text-question"  rows="3"></textarea>

                        <div class="container-answer">
                            <div class="body-answer"></div>
                            <div class="add" id="add-answer">+ Добавить ответ</div>
                        </div>
                    </div>
                </div>`)
    
    allElQuestion = document.querySelectorAll('.add-question')
    deleteQuestion(allElQuestion[allElQuestion.length - 1])
    addDeletAnswer(allElQuestion[allElQuestion.length - 1])
  
})

allElQuestion.forEach(el => {
    deleteQuestion(el)
    addDeletAnswer(el)
});

function deleteQuestion(el){

    el.querySelector('.delet').addEventListener('click', (e) => {
        el.remove();

        let questionsNumber = document.querySelectorAll('.add-question #numberQuestion')
        let bodyAnswer = document.querySelectorAll('.add-question .body-answer')
        let kn = 1
        questionsNumber.forEach(el => {
            el.innerHTML = `${kn} вопрос`
            kn++
        });

    })

}


//удаление/добавление ответов к вопросам



function addDeletAnswer(question){

    let bodyAnswers = question.querySelector('.container-answer .body-answer') 
    let allElAnswer = question.querySelectorAll('.container-answer .add-answer') 
    const btnAddAnswer = question.querySelector('.container-answer #add-answer')
    let numberAnswer = allElAnswer.length

    allElAnswer.forEach( answer => {
        deleteAnswer(bodyAnswers, answer) 
    })

    btnAddAnswer.addEventListener('click', (e) =>{
        numberAnswer = question.querySelectorAll('.container-answer .add-answer').length

        bodyAnswers.insertAdjacentHTML('beforeend',`
                <div class="add-answer"><a class="delet" id="delet-answer">X</a>
                    <div class="answer-and-value">    
                        <div class="text-answer">
                            <label id="numberAnswer">${++numberAnswer} ответ</label>
                            <input name="answer" type="text">
                        </div>

                        <div class="value-answer">
                            <label>Значение</label>
                            <input name="value" type="number">
                        </div>
                    </div>
                </div>`)
        
        allElAnswer = question.querySelectorAll('.container-answer .add-answer')
        deleteAnswer(bodyAnswers, allElAnswer[allElAnswer.length - 1])
        

    })

    function deleteAnswer(question, answer) {

        answer.querySelector('.delet').addEventListener('click', (e) => {
            answer.remove();
    
            let answersNumber = question.querySelectorAll('.container-answer .add-answer #numberAnswer')
            // let bodyAnswer = document.querySelectorAll('.add-question .body-answer')
            let ka = 1
            answersNumber.forEach(el => {
                el.innerHTML = `${ka} ответ`
                ka++
            });
    
        })
    }

}


//обработка формы

const form = document.querySelector('form')
const btnCreate = document.querySelector('.btn-create')
const bodyError = document.querySelector('.error')

btnCreate.addEventListener('click', (e) => {
    e.preventDefault();
    btnCreate.disabled = true
    let err
    bodyError.classList.remove('show')
    bodyError.innerHTML = ''

    window.removeEventListener('beforeunload', unload)

    err = addInfoTest()
    
    if(err){
        bodyError.classList.add('show')
        bodyError.innerHTML += err
    } else {
        bodyError.classList.remove('show')
    }

    btnCreate.disabled = false
})

function addInfoTest() {

    //проверка основной информации теста
    const infTest = document.querySelectorAll('.add-test input, .add-test select, .add-test textarea')
    let formTestData = new FormData();
    formTestData.append( 'action', 'add_test' );

    for(el of infTest) {
        if(el.value.length){
            //console.log(el.name + ' ' + el.value) 
            formTestData.append(el.name, el.value)
        } else{
            switch (el.name) {
                case 'name':
                    return '<p>Введите название теста</p>'
                case 'age-metka':
                    return '<p>Введите возрастное ограничение теста</p>'
                case 'type-category':
                    return '<p>Введите категорию теста</p>' 
                case 'description':
                    return '<p>Введите описание теста</p>' 
                default:
                  break
              }
        }       
    }

    //проверка результата теста
    const resultTest = document.querySelectorAll('.body-results textarea')
    const valueOT = document.querySelectorAll('input[name="valueOT"]')
    const valueDO = document.querySelectorAll('input[name="valueDO"]')
    let textResTest = []
    let valueResTestOT = []
    let valueResTestDO = []
    let OT = 0
    let DO = 0

    if (resultTest.length == 0) {
        return '<p>Добавьте хотя бы один результат</p>'
    }

    for( el of resultTest ) {
        if( el.value.length ){
            textResTest.push(el.value)
        } else {
            return '<p>Введите текст результата теста или удалите поле</p>' 
        }
    }
    formTestData.append("text_result", JSON.stringify(textResTest))

    for( let i = 0; i < valueOT.length; i++ ) {
        OT = parseInt(valueOT[i].value)
        DO = parseInt(valueDO[i].value)
        console.log('a')
        console.log(valueOT[i].value.length + ' ' + valueDO[i].value.length)
        if( valueOT[i].value.length && valueDO[i].value.length ) {
            if( OT <= DO ){
                if( i > 0 ){
                    if( valueDO[i-1].value < OT ) {
                        valueResTestOT.push(OT)
                        valueResTestDO.push(DO)
                    } else {
                        return `<p>Значение следующего результата должно быть больше прошлого</p>`
                    }
                } else {
                    valueResTestOT.push(OT)
                    valueResTestDO.push(DO)
                }
            } else {
                return `<p>Первое значение должно быть меньше второго</p>`     
            }
        } else{
            return `<p>Введите оба значения результата теста, вы можете ввести одинаковое значение</p>`
        }
    }
    formTestData.append("value_result_ot", JSON.stringify(valueResTestOT))
    formTestData.append("value_result_do", JSON.stringify(valueResTestDO))

    //проверка общих ответов
    let checkMainAnswer = 0;
    let arrMainAnswerText = []
    let arrMainAnswerValue = []
    if(document.querySelectorAll('.body-main-answer input[name="answer"]').length > 0){
        checkMainAnswer = 1
    }

    if( checkMainAnswer == 1 ) {
        
        const mainAnswerText = document.querySelectorAll('.body-main-answer input[name="answer"]')      
        const mainAnswerValue = document.querySelectorAll('.body-main-answer input[name="value"]')

        for( let i = 0; i < mainAnswerText.length; i++ ) {
            //console.log(`${mainAnswerText[i].value} - ${mainAnswerValue[i].value}`)
            if( mainAnswerText[i].value.length ) {
                arrMainAnswerText.push(mainAnswerText[i].value)
            } else {
                return `<p>Введите текст ответов ко всем вопросам или удалите поле</p>`
            }
            if( mainAnswerValue[i].value.length ) {
                arrMainAnswerValue.push(mainAnswerValue[i].value)
            } else {
                return `<p>Введите значение ответов ко всем вопросам или удалите поле</p>`
            }

        }
    }
    
    formTestData.append("text_main_answer", JSON.stringify(arrMainAnswerText))
    formTestData.append("value_main_answer", JSON.stringify(arrMainAnswerValue))

    //проверка вопросов
    const valueQuestionsTest = document.querySelectorAll('.body-questions textarea[name="text-question"]')
    const questionsTest = document.querySelectorAll('.body-questions .add-question')
    let arrQuestionTest = []

    let arrAnswerText = {}
    let arrAnswerValue = {}

    if (questionsTest.length == 0) {
        return '<p>Добавьте хотя бы один вопрос</p>'
    }
    for (let i = 0; i < questionsTest.length; i++) {
        
        if(valueQuestionsTest[i].value.length) {
            //console.log(valueQuestionsTest[i].value)
            arrQuestionTest.push(valueQuestionsTest[i].value)
            
            //ответы
            const bodyAnswer = questionsTest[i].querySelector('.container-answer .body-answer')
            //console.log(bodyAnswer)
            const AnswerTest = bodyAnswer.querySelectorAll('.add-answer')
            const textAnswerTest = bodyAnswer.querySelectorAll('.add-answer input[name="answer"]')
            const valueAnswerTest = bodyAnswer.querySelectorAll('.add-answer input[name="value"]')

            let arrTA = []
            let arrVA = []

            //проверка 
            if(checkMainAnswer == 0) {
                if(AnswerTest.length == 0){
                    //console.log('aaa')
                    return `<p>Введите хотя бы один ответ к каждому вопросу</p> <p> Или создайте ответы ко всем вопросам</p>`
                } 
                
            } 

            for(let i = 0; i < AnswerTest.length; i++){
                if(!textAnswerTest[i].value.length || !valueAnswerTest[i].value.length){
                    return `<p>Введите текст и значение ответа или удалите поле</p>`
                }
            }
        
            //запись
            for (let i = 0; i < AnswerTest.length; i++) {
                arrTA.push(textAnswerTest[i].value)
                arrVA.push(valueAnswerTest[i].value)
                
            }
            
            arrAnswerText[i] = arrTA
            arrAnswerValue[i] = arrVA        

        } else {
            return `<p>Введите текст вопроса или удалите поле</p>`
        }
    }

    formTestData.append("text_question", JSON.stringify(arrQuestionTest))

    formTestData.append("text_answer", JSON.stringify(arrAnswerText))
    formTestData.append("value_answer", JSON.stringify(arrAnswerValue))

    //текущая дата
    let today = new Date();
    let dd = String(today.getDate()).padStart(2, '0')
    let mm = String(today.getMonth() + 1).padStart(2, '0') //январь 0
    let yyyy = today.getFullYear()

    today = yyyy + '-' + mm + '-' + dd

    
    formTestData.append("current_date", today)

    // for (let [key, value] of formTestData) {
    //     console.log(`${key}: ${value}`)
    // }

    //ajax запрос запись теста в бд
    fetch(ajax_object.ajax_url, {
        method: 'POST',
        body: formTestData
      })
      .then(response => response.text())
      .then(data => {
        if(data){
          console.log(data)
          getResultAddTest(data)
        }
      })
      .catch(error => {
          console.error('Error:', error)
      });

}

function getResultAddTest(data) {
    
    const bodyResultTest = document.querySelector(".body-result")
    const textResult = document.querySelector(".result")

    bodyResultTest.style.display = 'flex';
    textResult.innerHTML = data;

}





