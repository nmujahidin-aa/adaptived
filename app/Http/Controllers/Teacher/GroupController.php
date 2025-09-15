<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Teacher\GroupsDataTable;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use App\Helpers\HttpResponse;
use App\Models\User;
use App\Models\Member;
use App\Models\Worksheet;
use App\Enums\RoleEnum;
use Spatie\Permission\Models\Role;
use App\Http\Requests\Teacher\GroupRequest;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    protected $view;
    protected $route;
    protected $user;
    protected $worksheets;

    public function __construct()
    {
        $this->view = "pages.teacher.group.";
        $this->route = "teacher.group.";
        $this->user = \Illuminate\Support\Facades\Auth::user();
        $this->worksheets = new \App\Models\Worksheet();
    }

    public function index(GroupsDataTable $dataTable){
        $group_count = Group::count();
        $user = $this->user;
        $worksheets = $this->worksheets->where('school_id', $user->school_id)->get();
        
        return $dataTable->render($this->view . 'index', [
            'group_count' => $group_count,
            'worksheets' => $worksheets,
        ]);
    }

    public function edit(string $id = null) {
        $data = null;
        $user = $this->user;
        $worksheets = $this->worksheets->where('school_id', $user->school_id)->get();

        $students = \App\Models\User::where('school_id', $this->user->school_id)
            ->whereHas('roles', function ($q) {
                $q->where('name', RoleEnum::STUDENT);
            })
            ->get();

        if ($id) {
            $data = Group::findOrFail($id);
        }
        return view($this->view . 'edit', [
            'data' => $data,
            'worksheets' => $worksheets,
            'students' => $students,
        ]);
    }

    public function store(GroupRequest $request){
        try {
            DB::transaction(function () use ($request, &$group) {
                
                $isUpdate = $request->has('id');
                $group = $isUpdate
                    ? Group::findOrFail($request->id)
                    : new Group();

                $group->name = $request->input('name');
                $group->worksheet_id = $request->input('worksheet_id');
                $group->school_id = $request->input('school_id');
                $group->save();

                $membersToSync = [];
                
                $membersToSync[$request->leader_id] = ['role' => 'leader'];

                foreach ($request->input('member_id', []) as $memberId) {
                    if ($memberId !== $request->leader_id) {
                        $membersToSync[$memberId] = ['role' => 'member'];
                    }
                }
                
                $group->members()->sync($membersToSync);
            });

            $message = $request->has('id') ? 'Data kelompok berhasil diubah.' : 'Data kelompok berhasil ditambahkan.';

            return $request->has('id')
                ? redirect()->route('teacher.group.edit', $group->id)
                : redirect()->route('teacher.group.index');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())->withInput();
        }
    }
}
