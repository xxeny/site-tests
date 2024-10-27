
/*

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

//обработка формы

//вывод ошибок
const form = document.querySelector('form')
const btnUpdate = document.querySelector('.btn-update')
const bodyError = document.querySelector('.error')

btnUpdate.addEventListener('click', (e) => {
    e.preventDefault();
    btnUpdate.disabled = true
    let err = ''
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

    btnUpdate.disabled = false
})

//обработка ошибок, заполнение объекта введенными данными 
function addInfoTest() {
    //проверка основной информации теста
    const infTest = document.querySelectorAll('.add-test input, .add-test select, .add-test textarea')
    const blokInfo = document.querySelector('.add-test')
    let formTestData = new FormData();
    formTestData.append( 'action', 'update_test' )

    const id_test = blokInfo.getAttribute('elem-id')
    formTestData.append( 'id_test', id_test )

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
    let idResTest = []
    let OT = 0
    let DO = 0

    for( el of resultTest ) {
        if( el.value.length ){
            textResTest.push(el.value)
            idResTest.push(el.getAttribute('elem-id'))
        } else {
            return '<p>Введите текст результата теста</p>' 
        }
    }
    formTestData.append("id_result", JSON.stringify(idResTest))
    formTestData.append("text_result", JSON.stringify(textResTest))

    for( let i = 0; i < valueOT.length; i++ ) {
        OT = parseInt(valueOT[i].value)
        DO = parseInt(valueDO[i].value)
        if(  valueOT[i].value.length && valueDO[i].value.length  ) {
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
    let arrMainAnswerId = []
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
                arrMainAnswerId.push(mainAnswerText[i].getAttribute('elem-id'))
            } else {
                return `<p>Введите текст ответов ко всем вопросам</p>`
            }
            if( mainAnswerValue[i].value.length ) {
                arrMainAnswerValue.push(mainAnswerValue[i].value)
            } else {
                return `<p>Введите значение ответов ко всем вопросам</p>`
            }

        }
    }
    
    formTestData.append("text_main_id", JSON.stringify(arrMainAnswerId))
    formTestData.append("text_main_answer", JSON.stringify(arrMainAnswerText))
    formTestData.append("value_main_answer", JSON.stringify(arrMainAnswerValue))


    
    //проверка вопросов
    const valueQuestionsTest = document.querySelectorAll('.body-questions textarea[name="text-question"]')
    const questionsTest = document.querySelectorAll('.body-questions .add-question')
    let arrQuestionTest = []
    let idQuestionTest = []


    let arrAnswerText = {}
    let arrAnswerValue = {}
    let arrAnswerId = {}

    for (let i = 0; i < questionsTest.length; i++) {
        
        if(valueQuestionsTest[i].value.length) {
            arrQuestionTest.push(valueQuestionsTest[i].value)
            idQuestionTest.push(valueQuestionsTest[i].getAttribute('elem-id'))
            
            //ответы
            const bodyAnswer = questionsTest[i].querySelector('.container-answer .body-answer')
            const AnswerTest = bodyAnswer.querySelectorAll('.add-answer')
            const textAnswerTest = bodyAnswer.querySelectorAll('.add-answer input[name="answer"]')
            const valueAnswerTest = bodyAnswer.querySelectorAll('.add-answer input[name="value"]')

            let arrTA = []
            let arrVA = []
            let arrID = []

            //проверка 
            if(checkMainAnswer == 0) {
                if(AnswerTest.length == 0){
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
                arrID.push(textAnswerTest[i].getAttribute('elem-id'))
                arrTA.push(textAnswerTest[i].value)
                arrVA.push(valueAnswerTest[i].value)
            }
            
            arrAnswerId[i] = arrID
            arrAnswerText[i] = arrTA
            arrAnswerValue[i] = arrVA        

        } else {
            return `<p>Введите текст вопроса или удалите поле</p>`
        }
    }

    formTestData.append("id_question", JSON.stringify(idQuestionTest))
    formTestData.append("text_question", JSON.stringify(arrQuestionTest))

    
    formTestData.append("id_answer", JSON.stringify(arrAnswerId))
    formTestData.append("text_answer", JSON.stringify(arrAnswerText))
    formTestData.append("value_answer", JSON.stringify(arrAnswerValue))


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





