<?php
declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePostsMonthlyreviewsTable
 */
class CreatePostsMonthlyreviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monthly_reviews', function (Blueprint $table) {
            $table->string('latest_posts');
            $table->string('latest_videos');
            $table->string('popular_posts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monthly_reviews', function (Blueprint $table) {
            //
        });
    }
}
