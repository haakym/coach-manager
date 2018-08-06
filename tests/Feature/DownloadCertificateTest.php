<?php

namespace Tests\Feature;

use Mockery;
use Tests\TestCase;
use App\Models\Instructor;
use App\Models\Certificate;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;

class DownloadCertificateTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithExceptionHandling;

    public function setUp(){
        parent::setUp();
        Storage::fake('local');
        Storage::disk('local')->put(
            'certificates/tennis-qualification.pdf',
            file_get_contents(base_path('tests/__fixtures__/tennis-coach-qualification.pdf'))
        );
    }
    
    public function tearDown(){
        Storage::delete('certificates/tennis-qualification.pdf');
        parent::tearDown();
        Mockery::close();
    }

    /** @test */
    public function user_can_download_an_instructors_certificate()
    {
        $instructor = factory(Instructor::class)->states('volunteer')->create();
        $certificate = factory(Certificate::class)->states('qualification')->create([
            'name' => 'Tennis Coach Trainer',
            'file' => 'certificates/tennis-qualification.pdf',
            'instructor_id' => $instructor->id,
        ]);

        $response = $this->get("/certificates/{$certificate->id}/download");

        $response->assertStatus(200)
            ->assertHeader('Content-Type', 'application/pdf');
    }
}
