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
        $data = null;
        if ($id) {
            $data = $this->worksheet::findOrFail($id);
        }
        return view($this->view . 'edit', [
            'data' => $data,
        ]);
    }

    public function store(WorksheetRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->has('id')
                ? Worksheet::findOrFail($request->id)
                : new Worksheet();

            
            $data->fill($request->validated());

            $instruction = $request->input('worksheet-trixFields.instruction');

            $data->instruction = $instruction;

            $data->save();

            DB::commit();

            session()->flash(
                'alert.worksheet.success',
                $request->has('id')
                    ? 'Data kegiatan belajar berhasil diperbarui'
                    : 'Data kegiatan belajar berhasil ditambahkan'
            );

            return $request->has('id')
                ? redirect()->route('teacher.worksheet.edit', $data->id)
                : redirect()->route('teacher.worksheet.index');

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            session()->flash('alert.worksheet.error', 'Terjadi kesalahan: ' . $e->getMessage());
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
