<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class AlterOutboundMessagesTableAddTextId
 */
class AlterOutboundMessagesTableAddTextId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('outbound_messages', function (Blueprint $table) {
            $table->dropColumn('text');

            $table->unsignedInteger('outbound_message_text_id')->nullable();

            $table->foreign('outbound_message_text_id')
                  ->references('id')
                  ->on('outbound_message_texts')
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
        Schema::table('outbound_messages', function (Blueprint $table) {
            $table->dropForeign(['outbound_message_text_id']);
            $table->dropColumn('outbound_message_text_id');

            $table->text('text');
        });
    }
}
