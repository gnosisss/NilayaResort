<?php

if (!function_exists('get_file_from_storage')) {
    /**
     * Get a file from storage by its path.
     *
     * @param string $path
     * @return \Illuminate\Http\UploadedFile|null
     */
    function get_file_from_storage($path)
    {
        if (empty($path)) {
            return null;
        }
        
        try {
            $storage = \Illuminate\Support\Facades\Storage::disk('public');
            
            if ($storage->exists($path)) {
                $file = $storage->get($path);
                $mimeType = $storage->mimeType($path);
                $size = $storage->size($path);
                $name = basename($path);
                
                // Create a temporary file
                $tempFile = tempnam(sys_get_temp_dir(), 'upload_');
                file_put_contents($tempFile, $file);
                
                // Create an UploadedFile instance
                return new \Illuminate\Http\UploadedFile(
                    $tempFile,
                    $name,
                    $mimeType,
                    $size,
                    true
                );
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error getting file from storage: ' . $e->getMessage());
        }
        
        return null;
    }
}