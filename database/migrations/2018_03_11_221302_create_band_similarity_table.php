<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateBandSimilarityTable
 */
class CreateBandSimilarityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('band_similarity', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('band_id');
            $table->unsignedInteger('related_id');

            $table->foreign('band_id')
                  ->references('id')
                  ->on('bands')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('related_id')
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
        Schema::dropIfExists('band_similarity');
    }
}
