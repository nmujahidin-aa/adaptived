<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Enums\RoleEnum;
use App\Models\Answer;
use App\Models\Assesment;
use App\Models\Worksheet;
use App\Models\Group;
use App\Models\GroupAnswer;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private $view;
    private $route;
    private $user;

    public function __construct(){
        $this->view = "pages.dashboard.";
        $this->route = "dashboard";
        $this->user = new User();
    }
    
    public function index()
    {
        $user = Auth::user();

        $data = [
            'schools' => 0,
            'students' => 0,
            'teachers' => 0,
            'school_names' => [],
            'students_per_school' => [],
            'teachers_per_school' => [],

            'lkpd' => 0,
            'groups' => 0,
            'assesments' => 0,

            'pending_assesments' => 0,
            'total_assesments' => 0,
            'assesment_progress' => 0,
            'pending_lkpd' => 0,
            'total_lkpd' => 0,
            'lkpd_progress' => 0,
        ];

        if ($user->hasRole(RoleEnum::ADMINISTRATOR)) {

            $schools = User::whereNotNull('school_id')
                ->distinct('school_id')
                ->count('school_id');

            $students = User::role(RoleEnum::STUDENT)->count();
            $teachers = User::role(RoleEnum::TEACHER)->count();

            $studentPerSchool = User::role(RoleEnum::STUDENT)
                ->selectRaw('school_id, COUNT(*) as total')
                ->groupBy('school_id')
                ->with('school:id,name')
                ->get();

            $teacherPerSchool = User::role(RoleEnum::TEACHER)
                ->selectRaw('school_id, COUNT(*) as total')
                ->groupBy('school_id')
                ->with('school:id,name')
                ->get();

            $data['schools'] = $schools;
            $data['students'] = $students;
            $data['teachers'] = $teachers;

            $data['school_names'] = $studentPerSchool->pluck('school.name');
            $data['students_per_school'] = $studentPerSchool->pluck('total');
            $data['teachers_per_school'] = $teacherPerSchool->pluck('total');
        }

        if ($user->hasRole(RoleEnum::TEACHER)) {

            $schoolId = $user->school_id;
            $teacherId = $user->id;

            $totalStudents = User::role(RoleEnum::STUDENT)
                ->where('school_id', $schoolId)
                ->count();

            $totalLKPD = Worksheet::where('teacher_id', $teacherId)->count();

            $totalGroups = Group::where('school_id', $schoolId)->count();

            $totalAssesments = Assesment::where('teacher_id', $teacherId)->count();

            $maleStudents = User::role(RoleEnum::STUDENT)
                ->where('school_id', $schoolId)
                ->where('gender', 'L')
                ->count();

            $femaleStudents = User::role(RoleEnum::STUDENT)
                ->where('school_id', $schoolId)
                ->where('gender', 'P')
                ->count();

            $lkpdDone = GroupAnswer::whereHas('worksheet', function ($q) use ($teacherId) {
                    $q->where('teacher_id', $teacherId);
                })
                ->distinct('worksheet_id')
                ->count('worksheet_id');

            $assesmentDone = Answer::whereHas('assesment', function ($q) use ($teacherId, $schoolId) {
            $q->where('teacher_id', $teacherId)
                ->where('school_id', $schoolId);
            })
            ->select('assesment_id')
            ->distinct()
            ->count();

            $analyzedAssesments = Answer::whereHas('assesment', function ($q) use ($teacherId, $schoolId) {
                $q->where('teacher_id', $teacherId)
                ->where('school_id', $schoolId);
            })
            ->whereNotNull('analysis')
            ->select('assesment_id')
            ->distinct()
            ->count();

            $data = [
                'students' => $totalStudents,
                'lkpd' => $totalLKPD,
                'groups' => $totalGroups,
                'assesments' => $totalAssesments,

                'male_students' => $maleStudents,
                'female_students' => $femaleStudents,

                'lkpd_done' => $lkpdDone,
                'lkpd_total' => $totalLKPD,
                'assesment_done' => $assesmentDone,
                'assesment_total' => $totalAssesments,

                'created_assesments' => $totalAssesments,
                'analyzed_assesments' => $analyzedAssesments,
            ];
        }

        if ($user->hasRole(RoleEnum::STUDENT)) {

            $totalAssesments = Assesment::where('school_id', $user->school_id)->count();

            $doneAssesments = Answer::where('user_id', $user->id)
                ->distinct('assesment_id')
                ->count('assesment_id');

            $pendingAssesments = max($totalAssesments - $doneAssesments, 0);

            $data['total_assesments'] = $totalAssesments;
            $data['pending_assesments'] = $pendingAssesments;
            $data['assesment_progress'] = $totalAssesments > 0
                ? round(($doneAssesments / $totalAssesments) * 100)
                : 0;

            $data['total_lkpd'] = $totalAssesments;
            $data['pending_lkpd'] = $pendingAssesments;
            $data['lkpd_progress'] = $data['assesment_progress'];
        }

        return view('pages.dashboard.index', compact('user', 'data'));
    }
}
