<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class AlterOutboundMessagesTableAddIsLiked
 */
class AlterOutboundMessagesTableAddIsLiked extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('outbound_messages', function (Blueprint $table) {
            $table->boolean('is_liked')->nullable()->default(null);
            $table->unsignedBigInteger('inbound_message_id')->nullable();
        });

        Schema::table('band_telegram_user', function (Blueprint $table) {
            $table->boolean('likes_count')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('outbound_messages', function (Blueprint $table) {
            $table->dropColumn('is_liked');
            $table->dropColumn('inbound_message_id');
        });

        Schema::table('band_telegram_user', function (Blueprint $table) {
            $table->dropColumn('likes_count');
        });
    }
}
