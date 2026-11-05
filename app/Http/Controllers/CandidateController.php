<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCandidateRequest;
use App\Http\Requests\UpdateCandidateRequest;
use App\Models\Candidate;
use App\Models\Criterion;
use Illuminate\Support\Facades\Storage;

class CandidateController extends Controller
{
    // Display Candidate
    public function index()
{
    $candidates = Candidate::all();
    $criterias = Criterion::all();

    return view('candidate.index', compact('candidates','criterias'));
}
    
    public function store(StoreCandidateRequest $request)
    {
        $data = $request->validated();

        $data['criteria_rate'] = $data['ratings'];
        unset($data['ratings']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('candidates', 'public');
        }

        try {
            Candidate::create($data);
        } catch (\Throwable $e) {
            if (!empty($data['image'])) {
                Storage::disk('public')->delete($data['image']);
            }

            throw $e;
        }

        return redirect('/admin/viewCandidate')
            ->with('success', 'Candidate added successfully.');
    }

    public function update(UpdateCandidateRequest $request, $id)
    {
        $candidate = Candidate::findOrFail($id);

        $data = $request->validated();

        $data['criteria_rate'] = $data['ratings'];
        unset($data['ratings']);
        
        $oldImage = $candidate->image;
        $newImage = null;

        if ($request->hasFile('image')) {
            $newImage = $request->file('image')
                ->store('candidates', 'public');

            $data['image'] = $newImage;
        }

        try {
            $candidate->update($data);
        } catch (\Throwable $e) {
            if ($newImage) {
                Storage::disk('public')->delete($newImage);
            }

            throw $e;
        }

        if ($newImage && $oldImage && $oldImage !== $newImage) {
            Storage::disk('public')->delete($oldImage);
        }

        return redirect('/admin/viewCandidate')
            ->with('success', 'Candidate updated successfully.');
    }


    // Delete Criteria inside DB
    public function destroy($id)
    {
        $criteria = Candidate::find($id);
        $criteria->delete($criteria);
        return redirect('/admin/viewCandidate')->with('delete', 'Your Card Success been Deleted!.');
    }
}
