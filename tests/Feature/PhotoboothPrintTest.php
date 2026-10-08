<?php

use App\Models\GeneratedImage;
use App\Models\PrintOrder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/*
 * theme_id is null because the photoshoot_themes table has no migration.
 * print_orders and print_cost_configs belong to the RupaVue admin site's
 * database and have no migration here either, so create them.
 */
beforeEach(function () {
    Schema::table('generated_images', function (Blueprint $table) {
        $table->unsignedBigInteger('model_id')->nullable();
    });

    Schema::create('print_cost_configs', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('ai_model_id');
        $table->string('status');
    });

    Schema::create('print_orders', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('photo_session_id');
        $table->unsignedBigInteger('generated_image_id');
        $table->unsignedBigInteger('print_config_id');
        $table->unsignedBigInteger('ai_model_id');
        $table->integer('quantity')->default(1);
        $table->decimal('unit_api_cost_bnd', 8, 4)->default(0.05);
        $table->string('print_status')->default('queued');
        $table->timestamp('created_at')->nullable();
    });
});

test('guest print request creates a print order for the admin site', function () {
    DB::table('print_cost_configs')->insert([
        ['id' => 1, 'ai_model_id' => 3, 'status' => 'Active'],
        ['id' => 2, 'ai_model_id' => 7, 'status' => 'Active'],
        ['id' => 3, 'ai_model_id' => 7, 'status' => 'Past Cost'],
    ]);

    $generatedImage = GeneratedImage::factory()->create(['theme_id' => null, 'model_id' => 7]);

    $this->postJson(route('photobooth.print.store'), ['generated_image_id' => $generatedImage->id])
        ->assertOk()
        ->assertJson(['success' => true]);

    $printOrder = PrintOrder::sole();

    expect($printOrder->generated_image_id)->toBe($generatedImage->id)
        ->and($printOrder->photo_session_id)->toBe($generatedImage->photo_session_id)
        ->and($printOrder->print_config_id)->toBe(2)
        ->and($printOrder->ai_model_id)->toBe(7)
        ->and($printOrder->quantity)->toBe(1)
        ->and($printOrder->print_status)->toBe('queued')
        ->and((float) $printOrder->unit_api_cost_bnd)->toBe(0.0);
});

test('tapping print again while the photo is queued does not add another copy', function () {
    DB::table('print_cost_configs')->insert(['id' => 1, 'ai_model_id' => 3, 'status' => 'Active']);

    $generatedImage = GeneratedImage::factory()->create(['theme_id' => null]);

    $this->postJson(route('photobooth.print.store'), ['generated_image_id' => $generatedImage->id])->assertOk();
    $this->postJson(route('photobooth.print.store'), ['generated_image_id' => $generatedImage->id])->assertOk();

    expect(PrintOrder::count())->toBe(1)
        ->and(PrintOrder::sole()->ai_model_id)->toBe(3);
});

test('guest print request fails clearly when no print price is active', function () {
    $generatedImage = GeneratedImage::factory()->create(['theme_id' => null]);

    $this->postJson(route('photobooth.print.store'), ['generated_image_id' => $generatedImage->id])
        ->assertStatus(503)
        ->assertJson(['success' => false]);

    expect(PrintOrder::count())->toBe(0);
});

test('guest print request requires an existing photo', function () {
    $this->postJson(route('photobooth.print.store'), ['generated_image_id' => 999])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('generated_image_id');
});

test('result page sends the photo to the print queue rather than opening a print window', function () {
    $html = (string) $this->view('photobooth.result', ['photoFrames' => collect()]);

    expect($html)->toContain(route('photobooth.print.store'))
        ->not->toContain('printWindow.print()')
        ->toMatch('/printError\.guestMessage =\s*failure\.message/')
        ->toMatch('/alert\(\s*error\.guestMessage \|\|/');
});

test('the old admin panel is no longer served', function () {
    $this->get('/admin/prints')->assertNotFound();
    $this->get('/admin/google-drive')->assertNotFound();
    $this->get('/google-drive/connect')->assertNotFound();
});
