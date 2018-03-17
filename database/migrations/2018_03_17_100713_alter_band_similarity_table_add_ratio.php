<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class AlterBandSimilarityTableAddRatio
 */
class AlterBandSimilarityTableAddRatio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('band_similarity', function (Blueprint $table) {
            $table->float('ratio', 8, 6)->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('band_similarity', function (Blueprint $table) {
            $table->dropColumn('ratio');
        });
    }
}
