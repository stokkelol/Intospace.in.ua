<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateLabelsTable
 */
class CreateLabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mbid', 191)->nullable()->default(null);
            $table->unsignedInteger('country_id')->nullable()->default(null);
            $table->unsignedInteger('code')->nullable()->default(null);
            $table->string('disambiguation', 191)->nullable()->default(null);
            $table->timestamps();

            $table->foreign('country_id')
                  ->references('id')
                  ->on('countries')
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
        Schema::dropIfExists('labels');
    }
}
