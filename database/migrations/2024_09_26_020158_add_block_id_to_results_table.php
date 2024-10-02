<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('results', function (Blueprint $table) {
            $table->unsignedBigInteger('block_id')->nullable();  // block_idを追加し、nullableに
            $table->foreign('block_id')->references('id')->on('blocks')->onDelete('set null');  // 外部キー制約
        });
    }

    public function down()
    {
        Schema::table('results', function (Blueprint $table) {
            $table->dropForeign(['block_id']);
            $table->dropColumn('block_id');
        });
    }
};
