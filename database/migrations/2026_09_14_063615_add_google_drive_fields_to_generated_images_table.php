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
        Schema::table('generated_images', function (Blueprint $table) {

            $table->string('image_uid', 50)
                ->nullable()
                ->unique()
                ->after('id');

            $table->string('google_drive_file_id', 255)
                ->nullable()
                ->after('generated_photo_path');

            $table->text('google_drive_url')
                ->nullable()
                ->after('google_drive_file_id');

            $table->string('google_drive_status', 30)
                ->default('pending')
                ->after('google_drive_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('generated_images', function (Blueprint $table) {
            $table->dropUnique([
                'generated_images_image_uid_unique'
            ]);

            $table->dropColumn([
                'image_uid',
                'google_drive_file_id',
                'google_drive_url',
                'google_drive_status',
            ]);
        });
    }
};