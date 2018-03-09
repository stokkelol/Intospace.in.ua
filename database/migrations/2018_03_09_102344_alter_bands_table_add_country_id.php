<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class AlterBandsTableAddCountryId
 */
class AlterBandsTableAddCountryId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bands', function (Blueprint $table) {
            $table->unsignedInteger('country_id')->nullable()->default(null)->after('slug');

            $table->foreign('country_id')
                  ->references('id')
                  ->on('countries')
                  ->onDelete('set null');
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
            $table->dropForeign(['country_id']);

            $table->dropColumn('country_id');
        });
    }
}
