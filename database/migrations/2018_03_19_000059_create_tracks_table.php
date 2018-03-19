<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTracksTable
 */
class CreateTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mbid', 191)->nullable();
            $table->string('title', 191);
            $table->unsignedInteger('album_id')->nullable();
            $table->unsignedInteger('band_id')->nullable();
            $table->string('disambiguation')->nullable()->default(null);
            $table->unsignedTinyInteger('position')->nullable();
            $table->unsignedInteger('length')->nullable();
            $table->timestamps();

            $table->foreign('album_id')
                  ->references('id')
                  ->on('albums')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('band_id')
                  ->references('id')
                  ->on('bands')
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
        Schema::dropIfExists('tracks');
    }
}
