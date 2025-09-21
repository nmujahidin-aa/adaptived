<?php

namespace App\Http\Controllers\Teacher;

use App\DataTables\Teacher\WorksheetsDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Worksheet; 
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Teacher\WorksheetRequest;
use App\Helpers\HttpResponse;
use Illuminate\Http\Response;
use App\Helpers\UploadHelper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Instruction;

class WorksheetController extends Controller
{
    public $route;
    public $view;
    public $worksheet;

    public function __construct(){
        $this->route = 'teacher.worksheet.';
        $this->view = 'pages.teacher.worksheet.';
        $this->worksheet = new Worksheet();
    }

    public function index(WorksheetsDataTable $dataTable) {
        $user = Auth::user();
        $worksheets = $this->worksheet::where('school_id', $user->school_id);
        $worksheet_count = $worksheets->count();
        return $dataTable->render($this->view . 'index', [
            'worksheet_count' => $worksheet_count,
        ]);
    }

    public function edit(string $id = null) {
        if ($id) {
            $data = $this->worksheet::with('instructions')->findOrFail($id);
        } else {
            $data = new $this->worksheet;
            $data->setRelation('instructions', collect());
        }

        return view($this->view . 'edit', compact('data'));
    }

    public function store(WorksheetRequest $request)
    {
        $data = $request->filled('id')
            ? Worksheet::findOrFail($request->id)
            : new Worksheet();

        $data->fill($request->validated());

        if ($request->hasFile('cover')) {
            if (!empty($data->cover) && Storage::exists('public/'.$data->cover)) {
                Storage::delete('public/'.$data->cover);
            }

            $result = UploadHelper::upload_file(
                $request->file('cover'),
                'worksheet/cover',    
                ['png','jpg','jpeg']  
            );

            if (!$result['IsError']) {
                $data->cover = $result['Path'];
            } else {
                session()->flash('alert.worksheet.error', $result['Message']);
                return back()->withInput();
            }
        }

        $data->save();

        session()->flash('alert.worksheet.success', $request->has('id')? 'Data lembar kerja berhasil diperbarui' : 'Data lembar kerja berhasil ditambahkan');

        return $request->has('id')
            ? redirect()->route('teacher.worksheet.edit', $data->id)
            : redirect()->route('teacher.worksheet.index');
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
            $worksheet = $this->worksheet->find($id);
            if (!$worksheet) {
                continue;
            }
            $worksheet->delete();
        }
        return HttpResponse::success(Response::HTTP_OK, 'kegiatan belajar berhasil dihapus');
    }

    public function single_destroy() {
        $worksheet = $this->worksheet->findOrFail(request()->route('id'));

        if (!$worksheet) {
            return HttpResponse::fail(Response::HTTP_NOT_FOUND, 'kegiatan belajar tidak ditemukan atau sudah dihapus');
        }
        $worksheet->delete();
        session()->flash('alert.worksheet.success', 'kegiatan belajar berhasil dihapus');
        return HttpResponse::success(Response::HTTP_OK, 'kegiatan belajar berhasil dihapus', [
            'redirect' => route('teacher.worksheet.index')
        ]);
    }
}
