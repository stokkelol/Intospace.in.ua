<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateMessagesTable
 */
class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('chat_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('forward_from')->nullable();
            $table->unsignedBigInteger('forward_from_chat')->nullable();
            $table->unsignedBigInteger('forward_from_message')->nullable();
            $table->timestamp('forward_timestamp')->nullable();
            $table->unsignedBigInteger('reply_to_chat')->nullable();
            $table->unsignedBigInteger('reply_to_message')->nullable();
            $table->text('text')->nullable();
            $table->text('entities')->nullable();
            $table->text('audio')->nullable();
            $table->text('document')->nullable();
            $table->text('photo')->nullable();
            $table->text('sticker')->nullable();
            $table->text('video')->nullable();
            $table->text('voice')->nullable();
            $table->text('video_note')->nullable();
            $table->text('contact')->nullable();
            $table->text('location')->nullable();
            $table->text('venue')->nullable();
            $table->text('caption')->nullable();
            $table->text('new_chat_members')->nullable();
            $table->unsignedBigInteger('left_chat_user_id')->nullable();
            $table->string('new_chat_title', 191)->nullable();
            $table->text('new_chat_photo')->nullable();
            $table->unsignedTinyInteger('delete_chat_photo')->nullable();
            $table->unsignedTinyInteger('group_chat_created')->nullable();
            $table->unsignedTinyInteger('supergroup_chat_created')->nullable();
            $table->unsignedTinyInteger('channel_chat_created')->nullable();
            $table->unsignedTinyInteger('migrate_to_chat_id')->nullable();
            $table->unsignedTinyInteger('migrate_from_chat_id')->nullable();
            $table->text('pinned_message')->nullable();
            $table->timestamps();

            $table->index('id');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('telegram_users');

            $table->foreign('chat_id')
                ->references('id')
                ->on('chats');

            $table->foreign('forward_from')
                ->references('id')
                ->on('telegram_users');

            $table->foreign('forward_from_chat')
                ->references('id')
                ->on('chats');

            $table->foreign('left_chat_user_id')
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
        Schema::dropIfExists('messages');
    }
}
