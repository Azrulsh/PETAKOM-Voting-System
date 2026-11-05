<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCandidateRequest;
use App\Http\Requests\UpdateCandidateRequest;
use App\Models\Candidate;
use App\Models\Criterion;
use App\Models\VoterRate;
use Illuminate\Support\Facades\Storage;

class CandidateController extends Controller
{
    // Display Candidate
    public function index()
    {
        $candidates = Candidate::all();
        $criterias = Criterion::all();
        $voterRate = VoterRate::all();

        // Decode binary images
        foreach ($candidates as $candidate) {
            if ($candidate->image) {
                $candidate->decoded_image = 'data:image/jpeg;base64,' . base64_encode($candidate->image);
            } else {
                // Provide a default image URL if no image is available
                $candidate->decoded_image = asset('https://lh3.googleusercontent.com/LfmMVU71g-HKXTCP_QWlDOemmWg4Dn1rJjxeEsZKMNaQprgunDTtEuzmcwUBgupKQVTuP0vczT9bH32ywaF7h68mF-osUSBAeM6MxyhvJhG6HKZMTYjgEv3WkWCfLB7czfODidNQPdja99HMb4qhCY1uFS8X0OQOVGeuhdHy8ln7eyr-6MnkCcy64wl6S_S6ep9j7aJIIopZ9wxk7Iqm-gFjmBtg6KJVkBD0IA6BnS-XlIVpbqL5LYi62elCrbDgiaD6Oe8uluucbYeL1i9kgr4c1b_NBSNe6zFwj7vrju4Zdbax-GPHmiuirf2h86eKdRl7A5h8PXGrCDNIYMID-J7_KuHKqaM-I7W5yI00QDpG9x5q5xOQMgCy1bbu3St1paqt9KHrvNS_SCx-QJgBTOIWW6T0DHVlvV_9YF5UZpN7aV5a79xvN1Gdrc7spvSs82v6gta8AJHCgzNSWQw5QUR8EN_-cTPF6S-vifLa2KtRdRAV7q-CQvhMrbBCaEYY73bQcPZFd9XE7HIbHXwXYA=s200-no');
            }
        }

        return view(
            'manage_candidate.view_manage_candidate',
            compact([
                'candidates',
                'criterias',
                'voterRate',
            ]),
        );
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
