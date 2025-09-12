<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\School;
use App\Enums\RoleEnum;
use App\Helpers\HttpResponse;
use Illuminate\Http\Response;
use App\DataTables\Admin\SchoolsDataTable;
use App\Http\Requests\Admin\SchoolRequest;
use App\Helpers\UploadHelper;
use Illuminate\Support\Facades\Storage;

class SchoolController extends Controller
{
    public $route;
    public $view;
    public $school;

    public function __construct(){
        $this->route = 'admin.school.';
        $this->view = 'pages.admin.school.';
        $this->school = new School();
    }

    public function index(SchoolsDataTable $dataTable) {
        $school_count = $this->school->count();
        return $dataTable->render($this->view . 'index', [
            'school_count' => $school_count,
        ]);
    }

    public function edit(string $id = null) {
        $data = null;
        if ($id) {
            $data = $this->school::findOrFail($id);
        }
        return view($this->view . 'edit', [
            'data' => $data
        ]);
    }

    public function store(SchoolRequest $request)
    {
        $data = $request->has('id')
            ? $this->school::findOrFail($request->id)
            : new $this->school();

        $data->fill($request->validated());

        if ($request->hasFile('logo')) {
            if (!empty($data->logo) && Storage::exists('public/'.$data->logo)) {
                Storage::delete('public/'.$data->logo);
            }

            $result = UploadHelper::upload_file(
                $request->file('logo'),
                'school/logo',    
                ['png','jpg','jpeg']  
            );

            if (!$result['IsError']) {
                $data->logo = $result['Path']; 
            } else {
                session()->flash('alert.school.error', $result['Message']);
                return back()->withInput();
            }
        }

        $data->save();

        session()->flash('alert.school.success', $request->has('id')? 'Data sekolah berhasil diperbarui' : 'Data sekolah berhasil ditambahkan');

        return $request->has('id')
            ? redirect()->route('admin.school.edit', $data->id)
            : redirect()->route('admin.school.index');
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
            $school = $this->school::find($id);
            if (!$school) {
                continue;
            }
            $school->delete();
        }
        return HttpResponse::success(Response::HTTP_OK, 'Sekolah berhasil dihapus');
    }

    public function single_destroy() {
        $school = $this->school::findOrFail(request()->route('id'));

        if (!$school) {
            return HttpResponse::fail(Response::HTTP_NOT_FOUND, 'Sekolah tidak ditemukan atau sudah dihapus');
        }
        $school->delete();
        session()->flash('alert.school.success', 'Sekolah berhasil dihapus');
        return HttpResponse::success(Response::HTTP_OK, 'Sekolah berhasil dihapus', [
            'redirect' => route('admin.school.index')
        ]);
    }
}
