/*

фильтрация
кнопки открытия/закрытия подробностей теста
меняет размер текста в слайдере баннера, если символов много
прокрутка слайдера

*/


/*
//const textBanner = document.querySelector(".text-banner")
буквы меняются при наведении
textBanner.innerHTML = textBanner.innerText.split('').map((letters, i) => `<span style="transition-delay: ${i * 40}ms;">${letters}</span>`).join('');
*/

// //отмена перезагрузки

// window.addEventListener('beforeunload', (event) => {
//   event.preventDefault()
//   event.returnValue = ''
// });

//вывод тестов
const gridBox = document.querySelector('.grid-box')

getTestsfromDB(dataBDtests) 

function getTestsfromDB(arrayTests){
  //console.log(arrayTests)
  if(arrayTests.length == 0){
    gridBox.innerHTML = '<div class="non-tests">Нет тестов</div>'
    return
  }
  gridBox.innerHTML = '';
  arrayTests.forEach((test) => {
    let date = test['create_date'].split("-");
    if(test['countQuest'] > 0){ 
      gridBox.innerHTML += `
        <div class="box">
            <p class="title-test">${test.name}</p>
            <div class="btn-check-test">
                <a id="btn-info-test" data-path="box-${test.id_test}">Подробнее</a>
            </div>
            <p class="description-test">${test.description}</p>
        </div>
          
        <!-- попап с подробностями теста -->
        <div class="body-info-test" data-target="box-${test.id_test}">
          <div class="content-info-test">
            <div id="close-info-test" class="close-info-test" data-close="box-${test.id_test}">X</div>
            <h3 class="title-info-test">
                ${test.name}
                <span class="age-metka">${test['age-metka']}+</span>
            </h3>

            <p class="description-info-test">${test.description}</p>
            <p>Тип теста: ${test['type-category']}</p>
            <p>Дата создания: ${date[2] + '.' + date[1] + '.' + date[0]}</p>
            <p>Количество вопросов: ${test['countQuest']}</p>
            <div class="start-test">
              <a href="testing?id_test=${test.id_test}&name_test=${test.name}" id="btn-start-test" >Пройти</a>
            </div> 
          </div>
        </div>`
      }else{
        gridBox.innerHTML += `
        <div class="box">
            <p class="title-test">${test.name}</p>
            <div class="btn-check-test">
                <a id="btn-info-test" data-path="box-${test.id_test}">Подробнее</a>
            </div>
            <p class="description-test">${test.description}</p>
        </div>
          
        <!-- попап с подробностями теста -->
        <div class="body-info-test" data-target="box-${test.id_test}">
          <div class="content-info-test">
            <div id="close-info-test" class="close-info-test" data-close="box-${test.id_test}">X</div>
            <h3 class="title-info-test">
                ${test.name}
                <span class="age-metka">${test['age-metka']}+</span>
            </h3>

            <p class="description-info-test">${test.description}</p>
            <p>Тип теста: ${test['type-category']}</p>
            <p>Дата создания: ${date[2] + '.' + date[1] + '.' + date[0]}</p>
            <p>Количество вопросов: ${test['countQuest']}</p>
          </div>
        </div>`
      }
  })

  //кнопки открытия/закрытия подробностей теста
  const btnInfoTest = document.querySelectorAll("#btn-info-test")
  const closeInfoTest = document.querySelectorAll("#close-info-test")

  for(btn of btnInfoTest){
      btn.addEventListener('click', (e) => {
          activeNoScroll()
          let path = e.currentTarget.getAttribute('data-path');
          document.querySelector(`[data-target="${path}"]`).classList.add('active-info-test')
      })
  }
  for(close of closeInfoTest){
      close.addEventListener('click', (e) => {
          removeNoScroll()
          let path = e.currentTarget.getAttribute('data-close');
          //console.log(e)
          document.querySelector(`[data-target="${path}"]`).classList.remove('active-info-test')
      })
  }

}

//фильтрация
const formFilter = document.querySelector(".form-filter")
const searchNameTests = document.querySelector('.search')
const showFilter = document.querySelector('#show-filter')
const sbros = document.querySelector('#sbros')
const filtersType = document.querySelector('.filter select')
const filtersAge = document.querySelector('.filter input[name="age-metka"]')
const boxTest = document.querySelector('.box')

