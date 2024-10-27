
// //отмена перезагрузки

// window.addEventListener('beforeunload', (event) => {
//   event.preventDefault()
//   event.returnValue = ''
// });

//вывод тестов
const lentaTest = document.querySelector('.lenta-tests')

getTestsfromDB(dataBDtests) 

function getTestsfromDB(arrayTests){
  //console.log(arrayTests)
  if(arrayTests.length == 0){
    lentaTest.innerHTML = '<div class="non-tests">Нет тестов</div>'
    return
  }
  lentaTest.innerHTML = '';
  arrayTests.forEach((test) => {
    let date = test['create_date'].split("-");
    lentaTest.innerHTML += `
    <div class="elem">
        <div class="info-test">
            <p class="title-test">${test.name}<span class="age-metka">${test['age-metka']}+</span></p>
            <p class="description-test">${test.description}</p>
        </div>
        <div class="m-icon"><img src="${wpsite.template_url + '/img/gear.png'}" alt="" class="img-gear"></div>
        <div class="icons"> 
            <a href="statistictest?id_test=${test.id_test}"><img src="${wpsite.template_url + '/img/grafic.png'}" alt="" class="img-modif"></a>
            <a href="updatatest?id_test=${test.id_test}"><img src="${wpsite.template_url + '/img/pencil.png'}" alt="" class="img-modif"></a>
            <a href="addtest?id_test=${test.id_test}"><img src="${wpsite.template_url + '/img/add.png'}" alt="" class="img-modif"></a>
            <img src="${wpsite.template_url + '/img/trash.png'}" alt="" class="img-modif" id="img-delete" data-path="elem-${test.id_test}">
            <div class="closeIcons">X</div>
        </div>

        <!-- попап с подробностями теста -->
        <div class="body-info-test" data-target="elem-${test.id_test}">
          <div class="content-info-test">
            <div id="close-info-test" class="close-info-test" data-close="elem-${test.id_test}">X</div>
            <h3 class="title-info-test">
                ${test.name}
                <span class="age-metka">${test['age-metka']}+</span>
            </h3>
    
            <p class="description-info-test">${test.description}</p>
            <p>Тип теста: ${test['type-category']}</p>
            <p>Дата создания: ${date[2] + '.' + date[1] + '.' + date[0]}</p>
            <p>Количество вопросов: ${test['countQuest']}</p>
            <div class="delete-test">
              <a id="delete-test" id-test="${test.id_test}">Удалить</a>
            </div> 
          </div>
        </div>
    </div>`
  })

  //отображение окна с удалением
  const imgDelete = document.querySelectorAll('#img-delete')
  const closeInfoTest = document.querySelectorAll("#close-info-test")

  for(img of imgDelete){
    img.addEventListener('click', (e) => {
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

  //удаление теста
  const btnDelete = document.querySelectorAll('#delete-test')
  let id 

    for(btn of btnDelete){
        btn.addEventListener('click', (e) => {
                id = e.currentTarget.getAttribute('id-test')

                let idTest = new FormData();
            
                //добавление данных в объект
                idTest.append( 'action', 'delete_test' )
                idTest.append( 'id', id)

                // for (let [key, value] of idTest) {
                //     console.log(`${key}: ${value}`)
                // }

                //ajax запрос удаление
                fetch(ajax_object.ajax_url, {
                  method: 'POST',
                  body: idTest
                })
                .then(response => response.json())
                .then(data => {
                    //console.log(data)
                    getTestsfromDB(data) 
                })
                .catch(error => {
                    console.error('Error:', error)
                });

                removeNoScroll()
                let path = e.currentTarget.getAttribute('data-close');
                //console.log(e)
                document.querySelector(`[data-target="elem-${id}"]`).classList.remove('active-info-test')
      

            })
    }

      
  //в мобил отображение инуструментов
  // const infoTest = document.querySelectorAll('.info-test')
  // const gear = document.querySelectorAll('.m-icon')
  // const icons = document.querySelectorAll('.icons')
  // const closeIcons = document.querySelectorAll('.closeXIcons')
  const elems = document.querySelectorAll('.elem')

  for (el of elems) {
    el.addEventListener('click', (e) => {
      //console.log(e.target.parentNode.parentNode.querySelector('.closeIcons'))
      if (e.target.classList.contains('img-gear')) {
        e.target.parentNode.classList.add('hide')
        e.target.parentNode.parentNode.querySelector('.icons').classList.add('show-flex')
        e.target.parentNode.parentNode.querySelector('.closeIcons').classList.add('show-flex')
      }
      if (e.target.classList.contains('closeIcons')) {
        e.target.parentNode.parentNode.querySelector('.m-icon').classList.remove('hide')
        e.target.parentNode.classList.remove('show-flex')
        e.target.querySelector('.closeIcons').classList.remove('show-flex')
      }
  
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
const boxTest = document.querySelector('.elem')

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
        
    }

    if(sbros.contains(event.target)){
        event.preventDefault();
        getTestsfromDB(dataBDtests) 
        searchNameTests.value = ''
        filtersAge.value = ''
        filtersType.value = 'non'
    
        sbros.classList.remove('show')
    }

})