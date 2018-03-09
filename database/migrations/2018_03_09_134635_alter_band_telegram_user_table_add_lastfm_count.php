<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class AlterBandTelegramUserTableAddLastfmCount
 */
class AlterBandTelegramUserTableAddLastfmCount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('band_telegram_user', function (Blueprint $table) {
            $table->unsignedInteger('lastfm_count')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('band_telegram_user', function (Blueprint $table) {
            $table->dropColumn('lastfm_count');
        });
    }
}
