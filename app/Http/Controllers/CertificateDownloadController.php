<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CertificateDownloadController extends Controller
{
    public function __invoke(Certificate $certificate)
    {
        $headers = ['Content-Type' => Storage::mimeType($certificate->file)];

        return Storage::download($certificate->file, $certificate->download_file_name, $headers);
    }
}
