<?php

namespace App\Http\Controllers;

use App\Models\ManageCandidate;
use App\Models\ManageCriteria;
use Illuminate\Http\Request;

class ManageCandidateController extends Controller
{
    // Display Candidate
    public function index()
    {
        $candidates = ManageCandidate::all();
        $criterias = ManageCriteria::all();
        return view(
            'manage_candidate.view_manage_candidate',
            compact([
                'candidates',
                'criterias',
            ]),
        );
    }

    // Store Candidate inside DB
    public function store(Request $request)
    {
        ManageCandidate::create($request->all());
        ManageCriteria::find($request['criteriaId'])->update($request->all());
        return redirect('/admin/viewCandidate');
    }

    // Update Candidate inside DB
    public function update(Request $request, $id)
    {
        $criteria = ManageCandidate::find($id);
        $criteria->update($request->all());
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
