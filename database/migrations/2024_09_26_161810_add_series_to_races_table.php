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
        Schema::table('races', function (Blueprint $table) {
            $table->string('series')->nullable(); // 'series' カラムを追加し、nullableにする
        });
    }

    public function down()
    {
        Schema::table('races', function (Blueprint $table) {
            $table->dropColumn('series'); // ロールバック時に 'series' カラムを削除
        });
    }

};
