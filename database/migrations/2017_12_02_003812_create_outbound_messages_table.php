<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateOutboundMessagesTable
 */
class CreateOutboundMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outbound_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('message_type_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('chat_id')->nullable();
            $table->text('text');
            $table->timestamps();

            $table->foreign('message_type_id')
                  ->references('id')
                  ->on('message_types');

            $table->foreign('user_id')
                ->references('id')
                ->on('telegram_users');

            $table->foreign('chat_id')
                ->references('id')
                ->on('chats');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outbound_messages');
    }
}
