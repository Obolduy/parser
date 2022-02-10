ТЕСТЫ
ДОКУМЕНТАЦИЯ


Чтобы запустить приложение, введите docker-compose up, а затем docker exec <CONTAINER ID> bash -c "php artisan migrate".
docker exec `docker ps -l -q` bash -c "php artisan migrate"