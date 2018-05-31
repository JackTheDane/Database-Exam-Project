window.onload = e =>  {
    const body = document.getElementsByTagName('body')[0];

    body.style.opacity = '1';
}

localStorage.logWindowOpen = localStorage.logWindowOpen !== null && localStorage.logWindowOpen !== 'undefined' ? localStorage.logWindowOpen : 0;

let logWindow = document.getElementById('logWindow');
const buttonMinLog = document.getElementById('buttonMinLog');

let aLogItems = document.querySelectorAll('#logWindow .list-group-item');

buttonMinLog.addEventListener('click', e =>{
    logWindow.classList.toggle('closed');

    localStorage.logWindowOpen = !JSON.parse(localStorage.logWindowOpen);
})

aLogItems.forEach(item => {
    item.addEventListener('click', function() {
        
        // Remove all classes
        aLogItems.forEach(el => {
            el.classList.remove('isActive');
        });

        this.classList.add('isActive');
    });
});

