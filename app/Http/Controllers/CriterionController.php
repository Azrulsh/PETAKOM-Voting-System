<?php

namespace App\Http\Controllers;

use App\Models\Criterion;
use App\Models\VoterRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CriterionController extends Controller
{
    public function index()
    {
        $criterias = Criterion::all();

        return view('criteria.index', compact('criterias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        Criterion::create($data);

        return redirect('/admin/viewCriteria')
            ->with('success', 'Criteria added successfully.');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $criterion = Criterion::findOrFail($id);

        $criterion->update($data);

        return redirect('/admin/viewCriteria')
            ->with('success', 'Criteria updated successfully.');
    }

    public function destroy($id)
    {
        $criterion = Criterion::findOrFail($id);

        DB::transaction(function () use ($criterion) {
            VoterRate::where('criteria_id', $criterion->id)->delete();

            $criterion->delete();
        });

        return redirect('/admin/viewCriteria')
            ->with('success', 'Criteria deleted successfully.');
    }
}
