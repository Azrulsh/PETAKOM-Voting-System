<?php

namespace App\Http\Controllers;

use App\Models\ManageCriteria;
use App\Models\Secretary;
use App\Models\SportsExco;
use App\Models\StudentWarefare;
use App\Models\VoterRate;
use App\Models\WelfareExco;
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
        StudentWarefare::create($request->all());
        WelfareExco::create($request->all());
        SportsExco::create($request->all());
        Secretary::create($request->all());
        return redirect('/admin/viewCriteria');
    }

    // Update Criteria inside DB
    public function update(Request $request, $id)
    {
        // Find and delete ManageCriteria
        $criteria = ManageCriteria::find($id);

        if ($criteria) {
            $criteria->update($request->all());

            // Find and delete associated VoterRate Database instances
            $voter = VoterRate::where('criteria_id', 0);
            $voterId = VoterRate::where('criteria_id', $id);

            // Find and delete associated Student Affair Database instances
            $studentWarefare = StudentWarefare::where('criteria_id', 0);
            $studentWarefareId = StudentWarefare::where('criteria_id', $id);

            // Find and delete associated Welfare Exco Database instances
            $welfareExco = WelfareExco::where('criteria_id', 0);
            $welfareExcoId = WelfareExco::where('criteria_id', $id);

            // Find and delete associated Sports Exco Database instances
            $sportsExco = SportsExco::where('criteria_id', 0);
            $sportsExcoId = SportsExco::where('criteria_id', $id);

            // Find and delete associated Secretary Database instances
            $secretary = Secretary::where('criteria_id', 0);
            $secretaryId = Secretary::where('criteria_id', $id);

            if ($voter && $studentWarefare && $welfareExco && $sportsExco && $secretary) {
                $voter->update([
                    'criteria_id' => $id,
                    'name' => $request->input('name'),
                ]);
                $studentWarefare->update([
                    'criteria_id' => $id,
                    'name' => $request->input('name'),
                ]);;
                $welfareExco->update([
                    'criteria_id' => $id,
                    'name' => $request->input('name'),
                ]);;
                $sportsExco->update([
                    'criteria_id' => $id,
                    'name' => $request->input('name'),
                ]);;
                $secretary->update([
                    'criteria_id' => $id,
                    'name' => $request->input('name'),
                ]);;
            }

            if ($voterId && $studentWarefareId && $welfareExcoId && $sportsExcoId && $secretaryId) {
                $voterId->update([
                    'criteria_id' => $id,
                    'name' => $request->input('name'),
                ]);;
                $studentWarefareId->update([
                    'criteria_id' => $id,
                    'name' => $request->input('name'),
                ]);;
                $welfareExcoId->update([
                    'criteria_id' => $id,
                    'name' => $request->input('name'),
                ]);;
                $sportsExcoId->update([
                    'criteria_id' => $id,
                    'name' => $request->input('name'),
                ]);;
                $secretaryId->update([
                    'criteria_id' => $id,
                    'name' => $request->input('name'),
                ]);
            }

            return redirect('/admin/viewCriteria');
        } else {
            // Handle case where ManageCriteria with $id is not found
            return redirect('/admin/viewCriteria');
        }
    }

    // Delete Criteria inside DB
    public function destroy($id)
    {
        // Find and delete ManageCriteria
        $criteria = ManageCriteria::find($id);

        if ($criteria) {
            $criteria->delete();

            // Find and delete associated VoterRate Database instances
            $voter = VoterRate::where('criteria_id', 0);
            $voterId = VoterRate::where('criteria_id', $id);

            // Find and delete associated Student Affair Database instances
            $studentWarefare = StudentWarefare::where('criteria_id', 0);
            $studentWarefareId = StudentWarefare::where('criteria_id', $id);

            // Find and delete associated Welfare Exco Database instances
            $welfareExco = WelfareExco::where('criteria_id', 0);
            $welfareExcoId = WelfareExco::where('criteria_id', $id);

            // Find and delete associated Sports Exco Database instances
            $sportsExco = SportsExco::where('criteria_id', 0);
            $sportsExcoId = SportsExco::where('criteria_id', $id);

            // Find and delete associated Secretary Database instances
            $secretary = Secretary::where('criteria_id', 0);
            $secretaryId = Secretary::where('criteria_id', $id);

            if ($voter && $studentWarefare && $welfareExco && $sportsExco && $secretary) {
                $voter->delete();
                $studentWarefare->delete();
                $welfareExco->delete();
                $sportsExco->delete();
                $secretary->delete();
            }

            if ($voterId && $studentWarefareId && $welfareExcoId && $sportsExcoId && $secretaryId) {
                $voterId->delete();
                $studentWarefareId->delete();
                $welfareExcoId->delete();
                $sportsExcoId->delete();
                $secretaryId->delete();
            }

            return redirect('/admin/viewCriteria')->with('delete', 'Your Card Success been Deleted!.');
        } else {
            // Handle case where ManageCriteria with $id is not found
            return redirect('/admin/viewCriteria')->with('error', 'Card not found.');
        }
    }
}
