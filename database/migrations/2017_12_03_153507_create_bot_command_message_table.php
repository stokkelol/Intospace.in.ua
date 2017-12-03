<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateBotCommandMessageTable
 */
class CreateBotCommandMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bot_command_message', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('inbound_message_id');
            $table->unsignedInteger('bot_command_id');

            $table->foreign('inbound_message_id')
                  ->references('id')
                  ->on('inbound_messages')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('bot_command_id')
                ->references('id')
                ->on('bot_commands')
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
        Schema::dropIfExists('bot_command_message');
    }
}