//let formDataFilter = new FormData()

formFilter.addEventListener('click', (event) => {

  let arrTestsFilter = []
  let namesearch = ''
  let type = ''
  let age = 1000
  
  if(showFilter.contains(event.target)){
    event.preventDefault();
    showFilter.disabled = true
    //setTimeout(() => showFilter.disabled = false, 500);
    
    if(searchNameTests.value != ''){
      namesearch = searchNameTests.value.toUpperCase();
    }
    if(filtersType.value != 'non'){
      switch (filtersType.value) {
        case 'psix':
          type = 'Психологический'
        case 'prof':
          type = 'Профориентационный'
        case 'other':
          type = 'Другое'
        default:
          break
      }
    }
    if(filtersAge.value != ''){
      age = filtersAge.value;
    }

    dataBDtests.forEach(el => {
      // console.log(el)
      // console.log('name - ' + `${el['name'].indexOf(namesearch) >= 0}`)
      // console.log('type - ' + `${el['type-category'].indexOf(type) >= 0}`)
      // console.log('age - ' + `${el['age-metka'] <= parseInt(age)}`)
      if (el['name'].toUpperCase().indexOf(namesearch) >= 0 && el['type-category'].indexOf(type) >= 0 && el['age-metka'] <= parseInt(age) ) {
          arrTestsFilter.push(el) 
      }
    });
    //console.log(arrTestsFilter.length)
    if(arrTestsFilter.length != dataBDtests.length){
      sbros.classList.add('show')
      getTestsfromDB(arrTestsFilter) 
    }
    showFilter.disabled = false

    // //добавление данных в объект
    // formDataFilter.append( 'action', 'filter_test' )
    // formDataFilter.append(searchNameTests.name, searchNameTests.value)
    // formDataFilter.append(filtersType.name, filtersType.value)
    // formDataFilter.append(filtersAge.name, filtersAge.value)
    // //ajax запрос (фильтрация)
    // fetch(ajax_object.ajax_url, {
    //   method: 'POST',
    //   body: formDataFilter
    // })
    // .then(response => response.json())
    // .then(data => {
    //     //вызов функции вывода отфильтрованных данных
    //     getTestsfromDB(data) 
    //     //console.log(data)
    // })
    // .catch(error => {
    //     console.error('Error:', error)
    // });
  }

  if(sbros.contains(event.target)){
    event.preventDefault();
    getTestsfromDB(dataBDtests) 
    searchNameTests.value = ''
    filtersAge.value = ''
    filtersType.value = 'non'

    sbros.classList.remove('show')
  }
  

});


//меняет размер текста в слайдере баннера, если символов много
const textSlider = document.querySelectorAll('.text-slider')

let textSliderLenhgth;
textSlider.forEach((ts) =>{
    textSliderLenhgth = ts.innerText.split('').length
    if (textSliderLenhgth > 30) {
        ts.style.fontSize = 'calc(0.8rem + 6 * (100vw / 1280))';
    } else {
        ts.style.fontSize = 'calc(1rem + 6 * (100vw / 1280))';
    }
})


//прокрутка слайдера
const allSlides = document.querySelector('.sliders')
const slides = document.querySelectorAll('.box-slider')
const prevButton = document.querySelector('.prev-button')
const nextButton = document.querySelector('.next-button')


widthAllSlides = slides[0].offsetWidth * (slides.length-1) ;
prevButton.addEventListener('click', (e) => {
  move = allSlides.scrollLeft - slides[0].offsetWidth;
  move = move < 0 ? 0 : move;
  allSlides.scrollTo({
    left: move,
    top: 0,
    behavior: 'smooth'
  });
});
nextButton.addEventListener('click', (e) => {
  move = allSlides.scrollLeft + slides[0].offsetWidth;
  move = move > widthAllSlides ? widthAllSlides : move;
  allSlides.scrollTo({
    left: move,
    top: 0,
    behavior: 'smooth'
  });
});

