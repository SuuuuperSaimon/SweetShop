<?php


namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function removeFile($objectName, $path)
    {
        if ($objectName) {
            return @unlink( $this->getTargetDirectory() . $path . '/' . $objectName);
        }
    }

    public function upload(UploadedFile $file, $path)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->getTargetDirectory() . $path, $fileName);

        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}