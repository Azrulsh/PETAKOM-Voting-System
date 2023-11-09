<?php

namespace App\Http\Controllers;

use App\Models\ManageCriteria;
use Illuminate\Http\Request;

class ManageCriteriaController extends Controller
{
    // Display all criteria
    public function index()
    {
        $criteria = ManageCriteria::all();
        return view(
            'manage_criteria.view_manage_criteria',
            ['criteria' => $criteria,],
        );
    }

    // Store Criteria inside DB
    public function store(Request $request)
    {
        ManageCriteria::create($request->all());
        return redirect('/admin/viewCriteria');
    }

    // Update Criteria inside DB
    public function update(Request $request, $id)
    {
        $criteria = ManageCriteria::find($id);
        $criteria->update($request->all());
        return redirect('/admin/viewCriteria');
    }

    // Delete Criteria inside DB
    public function destroy($id)
    {
        $criteria = ManageCriteria::find($id);
        $criteria->delete($criteria);
        return redirect('/admin/viewCriteria')->with('delete', 'Your Card Success been Deleted!.');
    }
}
