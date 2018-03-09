<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTeleramUserRecommendationsTable
 */
class CreateTelegramUserRecommendationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telegram_user_recommendations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('band_id')->nullable()->default(null);
            $table->json('payload')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('telegram_users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('band_id')
                ->references('id')
                ->on('bands')
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
        Schema::dropIfExists('telegram_user_recommendations');
    }
}
