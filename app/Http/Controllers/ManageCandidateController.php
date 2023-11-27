<?php

namespace App\Http\Controllers;

use App\Models\ManageCandidate;
use App\Models\ManageCriteria;
use App\Models\VoterRate;
use Illuminate\Http\Request;

class ManageCandidateController extends Controller
{
    // Display Candidate
    public function index()
    {
        $candidates = ManageCandidate::all();
        $criterias = ManageCriteria::all();
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

    // Store Candidate inside DB
    public function store(Request $request)
    {
        // Handle image upload
        if ($request->hasFile('image')) {
            $imageContent = file_get_contents($request->file('image')->getRealPath());
            $request['image'] = $imageContent;
        }
        ManageCandidate::create($request->all());
        ManageCriteria::find($request['criteriaId'])->update($request->all());
        return redirect('/admin/viewCandidate');
    }

    // Update Candidate inside DB
    public function update(Request $request, $id)
    {
        $candidate = ManageCandidate::find($id);
        // Check if the user provided a new image
        if ($request->hasFile('image')) {
            $imageContent = file_get_contents($request->file('image')->getRealPath());
            $request['image'] = $imageContent;
        } else {
            // If no new image provided, keep the existing image
            $request['image'] = $candidate->image;
        }
        $candidate->update($request->all());
        return redirect('/admin/viewCandidate');
    }

    // Delete Criteria inside DB
    public function destroy($id)
    {
        $criteria = ManageCandidate::find($id);
        $criteria->delete($criteria);
        return redirect('/admin/viewCandidate')->with('delete', 'Your Card Success been Deleted!.');
    }
}
