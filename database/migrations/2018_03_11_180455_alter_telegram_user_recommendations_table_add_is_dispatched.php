<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class AlterTelegramUserRecommendationsTableAddIsDispatched
 */
class AlterTelegramUserRecommendationsTableAddIsDispatched extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('telegram_user_recommendations', function (Blueprint $table) {
            $table->boolean('is_dispatched')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('telegram_user_recommendations', function (Blueprint $table) {
            $table->dropColumn('is_dispatched');
        });
    }
}
