<?php

namespace App\Repositories;

use App\Models\Candidate;
use Illuminate\Support\Str;

class CandidateRepository
{
    public function all()
    {
        return Candidate::all();
    }

    public function find($id)
    {
        return Candidate::findOrFail($id);
    }

    public function create(array $data)
    {
        return Candidate::create($data);
    }

    public function update($id, array $data)
    {
        $candidate = $this->find($id);
        $candidate->update($data);
        return $candidate;
    }

    public function delete($id)
    {
        $candidate = Candidate::find($id);
        $candidate->cres()->delete();
        $files = $candidate->files;
        foreach ($files as $file) {
            $file->delete();
        }

        return Candidate::destroy($id);
    }
}
