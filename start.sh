# crond -s 

echo "Запуск supervisord..."
exec supervisord -c /etc/supervisord.conf 
# sleep 10
# php artisan octane:start --server=swoole --host=0.0.0.0 --port=8000
