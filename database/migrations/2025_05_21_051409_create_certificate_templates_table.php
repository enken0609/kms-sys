<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('certificate_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image_path');
            $table->string('paper_size')->default('B5');
            $table->string('orientation')->default('portrait');
            $table->json('layout_config');
            $table->timestamps();
        });

        // racesテーブルに外部キーを追加
        Schema::table('races', function (Blueprint $table) {
            $table->foreignId('certificate_template_id')
                  ->nullable()
                  ->constrained('certificate_templates')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 外部キーを削除
        Schema::table('races', function (Blueprint $table) {
            $table->dropForeign(['certificate_template_id']);
            $table->dropColumn('certificate_template_id');
        });

        Schema::dropIfExists('certificate_templates');
    }
};
