<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

class UploadCertificateTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function user_can_view_the_upload_certificate_form()
    {
        $instructor = factory(Instructor::class)->states('volunteer')->create();

        $response = $this->get("instructors/{$instructor->id}");

        $response->assertStatus(200)
            ->assertSee('Upload Certificate');
    }

    /** @test */
    public function user_can_upload_certificate_for_instructor()
    {
        Storage::fake('local');

        $instructor = factory(Instructor::class)->states('volunteer')->create();

        $file = UploadedFile::fake()->create('document.pdf', 8);
        $expiryDate = Carbon::parse('+1 month');

        $response = $this->post("instructors/{$instructor->id}/certificates", [
            'name' => 'Football Coach Certificate',
            'description' => 'Certificate of excellence in football training',
            'type' => 'qualification',
            'expiry_date' => $expiryDate->format('d-m-Y'),
            'file' => $file,
        ]);

        $certificate = Certificate::first();

        $this->assertEquals('Football Coach Certificate', $certificate->name);
        $this->assertEquals('Certificate of excellence in football training', $certificate->description);
        $this->assertEquals('qualification', $certificate->type);
        $this->assertEquals($expiryDate->format('Y-m-d'), $certificate->expiry_date);

        Storage::disk('local')->assertExists("certificates/{$file->hashName()}");

    }
}
