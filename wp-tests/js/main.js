const btnMiniBar = document.querySelector(".btn-mini-nav-bar")
const stealthBar = document.querySelector(".stealth-bar")
const closeStealthBar = document.querySelector(".close-stealth-bar")


function activeNoScroll() {
    const scrollY = document.documentElement.style.getPropertyValue('--scroll-y')
    const body = document.body
    body.style.height = '100vh'
    body.style.overflowY = 'hidden'
}

function removeNoScroll() {
    const body = document.body
    const scrollY = body.style.top
    body.style.height = ''
    body.style.overflowY = ''
}

btnMiniBar.addEventListener('click', () => {
    activeNoScroll()
    stealthBar.classList.add('active-bar')
    document.addEventListener('mousedown', (e) => {
        if(e.target.closest('.active-bar') === null){
            stealthBar.classList.remove('active-bar')
        }
    })
})

closeStealthBar.addEventListener('click', () => {
    removeNoScroll()
    stealthBar.classList.remove('active-bar')
})