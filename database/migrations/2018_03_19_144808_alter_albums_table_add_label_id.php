<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class AlterAlbumsTableAddLabelId
 */
class AlterAlbumsTableAddLabelId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('albums', function (Blueprint $table) {
            $table->unsignedInteger('label_id')->nullable()->default(null);
            $table->string('catalog_number')->nullable();

            $table->foreign('label_id')
                  ->references('id')
                  ->on('labels')
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
        Schema::table('albums', function (Blueprint $table) {
            $table->dropForeign(['label_id']);

            $table->dropColumn('label_id');
            $table->dropColumn('catalog_number');
        });
    }
}
