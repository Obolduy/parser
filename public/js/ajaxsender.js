btn__getTable.addEventListener('click', (event) => {
    event.preventDefault();
    event.target.innerHTML = 'Пожалуйста, подождите';

    getTables().then(() => {
        event.target.innerHTML = 'Все готово!';
        event.target.setAttribute('disabled', true);
    });
})

async function getTables() {
    let response = await fetch('/getsales', {
        method: 'GET'
    });

    if (response.ok) {
        window.open("/getsales/table");

        let json = await response.json();

        let rows = `<table><tr><th>Полная ссылка</th><th>Короткая ссылка</th></tr>`

        for (let link in json) {
            rows += `<tr><td><a href="${link}">${link}</a></td><td><a href="${json[link]}">${json[link]}</a></td></tr>`
        }

        rows += '<table>';
        link__table.innerHTML = rows
    }
}