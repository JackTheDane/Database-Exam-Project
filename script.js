localStorage.logWindowOpen = localStorage.logWindowOpen !== null ? localStorage.logWindowOpen : 0;

let logWindow = document.getElementById('logWindow');
const buttonMinLog = document.getElementById('buttonMinLog');

buttonMinLog.addEventListener('click', e =>{
    logWindow.classList.toggle('closed');

    localStorage.logWindowOpen = !JSON.parse(localStorage.logWindowOpen);
})