<?php

namespace App\Http\Controllers;

use App\Models\ManageCriteria;
use App\Models\VoterRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageCriteriaController extends Controller
{
    // Display all criteria
    public function index()
    {
        $criterias = ManageCriteria::all();
        return view(
            'manage_criteria.view_manage_criteria',
            ['criterias' => $criterias,],
        );
    }

    // Store Criteria inside DB
    public function store(Request $request)
    {
        ManageCriteria::create($request->all());
        VoterRate::create($request->all());
        return redirect('/admin/viewCriteria');
    }

    // Update Criteria inside DB
    public function update(Request $request, $id)
    {
        $criteria = ManageCriteria::find($id);
        $voter = VoterRate::find($id);
        $criteria->update($request->all());
        $voter->update($request->all());
        return redirect('/admin/viewCriteria');
    }

    // Delete Criteria inside DB
    public function destroy($id)
    {
        // Find and delete ManageCriteria
        $criteria = ManageCriteria::find($id);

        if ($criteria) {
            $criteria->delete();

            // Find and delete associated VoterRate instances
            $voter = VoterRate::where('criteria_id', 0);
            $voterId = VoterRate::where('criteria_id', $id);

            if ($voter) {
                $voter->delete();
            }

            if ($voterId) {
                $voterId->delete();
            }

            return redirect('/admin/viewCriteria')->with('delete', 'Your Card Success been Deleted!.');
        } else {
            // Handle case where ManageCriteria with $id is not found
            return redirect('/admin/viewCriteria')->with('error', 'Card not found.');
        }
    }
}
