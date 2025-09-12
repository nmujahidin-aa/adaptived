<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LearningResource;
use App\DataTables\Teacher\LearningResourcesDataTable;
use App\Http\Requests\Teacher\LearningResourceRequest;
use App\Helpers\HttpResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Http\Response;
use App\Helpers\UploadHelper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class LearningResourceController extends Controller
{
    public $route;
    public $view;
    public $learning_resource;

    public function __construct(){
        $this->route = 'teacher.learning-resource.';
        $this->view = 'pages.teacher.learning-resource.';
        $this->learning_resource = new LearningResource();
    }

    public function index(LearningResourcesDataTable $dataTable) {
        $user = Auth::user();
        $learning_resources = $this->learning_resource::where('school_id', $user->school_id);
        $learning_resource_count = $learning_resources->count();
        return $dataTable->render($this->view . 'index', [
            'learning_resource_count' => $learning_resource_count,
        ]);
    }

    public function edit(string $id = null) {
        $data = null;
        if ($id) {
            $data = $this->learning_resource::findOrFail($id);
        }
        return view($this->view . 'edit', [
            'data' => $data,
        ]);
    }

    public function store(LearningResourceRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->has('id')
                ? LearningResource::findOrFail($request->id)
                : new LearningResource();

            
            $data->fill($request->validated());

            if ($request->hasFile('cover')) {
                if (!empty($data->cover) && Storage::exists('public/' . $data->cover)) {
                    Storage::delete('public/' . $data->cover);
                }

                $result = UploadHelper::upload_file(
                    $request->file('cover'),
                    'learning_resource/cover',
                    ['png','jpg','jpeg']
                );

                if (!$result['IsError']) {
                    $data->cover = $result['Path'];
                } else {
                    session()->flash('alert.learning_resource.error', $result['Message']);
                    return back()->withInput();
                }
            }
            $content = $request->input('learningresource-trixFields.content');

            $data->content = $content;

            $data->save();

            DB::commit();

            session()->flash(
                'alert.learning_resource.success',
                $request->has('id')
                    ? 'Data sumber belajar berhasil diperbarui'
                    : 'Data sumber belajar berhasil ditambahkan'
            );

            return $request->has('id')
                ? redirect()->route('teacher.learning-resource.edit', $data->id)
                : redirect()->route('teacher.learning-resource.index');

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            session()->flash('alert.learning_resource.error', 'Terjadi kesalahan: ' . $e->getMessage());
            return back()->withInput();
        }
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
            $learning_resource = $this->learning_resource->find($id);
            if (!$learning_resource) {
                continue;
            }
            $learning_resource->delete();
        }
        return HttpResponse::success(Response::HTTP_OK, 'Sumber belajar berhasil dihapus');
    }

    public function single_destroy() {
        $learning_resource = $this->learning_resource->findOrFail(request()->route('id'));

        if (!$learning_resource) {
            return HttpResponse::fail(Response::HTTP_NOT_FOUND, 'Sumber belajar tidak ditemukan atau sudah dihapus');
        }
        $learning_resource->delete();
        session()->flash('alert.learning_resource.success', 'Sumber belajar berhasil dihapus');
        return HttpResponse::success(Response::HTTP_OK, 'Sumber belajar berhasil dihapus', [
            'redirect' => route('teacher.learning-resource.index')
        ]);
    }
}
