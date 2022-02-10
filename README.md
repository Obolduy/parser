<ul>
    <li>PHP: PHP 7.3</li>
    <li>Framework: Laravel 8</li>
    <li>DB: MySQL 8</li>
    <li>Server: Apache 2.4</li>
    <li>Libraries: PHPExcel, PHPQuery</li>
</ul>

<p>This is a brandshop.ru parser. The idea is it takes 240 sales and parse it into .xls table. Also if you have an account at my other <a href="https://github.com/Obolduy/linkcutter">project</a>, you can receive table with cutted links to watch statistics in Linkcutter.</p>

<h2>API</h2>
<p>API returns JSON with parsed data. Just send get-request to /api/getsales. You don`t need account or something to do this.</p>

<h2>Run</h2>
<p>You can run this app via docker-compose up, then you need type docker exec <CONTAINER ID> bash -c "php artisan migrate" to migrate DB and try it on <a href="http://127.0.0.1:8100">http://127.0.0.1:8000</a>.</p>