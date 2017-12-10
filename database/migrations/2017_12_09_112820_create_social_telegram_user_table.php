<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateSocialTelegramUserTable
 */
class CreateSocialTelegramUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_telegram_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('social_id');
            $table->string('value', 191);

            $table->foreign('user_id')
                  ->references('id')
                  ->on('telegram_users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('social_id')
                ->references('id')
                ->on('socials')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('social_telegram_user');
    }
}
