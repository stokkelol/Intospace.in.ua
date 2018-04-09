<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class AlterTelegramUserRecommendationsTableAddType
 */
class AlterTelegramUserRecommendationsTableAddType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('telegram_user_recommendations', function (Blueprint $table) {
            $table->unsignedSmallInteger('type')->nullabe()->default(null);
            $table->unsignedInteger('outbound_message_id')->nullable();

            $table->foreign('outbound_message_id')
                  ->references('id')
                  ->on('outbound_messages')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
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
            $table->dropColumn('type');

            $table->dropForeign(['outbound_message_id']);
            $table->dropColumn('outbound_message_id');
        });
    }
}
