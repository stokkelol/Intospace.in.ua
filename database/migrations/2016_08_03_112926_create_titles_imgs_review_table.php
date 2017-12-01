<?php
declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTitlesImgsReviewTable
 */
class CreateTitlesImgsReviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monthly_reviews', function (Blueprint $table) {
            $table->text('titles')->after('title');
            $table->text('imgs')->after('content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monthlyreviews', function (Blueprint $table) {
            //
        });
    }
}
