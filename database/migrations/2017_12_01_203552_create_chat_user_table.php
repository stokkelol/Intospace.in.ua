<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateChatUserTable
 */
class CreateChatUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('chat_id');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('telegram_users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('chat_id')
                  ->references('id')
                  ->on('chats')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->index(['user_id', 'chat_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_user');
    }
}
