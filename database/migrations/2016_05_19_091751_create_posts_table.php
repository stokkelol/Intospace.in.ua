<?php
declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePostsTable
 */
class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('title');
            $table->text('excerpt');
            $table->longText('content');
            $table->text('links');
            $table->string('video');
            $table->text('similar');
            $table->string('img', 255);
            $table->string('img_thumbnail', 255);
            $table->string('logo', 255);
            $table->string('slug', 512);
            $table->boolean('is_pinned')->default(0);
            $table->boolean('views')->default(0)->unsigned();
            $table->enum('status', ['active', 'moderation', 'deleted', 'refused', 'draft'])->default('draft');
            $table->dateTime('published_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('posts');
    }
}
