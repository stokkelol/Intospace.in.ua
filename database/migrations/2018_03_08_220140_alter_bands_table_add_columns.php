<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class AlterBandsTableAddColumns
 */
class AlterBandsTableAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bands', function (Blueprint $table) {
            $table->string('lastfm_url', 191)->nullable()->after('slug');
            $table->string('metal_archives_url', 191)->nullable()->after('lastfm_url');
            $table->string('facebook_url', 191)->nullable()->after('metal_archives_url');
            $table->string('bandcamp_url', 191)->nullable()->after('facebook_url');
            $table->string('soundcloud_url', 191)->nullable()->after('bandcamp_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bands', function (Blueprint $table) {
            $table->dropColumn('lastfm_url');
            $table->dropColumn('metal_archives_url');
            $table->dropColumn('facebook_url');
            $table->dropColumn('bandcamp_url');
            $table->dropColumn('soundcloud_url');
        });
    }
}
