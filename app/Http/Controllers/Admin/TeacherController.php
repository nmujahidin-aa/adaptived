<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Enums\RoleEnum;
use App\Helpers\HttpResponse;
use Illuminate\Http\Response;
use App\DataTables\Admin\TeachersDataTable;
use App\Http\Requests\Admin\TeacherRequest;
use App\Helpers\UploadHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    public $route;
    public $view;
    public $teacher;

    public function __construct(){
        $this->route = 'admin.teacher.';
        $this->view = 'pages.admin.teacher.';
        $this->teacher = User::role(RoleEnum::TEACHER);
    }

    public function index(TeachersDataTable $dataTable) {
        $teacher_count = $this->teacher->count();
        return $dataTable->render($this->view . 'index', [
            'teacher_count' => $teacher_count,
        ]);
    }

    public function edit(string $id = null) {
        $data = null;
        $school = \App\Models\School::all();
        if ($id) {
            $data = User::role(RoleEnum::TEACHER)->findOrFail($id);
        }
        return view($this->view . 'edit', [
            'data' => $data,
            'school' => $school
        ]);
    }

    public function store(TeacherRequest $request){
        $data = $request->has('id')
            ? User::findOrFail($request->id)
            : new User();

        $data->fill($request->validated());

        if ($request->hasFile('avatar')) {
            if (!empty($data->avatar) && Storage::exists('public/' . $data->avatar)) {
                Storage::delete('public/' . $data->avatar);
            }

            $result = UploadHelper::upload_file(
                $request->file('avatar'),
                'teacher/avatar',
                ['png','jpg','jpeg']
            );

            if (!$result['IsError']) {
                $data->avatar = $result['Path'];
            } else {
                session()->flash('alert.teacher.error', $result['Message']);
                return back()->withInput();
            }
        }

        if (!$request->has('id')) {
            $data->password = Hash::make('password');
        }

        $data->save();

        if (!$request->has('id')) {
            $data->assignRole(RoleEnum::TEACHER->value ?? RoleEnum::TEACHER);
        }
        

        session()->flash(
            'alert.teacher.success',
            $request->has('id')
                ? 'Data guru berhasil diperbarui'
                : 'Data guru berhasil ditambahkan'
        );

        return $request->has('id')
            ? redirect()->route('admin.teacher.edit', $data->id)
            : redirect()->route('admin.teacher.index');
    }

    public function destroy() {
        $ids = request()->input('ids');
        if (!$ids) {
            return HttpResponse::fail(Response::HTTP_UNPROCESSABLE_ENTITY, 'Invalid payload', [
                'ids' => ['Ids harus diisi']
            ]);
        }

        if (!is_array($ids)) {
            return HttpResponse::fail(Response::HTTP_UNPROCESSABLE_ENTITY, 'Invalid payload', [
                'ids' => ['Ids harus berupa array']
            ]);
        }

        foreach ($ids as $id) {
            $teacher = $this->teacher::find($id);
            if (!$teacher) {
                continue;
            }
            $teacher->delete();
        }
        return HttpResponse::success(Response::HTTP_OK, 'Guru berhasil dihapus');
    }

    public function single_destroy() {
        $teacher = User::role(RoleEnum::TEACHER)->findOrFail(request()->route('id'));

        if (!$teacher) {
            return HttpResponse::fail(Response::HTTP_NOT_FOUND, 'Guru tidak ditemukan atau sudah dihapus');
        }
        $teacher->delete();
        session()->flash('alert.teacher.success', 'Guru berhasil dihapus');
        return HttpResponse::success(Response::HTTP_OK, 'Guru berhasil dihapus', [
            'redirect' => route('admin.teacher.index')
        ]);
    }
}
