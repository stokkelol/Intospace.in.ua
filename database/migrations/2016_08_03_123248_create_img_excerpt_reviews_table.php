<?php
declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateImgExcerptReviewsTable
 */
class CreateImgExcerptReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('monthly_reviews', function (Blueprint $table) {
            $table->string('img')->after('content');
            $table->text('excerpt')->after('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('monthly_reviews', function (Blueprint $table) {
            //
        });
    }
}
