<?php

namespace Byte;

/**
 * File Manager
 */
class FileManager
{
    /**
     * Send Download file to user with generating special file
     *
     * @param string $fileName
     * 
     * @return bool
     * 
     */
    public static function generateDownload($fileName, $type)
    {
        $id = uniqid(uniqid($fileName));
        $oldPath = 'App/Downloads/' . $fileName . $type;
        $filePath = 'App/Downloads/' . $id . $type;
        if (copy($oldPath, $filePath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $id .  $type . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);
            unlink($filePath);
            return true;
        } else {
            return false;
        }
    }
}
