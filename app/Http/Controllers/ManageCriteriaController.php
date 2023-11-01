<?php

namespace App\Http\Controllers;

use App\Models\ManageCandidate;
use App\Models\ManageCriteria;
use Illuminate\Http\Request;

class ManageCriteriaController extends Controller
{
    // Display all criteria
    public function index()
    {
        $criterias = ManageCriteria::all();
        return view(
            'home',
            compact(
                ['criterias'],
            ),
        );
    }

    // Store Criteria inside DB
    public function store(Request $request)
    {
        ManageCriteria::create($request->all());
        return redirect('/');
    }

    // Update Criteria inside DB
    public function update(Request $request, $id)
    {
        $criteria = ManageCriteria::find($id);
        $criteria->update($request->all());
        return redirect('/');
    }

    // Delete Criteria inside DB
    public function destroy($id)
    {
        $criteria = ManageCriteria::find($id);
        $criteria->delete($criteria);
        return redirect('/')->with('delete', 'Your Card Success been Deleted!.');
    }
}
