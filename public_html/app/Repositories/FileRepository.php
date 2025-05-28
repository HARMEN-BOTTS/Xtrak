<?php

namespace App\Repositories;

use App\Models\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileRepository
{
    public function upload($file, $dir)
    {
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();

        $file->storeAs($dir, $fileName, 'public');

        return $dir . '/' . $fileName;
    }
    public function create(array $files, $owner_id, $file_type = 'other')
    {
        foreach ($files as $file) {
            $_file['path'] = $this->upload($file, 'files');
            $_file['type'] = $file->getClientOriginalExtension();
            $_file['size'] = $file->getSize();
            $_file['name'] = $file->getClientOriginalName();
            $_file['owner_id'] = $owner_id;
            $_file['created_by'] = Auth::user()->id;
            $_file['file_type'] = $file_type;
            if ($_file['path']) {
                File::create($_file);
            }
        }
    }
    public function createOne($file, $owner_id, $file_type = 'other')
    {
        $_file['path'] = $this->upload($file, 'files');
        $_file['type'] = $file->getClientOriginalExtension();
        $_file['size'] = $file->getSize();
        $_file['name'] = $file->getClientOriginalName();
        $_file['owner_id'] = $owner_id;
        $_file['created_by'] = Auth::user()->id;
        $_file['file_type'] = $file_type;
        if ($_file['path']) {
            return File::create($_file);
        }
    }
    public function delete($id)
    {
        $file = File::findOrFail($id);
        Storage::disk('public')->delete($file->path);
        return $file->delete();
    }
    public function find($id)
    {
        return File::findOrFail($id);
    }
    public function update(File $file, array $data)
    {
        $file->update($data);
        return $file;
    }
}
