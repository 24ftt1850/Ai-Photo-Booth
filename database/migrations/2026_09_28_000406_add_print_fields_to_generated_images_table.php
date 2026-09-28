<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('generated_images', function (Blueprint $table) {
            $table->string('print_status', 20)
                ->nullable()
                ->index();

            $table->timestamp('print_requested_at')->nullable();

            $table->timestamp('printed_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('generated_images', function (Blueprint $table) {
            $table->dropIndex(['print_status']);
            $table->dropColumn([
                'print_status',
                'print_requested_at',
                'printed_at',
            ]);
        });
    }
};
