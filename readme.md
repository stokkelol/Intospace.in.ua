## Official Documentation

Intospace.in.ua source code. Powered by Laravel 5.2.

sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-worker:*
sudo systemctl status supervisor shows supervisor's status itself
sudo supervisorctl status shows running workers
To restart queue (need to run if jobs code was changed): php artisan queue:restart

Commands for Telegram bot:
help - help page
stop - stop broadcasting messages
start - start broadcasting messages
youtube - youtube search. example - /youtube slayer 
latest - latest 5 posts
blackmetal - random black metal post
deathmetal - random death metal post
sludge - random sludge post
technicaldeathmetal - random tech death metal post
sludgedoom - random sludgedoom post
experimental - random experimental post
psychedelic - random psychedelic post
doommetal - random doom metal post

Symfony\Component\Debug\Exception\FatalThrowableError: Type error: Argument 1 passed to App\Bot\ResponseMessages\CommandResponses\StatisticGatherer::associateBandAndUser() must be an instance of App\Models\Post, null given, called in /var/www/intospace/app/Bot/Jobs/Saver.php on line 43 in /var/www/intospace/app/Bot/ResponseMessages/CommandResponses/StatisticGatherer.php:26
Stack trace:
#0 /var/www/intospace/app/Bot/Jobs/Saver.php(43): App\Bot\ResponseMessages\CommandResponses\StatisticGatherer->associateBandAndUser(NULL, Object(App\Models\TelegramUser), Object(App\Models\TelegramUserRecommendation))
#1 /var/www/intospace/app/Bot/Jobs/MorningMessage.php(100): App\Bot\Jobs\MorningMessage->saveMessages()
#2 [internal function]: App\Bot\Jobs\MorningMessage->handle()
#3 /var/www/intospace/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)
#4 /var/www/intospace/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\Container\BoundMethod::Illuminate\Container\{closure}()
#5 /var/www/intospace/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\Container\BoundMethod::callBoundMethod(Object(Illuminate\Foundation\Application), Array, Object(Closure))
#6 /var/www/intospace/vendor/laravel/framework/src/Illuminate/Container/Container.php(549): Illuminate\Container\BoundMethod::call(Object(Illuminate\Foundation\Application), Array, Array, NULL)
#7 /var/www/intospace/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(94): Illuminate\Container\Container->call(Array)
#8 /var/www/intospace/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(114): Illuminate\Bus\Dispatcher->Illuminate\Bus\{closure}(Object(App\Bot\Jobs\MorningMessage))
#9 /var/www/intospace/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(102): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}(Object(App\Bot\Jobs\MorningMessage))
#10 /var/www/intospace/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(98): Illuminate\Pipeline\Pipeline->then(Object(Closure))
#11 /var/www/intospace/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(49): Illuminate\Bus\Dispatcher->dispatchNow(Object(App\Bot\Jobs\MorningMessage), false)
#12 /var/www/intospace/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(76): Illuminate\Queue\CallQueuedHandler->call(Object(Illuminate\Queue\Jobs\RedisJob), Array)
#13 /var/www/intospace/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(320): Illuminate\Queue\Jobs\Job->fire()
#14 /var/www/intospace/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(270): Illuminate\Queue\Worker->process('redis', Object(Illuminate\Queue\Jobs\RedisJob), Object(Illuminate\Queue\WorkerOptions))
#15 /var/www/intospace/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(114): Illuminate\Queue\Worker->runJob(Object(Illuminate\Queue\Jobs\RedisJob), 'redis', Object(Illuminate\Queue\WorkerOptions))
#16 /var/www/intospace/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(101): Illuminate\Queue\Worker->daemon('redis', 'default', Object(Illuminate\Queue\WorkerOptions))
#17 /var/www/intospace/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(85): Illuminate\Queue\Console\WorkCommand->runWorker('redis', 'default')
#18 [internal function]: Illuminate\Queue\Console\WorkCommand->handle()
#19 /var/www/intospace/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(29): call_user_func_array(Array, Array)
#20 /var/www/intospace/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(87): Illuminate\Container\BoundMethod::Illuminate\Container\{closure}()
#21 /var/www/intospace/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(31): Illuminate\Container\BoundMethod::callBoundMethod(Object(Illuminate\Foundation\Application), Array, Object(Closure))
#22 /var/www/intospace/vendor/laravel/framework/src/Illuminate/Container/Container.php(549): Illuminate\Container\BoundMethod::call(Object(Illuminate\Foundation\Application), Array, Array, NULL)
#23 /var/www/intospace/vendor/laravel/framework/src/Illuminate/Console/Command.php(180): Illuminate\Container\Container->call(Array)
#24 /var/www/intospace/vendor/symfony/console/Command/Command.php(240): Illuminate\Console\Command->execute(Object(Symfony\Component\Console\Input\ArgvInput), Object(Illuminate\Console\OutputStyle))
#25 /var/www/intospace/vendor/laravel/framework/src/Illuminate/Console/Command.php(167): Symfony\Component\Console\Command\Command->run(Object(Symfony\Component\Console\Input\ArgvInput), Object(Illuminate\Console\OutputStyle))
#26 /var/www/intospace/vendor/symfony/console/Application.php(858): Illuminate\Console\Command->run(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#27 /var/www/intospace/vendor/symfony/console/Application.php(216): Symfony\Component\Console\Application->doRunCommand(Object(Illuminate\Queue\Console\WorkCommand), Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#28 /var/www/intospace/vendor/symfony/console/Application.php(122): Symfony\Component\Console\Application->doRun(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#29 /var/www/intospace/vendor/laravel/framework/src/Illuminate/Console/Application.php(88): Symfony\Component\Console\Application->run(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#30 /var/www/intospace/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(121): Illuminate\Console\Application->run(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#31 /var/www/intospace/artisan(35): Illuminate\Foundation\Console\Kernel->handle(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#32 {main}

