<?php

namespace Tests\Unit\Models;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Certificate;

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

    /** @test */
    public function checks_if_expired()
    {
        $expiredCertificate = factory(Certificate::class)->states('qualification')->make([
            'expiry_date' => Carbon::parse('-1 week')
        ]);

        $validCertificate = factory(Certificate::class)->states('qualification')->make([
            'expiry_date' => Carbon::parse('+1 week')
        ]);

        $noExpiryCertificate = factory(Certificate::class)->states('qualification')->make([
            'expiry_date' => null
        ]);

        $this->assertTrue($expiredCertificate->has_expired);
        $this->assertFalse($validCertificate->has_expired);
        $this->assertFalse($noExpiryCertificate->has_expired);
    }
}
