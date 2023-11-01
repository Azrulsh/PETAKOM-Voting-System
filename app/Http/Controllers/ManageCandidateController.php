<?php

namespace App\Http\Controllers;

use App\Models\ManageCandidate;
use App\Models\ManageCriteria;
use Illuminate\Http\Request;

class ManageCandidateController extends Controller
{
    // Display all Candidates
    public function index()
    {
        $candidates = ManageCandidate::all();
        $criterias = ManageCriteria::all();
        return view(
            'home',
            compact(
                [
                    'candidates',
                    'criterias',
                ],
            ),
        );
    }

    // Store Candidate inside DB
    public function store(Request $request)
    {
        ManageCandidate::create($request->all());
        return redirect('/');
    }

    // Update Candidate inside DB
    public function update(Request $request, $id)
    {
        $criteria = ManageCandidate::find($id);
        $criteria->update($request->all());
        return redirect('/');
    }

    // Delete Criteria inside DB
    public function destroy($id)
    {
        $criteria = ManageCandidate::find($id);
        $criteria->delete($criteria);
        return redirect('/')->with('delete', 'Your Card Success been Deleted!.');
    }
}
