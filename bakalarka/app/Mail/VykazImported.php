<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Http\UploadedFile;


class VykazImported extends Mailable
{
    public $file;
    public $osoba;
    public $login;

    public function __construct(UploadedFile $file, $osoba, $login)
    {
        $this->file = $file;
        $this->osoba = $osoba;
        $this->login = $login;
    }

    public function build()
    {
        return $this->view('emails.vykaz-imported')
                    ->subject('Nový vykaz importovaný')
                    ->attach($this->file->getRealPath(), [
                        'as' => $this->file->getClientOriginalName(),
                        'mime' => $this->file->getMimeType(),
                    ]);
    }
}
