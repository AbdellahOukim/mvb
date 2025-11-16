<?php

namespace Core;

class File
{
    public static function upload(array $file, string $uploadPath = "uploads", array $allowedExtensions = [], ?string $customName = null): array|false
    {
        $allowedExtensions = $allowedExtensions ?: ["jpg", "jpeg", "png", "gif", "pdf", "doc", "docx"];
        $uploadPath = rtrim($uploadPath, "/");

        if (!isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, $allowedExtensions)) {
            return false;
        }

        $filename = $customName ? $customName . "." . $extension : uniqid("file_", true) . "." . $extension;
        $destination = $uploadPath . "/" . $filename;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            return false;
        }

        return [
            "name" => $filename,
            "path" => $destination,
            "extension" => $extension,
            "size" => $file['size']
        ];
    }

    public static function delete(string $filename, string $uploadPath = "uploads"): bool
    {
        $filePath = rtrim($uploadPath, "/") . "/" . $filename;
        return file_exists($filePath) ? unlink($filePath) : false;
    }

    public static function exists(string $filename, string $uploadPath = "uploads"): bool
    {
        return file_exists(rtrim($uploadPath, "/") . "/" . $filename);
    }

    public static function path(string $filename, string $uploadPath = "uploads"): string
    {
        return rtrim($uploadPath, "/") . "/" . $filename;
    }
}
