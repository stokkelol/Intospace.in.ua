<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateInlineQuerieResultsTable
 */
class CreateInlineQueryResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inline_query_results', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('result_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('location', 191)->nullable();
            $table->string('message_id', 191)->nullable();
            $table->text('query');
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('telegram_users')
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
        Schema::dropIfExists('inline_query_results');
    }
}
