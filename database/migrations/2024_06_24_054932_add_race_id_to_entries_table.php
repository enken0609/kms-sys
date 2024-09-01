<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRaceIdToEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entries', function (Blueprint $table) {
            // race_idカラムを追加。デフォルト値は適切に設定するか、既存のデータを更新する
            $table->unsignedBigInteger('race_id')->nullable()->after('id');

            // 必要に応じて既存のレコードに対してrace_idを設定
            // DB::table('entries')->update(['race_id' => 1]);

            $table->foreign('race_id')->references('id')->on('races')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entries', function (Blueprint $table) {
            $table->dropForeign(['race_id']);
            $table->dropColumn('race_id');
        });
    }
}
