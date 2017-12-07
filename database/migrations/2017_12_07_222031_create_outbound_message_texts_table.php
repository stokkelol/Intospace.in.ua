<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateOutboundMessageTextsTable
 */
class CreateOutboundMessageTextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outbound_message_texts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('outbound_message_id');
            $table->text('message');
            $table->timestamps();

            $table->foreign('outbound_message_id')
                  ->references('id')
                  ->on('outbound_messages')
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
        Schema::dropIfExists('outbound_message_texts');
    }
}
