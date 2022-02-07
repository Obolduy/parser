btn__getTable.addEventListener('click', (event) => {
    event.preventDefault();
    event.target.innerHTML = 'Пожалуйста, подождите';

    getTables();
    
    event.target.innerHTML = 'Все готово!';
    event.target.setAttribute('disabled', true);
})

async function getTables() {
    let response = await fetch('/getsales', {
        method: 'GET'
    });

    if (response.ok) {
        window.open("/getsales/table");

        let json = await response.json();

        console.log(json);
        let rows = `<table><tr><th>Полная ссылка</th><th>Короткая ссылка</th></tr>`

        for (let link in json) {
            rows += `<tr><td>${link}</td><td>${json[link]}</td></tr>`
            console.log(link, json[link]);
        }

        rows += '<table>';
        link__table.innerHTML = rows
    }
} 