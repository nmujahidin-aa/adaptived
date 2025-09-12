<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Enums\RoleEnum;
use App\Helpers\HttpResponse;
use Illuminate\Http\Response;
use App\DataTables\Admin\StudentsDataTable;
use App\Http\Requests\Admin\StudentRequest;
use App\Helpers\UploadHelper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public $route;
    public $view;
    public $student;

    public function __construct(){
        $this->route = 'admin.student.';
        $this->view = 'pages.admin.student.';
        $this->student = User::role(RoleEnum::STUDENT);
    }

    public function index(StudentsDataTable $dataTable) {
        $student_count = $this->student->count();
        return $dataTable->render($this->view . 'index', [
            'student_count' => $student_count,
        ]);
    }

    public function edit(string $id = null) {
        $data = null;
        $school = \App\Models\School::all();
        if ($id) {
            $data = User::role(RoleEnum::STUDENT)->findOrFail($id);
        }
        return view($this->view . 'edit', [
            'data' => $data,
            'school' => $school
        ]);
    }

    public function store(StudentRequest $request){
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
                'student/avatar',
                ['png','jpg','jpeg']
            );

            if (!$result['IsError']) {
                $data->avatar = $result['Path'];
            } else {
                session()->flash('alert.student.error', $result['Message']);
                return back()->withInput();
            }
        }

        if (!$request->has('id')) {
            $data->password = Hash::make('password');
        }

        $data->save();

        if (!$request->has('id')) {
            $data->assignRole(RoleEnum::STUDENT->value ?? RoleEnum::STUDENT);
        }

        session()->flash(
            'alert.student.success',
            $request->has('id')
                ? 'Data siswa berhasil diperbarui'
                : 'Data siswa berhasil ditambahkan'
        );

        return $request->has('id')
            ? redirect()->route('admin.student.edit', $data->id)
            : redirect()->route('admin.student.index');
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
            $student = $this->student::find($id);
            if (!$student) {
                continue;
            }
            $student->delete();
        }
        return HttpResponse::success(Response::HTTP_OK, 'Siswa berhasil dihapus');
    }

    public function single_destroy() {
        $student = User::role(RoleEnum::STUDENT)->findOrFail(request()->route('id'));

        if (!$student) {
            return HttpResponse::fail(Response::HTTP_NOT_FOUND, 'Siswa tidak ditemukan atau sudah dihapus');
        }
        $student->delete();
        session()->flash('alert.student.success', 'Siswa berhasil dihapus');
        return HttpResponse::success(Response::HTTP_OK, 'Siswa berhasil dihapus', [
            'redirect' => route('admin.student.index')
        ]);
    }
}
