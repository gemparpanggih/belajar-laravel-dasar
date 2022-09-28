<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class FileControllerTest extends TestCase
{
    public function testUpload() {
        $picture = UploadedFile::fake()->image('gempar.png');
        $this->post('/file/upload', [
            "picture" => $picture
        ])->assertSeeText('OK gempar.png');
    }
}
