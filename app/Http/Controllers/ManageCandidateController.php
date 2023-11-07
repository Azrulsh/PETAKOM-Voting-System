<?php

namespace App\Http\Controllers;

use App\Models\ManageCandidate;
use Illuminate\Http\Request;

class ManageCandidateController extends Controller
{
    // Display Candidate
    public function index()
    {
        $candidates = ManageCandidate::all();
        return view(
            'manage_candidate.view_manage_candidate',
            ['candidates' => $candidates],
        );
    }

    // Store Candidate inside DB
    public function store(Request $request)
    {
        ManageCandidate::create($request->all());
        return redirect('/viewCandidate');
    }

    // Update Candidate inside DB
    public function update(Request $request, $id)
    {
        $criteria = ManageCandidate::find($id);
        $criteria->update($request->all());
        return redirect('/viewCandidate');
    }

    // Delete Criteria inside DB
    public function destroy($id)
    {
        $criteria = ManageCandidate::find($id);
        $criteria->delete($criteria);
        return redirect('/viewCandidate')->with('delete', 'Your Card Success been Deleted!.');
    }
}
