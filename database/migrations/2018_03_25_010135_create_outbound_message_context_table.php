<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateOutboundMessageContextTable
 */
class CreateOutboundMessageContextTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outbound_message_contexts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('outbound_message_id')->nullable();
            $table->unsignedSmallInteger('band_id')->nullable();
            $table->unsignedSmallInteger('album_id')->nullable();
            $table->unsignedSmallInteger('track_id')->nullable();
            $table->timestamps();

            $table->foreign('outbound_message_id')
                  ->references('id')
                  ->on('outbound_messages')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('band_id')
                ->references('id')
                ->on('bands')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('album_id')
                ->references('id')
                ->on('albums')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('track_id')
                ->references('id')
                ->on('tracks')
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
        Schema::dropIfExists('outbound_message_contexts');
    }
}
