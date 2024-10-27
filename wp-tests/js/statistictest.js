
/*


*/

const btnType = document.querySelector('.body-type-statistic')
//const btnPodType = document.querySelector('.body-podtype')
const bodyStatistic = document.querySelector('.body-statictic')
const bodyBtnType = document.querySelectorAll('.btn-type')
//const bodyBtnPodType = document.querySelectorAll('.btn-podtype')
const myChart = document.querySelector('#myChart')

let ageX = []; let ageY = []
let genderX = []; let genderY = []
let dateX = []; let dateY = []
let resultX = []; let resultY = []
let testX = []; let testY = []


dataAge.forEach(el => {
    ageX.push(el.age)
    ageY.push(el.count_age)
});
dataGender.forEach(el => {
    if(el.gender == "f") {
        genderX.push('Женщины')
    } else if(el.gender == "m") {
        genderX.push('Мужчины')
    }
    genderY.push(el.count_gender)
});
dataDate.forEach(el => {
    dateX.push(el.date)
    dateY.push(el.count_date)
});
if(dataResult){
    dataResult.forEach(el => {
        resultX.push(el.result)
        resultY.push(el.count_result)
    });
}
if(dataTest){
    dataTest.forEach(el => {
        testX.push(el.name)
        testY.push(el.count_test)
    });
}
// console.log(ageX, ageY)
// console.log(genderX, genderY)
// console.log(dateX, dateY)
// console.log(testX, testY)
// console.log(resultX, resultY)


btnType.querySelector('#btn-age').addEventListener('click', (e) => {
    //btnPodType.classList.add('show-podtype')
    bodyBtnType.forEach(el => {
        if(el.id == 'btn-age'){
            el.classList.add('focus')
        }else{
            el.classList.remove('focus')
        }
    });
    getChart('line', ageX, ageY, 'Возраст')
})

btnType.querySelector('#btn-date').classList.add('focus')
getChart('line', dateX, dateY, 'Дата')
btnType.querySelector('#btn-date').addEventListener('click', (e) => {
    //btnPodType.classList.remove('show-podtype')
    bodyBtnType.forEach(el => {
        if(el.id == 'btn-date'){
            el.classList.add('focus')
        }else{
            el.classList.remove('focus')
        }
    });
    getChart('line', dateX, dateY, 'Дата')
})

btnType.querySelector('#btn-gender').addEventListener('click', (e) => {
    //btnPodType.classList.remove('show-podtype')
    bodyBtnType.forEach(el => {
        if(el.id == 'btn-gender'){
            el.classList.add('focus')
        }else{
            el.classList.remove('focus')
        }
    });
    //console.log(genderX)
    getChart('bar', genderX, genderY, 'Пол')
})

if(btnType.querySelector('#btn-result')){
    btnType.querySelector('#btn-result').addEventListener('click', (e) => {
        //btnPodType.classList.remove('show-podtype')
        bodyBtnType.forEach(el => {
            if(el.id == 'btn-result'){
                el.classList.add('focus')
            }else{
                el.classList.remove('focus')
            }
        });
        getChart('bar', resultX, resultY, 'Результат')
    })
}

if(btnType.querySelector('#btn-test')){
    btnType.querySelector('#btn-test').addEventListener('click', (e) => {
        //btnPodType.classList.remove('show-podtype')
        bodyBtnType.forEach(el => {
            if(el.id == 'btn-test'){
                el.classList.add('focus')
            }else{
                el.classList.remove('focus')
            }
        });
        getChart('bar', testX, testY, 'Тест')
    })
}

function getChart(type, X, Y, metka) {

    if(type == 'line'){
        new Chart(myChart, {
            type: type,
            data: {
            labels: X,
            datasets: [{
                borderColor: "rgb(101, 134, 183)",
                backgroundColor: 'transparent',
                data: Y,
            }]
            },
            beginAtZero: true,
            options: {
                responsive: true,
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: metka
                },
                animation: {
                    animateScale: true
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            precision: 0
                        }
                    }]
                }
            }
        });
    }
    if(type == 'bar'){
        Chart.defaults.global.defaultFontFamily = "Lato";
        Chart.defaults.global.defaultFontSize = 18;
        new Chart(myChart, {
            type: type,
            data: {
            labels: X,
            datasets: [{
                backgroundColor: ["#9aeec0", "#ffdb6e","#7ac0f5","#a5f084","#f0ff6e"],
                data: Y,
            }]
            },
            beginAtZero: true,
            options: {
                responsive: true,
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: metka
                },
                animation: {
                    animateScale: true
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            precision: 0
                        }
                    }]
                }
            }
        });
    }
    
    
}
