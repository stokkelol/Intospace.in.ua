<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateEditedMessagesTable
 */
class CreateEditedMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edited_massages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('chat_id');
            $table->unsignedBigInteger('message_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamp('time')->nullable();
            $table->text('text');
            $table->text('entities');
            $table->text('caption');
            $table->timestamps();

            $table->index(['chat_id', 'message_id']);

            $table->foreign('chat_id')
                  ->references('id')
                  ->on('chats');

            $table->foreign('user_id')
                ->references('id')
                ->on('telegram_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('edited_massages');
    }
}
