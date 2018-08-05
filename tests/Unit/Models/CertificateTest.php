<?php

namespace Tests\Unit\Models;

use App\Models\Certificate;
use Tests\TestCase;

class CertificateTest extends TestCase
{
    /** @test */
    public function file_download_name_is_sanitised()
    {
        $certificate = factory(Certificate::class)->states('qualification')->make([
            'name' => 'Lé áwésómé *file/*'
        ]);

        $this->assertEquals('lwsmfile.pdf', $certificate->download_file_name);
    }
}
