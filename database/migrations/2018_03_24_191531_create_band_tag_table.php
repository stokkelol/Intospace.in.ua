<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateBandTagTable
 */
class CreateBandTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('band_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('band_id');
            $table->unsignedInteger('tag_id');
            $table->unsignedSmallInteger('value');

            $table->foreign('band_id')
                  ->references('id')
                  ->on('bands')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
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
        Schema::dropIfExists('band_tag');
    }
}
