<?php

namespace Tests\Feature;

use App\Models\Certificate;
use App\Models\Instructor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;

class DownloadCertificateTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithExceptionHandling;

    /** @test */
    public function user_can_download_an_instructors_certificate()
    {
        // $this->withoutExceptionHandling();
        Storage::fake('local');
        $filename = 'certificates/tennis-qualification.pdf';
        Storage::put($filename, 'Contents');
        Storage::assertExists($filename); // check the file exists, assert the arrange step
        
        $instructor = factory(Instructor::class)->states('volunteer')->create();
        $certificate = factory(Certificate::class)->states('qualification')->create([
            'name' => 'Tennis Coach Trainer',
            'file' => $filename,
            'instructor_id' => $instructor->id,
        ]);

        $response = $this->get("/certificates/{$certificate->id}/download");

        $response->assertStatus(200);
    }
}
