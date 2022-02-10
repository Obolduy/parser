submit.addEventListener('click', (event) => {
    event.preventDefault();
    submit.value = "Пожалуйста, подождите";
    
    sendDataToCheck()
});

async function sendDataToCheck() {
    let body = {
        email: login__email.value,
        password: login__password.value
    };

    let response = await fetch('/login/checkdata', {
        method: 'POST',
        body: JSON.stringify(body),
        headers: {
            'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value
        }
    });

    if (response.ok) {
        let json = await response.json();
        
        if (json['ok']) {
            window.location.href='/';
        } else {
            login__error.innerHTML = 'Проверьте Email или пароль';
            login__error.style.color = 'red';
            
            submit.value = "Войти";
        }
    }
}