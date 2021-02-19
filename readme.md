## Official Documentation

Intospace.in.ua source code. Powered by Laravel 5.2.

* `sudo supervisorctl reread`
* `sudo supervisorctl update`
* `sudo supervisorctl start laravel-worker:*`
* `sudo systemctl status supervisor shows supervisor's status itself`
* `sudo supervisorctl status shows running workers`
* To restart queue (need to run if jobs code was changed): php artisan queue:restart

* Commands for Telegram bot:

```help - help page
youtube - youtube search. example - /youtube slayer 
blackmetal - random black metal post
deathmetal - random death metal post
sludge - random sludge post
technicaldeathmetal - random tech death metal post
sludgedoom - random sludgedoom post
experimental - random experimental post
psychedelic - random psychedelic post
doommetal - random doom metal post
latest - latest 5 posts
post - random post 
stop - stop broadcasting messages
start - start broadcasting messages```

* Start Drone CI server:

* docker run \
    --volume=/opt/drone:/data \
    --env=DRONE_GITHUB_CLIENT_ID={{DRONE_GITHUB_CLIENT_ID}} \
    --env=DRONE_GITHUB_CLIENT_SECRET={{DRONE_GITHUB_CLIENT_SECRET}} \
    --env=DRONE_RPC_SECRET={{DRONE_RPC_SECRET}} \
    --env=DRONE_SERVER_HOST={{DRONE_SERVER_HOST}} \
    --env=DRONE_SERVER_PROTO={{DRONE_SERVER_PROTO}} \
    --publish=8080:80
    --restart=always \
    --detach=true \
    --name=drone \
    drone/drone:1