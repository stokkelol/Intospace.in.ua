## Official Documentation

Intospace.in.ua source code. Powered by Laravel 5.2.

Install supervisor: sudo apt-get install supervisor

Create config file sudo nano /etc/supervisor/conf.d/laravel-worker.conf with content from storage/server-configs/etc/supervisor/conf.d/laravel-worker.conf

Give it execute permissions: sudo chmod +x /etc/supervisor/conf.d/laravel-worker.conf

sudo supervisorctl reread

sudo supervisorctl update

sudo supervisorctl start laravel-worker:*

sudo systemctl status supervisor shows supervisor's status itself

sudo supervisorctl status shows running workers

To restart queue (need to run if jobs code was changed): php artisan queue:restart