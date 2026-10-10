<?php

namespace Tests\Feature;

use App\Filament\Pages\HelperTextDemo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class HelperTextTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create());
    }

    public function test_text_input_is_described_by_its_helper_text_and_error(): void
    {
        $html = Livewire::test(HelperTextDemo::class)->call('save')->html();

        $this->assertStringContainsString('aria-describedby="form.name-helper-text form.name-error"', $html);
        $this->assertMatchesRegularExpression('/<input[^>]*aria-invalid="true"[^>]*id="form\.name"/', $html);
    }

    public function test_toggle_is_described_by_its_helper_text(): void
    {
        $html = Livewire::test(HelperTextDemo::class)->html();

        $this->assertStringContainsString('id="form.terms-helper-text"', $html);
        $this->assertStringContainsString('aria-describedby="form.terms-helper-text"', $html);
    }

    public function test_toggle_is_described_by_its_error_and_marked_invalid(): void
    {
        $html = Livewire::test(HelperTextDemo::class)->call('save')->html();

        $this->assertStringContainsString('aria-describedby="form.terms-helper-text form.terms-error"', $html);
        $this->assertMatchesRegularExpression('/<button[^>]*role="switch"[^>]*aria-invalid="true"|<button[^>]*aria-invalid="true"[^>]*role="switch"/s', $html);
    }
}
