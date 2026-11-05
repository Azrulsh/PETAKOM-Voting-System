<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Criterion;
use App\Models\Rating;
use App\Models\StudentWarefare;
use App\Models\WelfareExco;
use App\Models\SportsExco;
use App\Models\Secretary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RatingController extends Controller
{
    private const POSITIONS = [
        'student-warefare' => [
            'name' => 'Student Affair',
            'model' => StudentWarefare::class,
        ],
        'welfare-exco' => [
            'name' => 'Welfare Exco',
            'model' => WelfareExco::class,
        ],
        'sports-exco' => [
            'name' => 'Sports Exco',
            'model' => SportsExco::class,
        ],
        'secretary' => [
            'name' => 'Secretary',
            'model' => Secretary::class,
        ],
    ];

    public function positions()
    {
        return view('rating.positions', [
            'criteria' => Criterion::all(),
        ]);
    }

    public function index(string $position)
    {
        $config = $this->getPosition($position);

        $criterias = Criterion::all();

        $candidates = Candidate::where('position', $config['name'])->get();

        $voterRate = Rating::where('voter_name', auth()->user()->name)->get();

        return view('rating.index', compact(
            'criterias',
            'candidates',
            'voterRate',
            'position'
        ));
    }

    public function store(Request $request, string $position)
    {
        $config = $this->getPosition($position);

        abort_unless(
            $request->user()?->type === 'voter',
            403
        );

        $criteriaIds = Criterion::pluck('id')
            ->map(fn ($id) => (int) $id)
            ->all();

        if (empty($criteriaIds)) {
            throw ValidationException::withMessages([
                'rate' => 'No rating criteria are available.',
            ]);
        }

        $rules = [
            'rate' => ['required', 'array'],
            'candidate_name' => ['required', 'array'],
        ];

        foreach ($criteriaIds as $id) {
            $rules["rate.$id"] = [
                'required', 'integer', 'between:1,5',
            ];

            $rules["candidate_name.$id"] = [
                'required', 'string',
            ];
        }

        $data = $request->validate($rules);

        $submittedIds = array_map(
            'intval',
            array_keys($data['rate'])
        );

        sort($submittedIds);
        $expectedIds = $criteriaIds;
        sort($expectedIds);

        if ($submittedIds !== $expectedIds) {
            throw ValidationException::withMessages([
                'rate' => 'Invalid rating criteria submitted.',
            ]);
        }

        $candidateNames = array_unique(
            array_values($data['candidate_name'])
        );

        if (count($candidateNames) !== 1) {
            throw ValidationException::withMessages([
                'candidate_name' => 'Invalid candidate selection.',
            ]);
        }

        $candidateName = reset($candidateNames);

        $candidate = Candidate::where('full_name', $candidateName)
            ->where('position', $config['name'])
            ->first();

        abort_unless($candidate, 403);

        $voterName = $request->user()->name;

        DB::transaction(function () use (
            $candidate,
            $candidateName,
            $voterName,
            $criteriaIds,
            $data,
            $config
        ) {
            Candidate::whereKey($candidate->id)
                ->lockForUpdate()
                ->firstOrFail();

            $alreadyRated = Rating::where(
                'candidate_name',
                $candidateName
            )->where('voter_name', $voterName)
                ->exists();

            if ($alreadyRated) {
                throw ValidationException::withMessages([
                    'rate' => 'You have already rated this candidate.',
                ]);
            }

            foreach ($criteriaIds as $id) {
                $criterion = Criterion::findOrFail($id);

                Rating::create([
                    'criteria_id' => $id,
                    'name' => $criterion->name,
                    'candidate_name' => $candidateName,
                    'voter_name' => $voterName,
                    'rate' => $data['rate'][$id],
                ]);
            }

            foreach ($criteriaIds as $id) {
                $criterion = Criterion::findOrFail($id);

                $average = Rating::where('criteria_id', $id)
                    ->where('candidate_name', $candidateName)
                    ->whereNotNull('voter_name')
                    ->where('voter_name', '!=', '')
                    ->avg('rate');

                $config['model']::updateOrCreate(
                    [
                        'criteria_id' => $id,
                        'candidate_name' => $candidateName,
                    ],
                    [
                        'name' => $criterion->name,
                        'rate' => $average ?? 0,
                    ]
                );
            }
        });

        return redirect(
            '/voter/rateCandidate/' . $position
        )->with('success', 'Rating submitted successfully.');
    }

    private function getPosition(string $position): array
    {
        abort_unless(
            array_key_exists($position, self::POSITIONS),
            404
        );

        return self::POSITIONS[$position];
    }
}
