<?php

namespace App\Http\Controllers;

use App\Models\AttachmentLegalitas;
use App\Models\AttachmentTenagaAhli;
use App\Models\LaporanPajak;
use App\Models\TenagaAhli;
use Illuminate\Http\Request;

class DownloadFileController extends Controller
{
    public function downloadLaporanPajak($uuid)
    {
        $laporanpajak = AttachmentLegalitas::where('uuid', $uuid)->firstOrFail();
        $pathToFile = storage_path('app/attachmentlegalitas/' . $laporanpajak->namefile);
        return response()->file($pathToFile);
    }
    public function downloadAttachmentTenagaAhli($uuid)
    {
        $attachment = AttachmentTenagaAhli::where('uuid', $uuid)->firstOrFail();
        $pathToFile = storage_path('app/attachment_tenagaahli/' . $attachment->namefile);
        return response()->file($pathToFile);
    }
    public function downloadCvTenagaAhli($uuid)
    {
        $cv = TenagaAhli::where('cv_uuid', $uuid)->firstOrFail();
        $pathToFile = storage_path('app/cv_tenagaahli/' . $cv->cv);
        return response()->file($pathToFile);
    }
}
