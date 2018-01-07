<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateChatsTable
 */
class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->enum('type', ['private', 'group', 'supergroup', 'channel']);
            $table->string('title', 191)->nullable();
            $table->string('name', 191)->nullable();
            $table->unsignedTinyInteger('is_all_admins')->default(0);
            $table->unsignedBigInteger('old_chat_id')->nullable();
            $table->timestamps();

            $table->index('id');
            $table->index('old_chat_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
}
