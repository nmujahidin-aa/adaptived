<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assesment;
use App\DataTables\Teacher\AssesmentsDataTable;
use App\Helpers\HttpResponse;
use Illuminate\Http\Response;
use App\Http\Requests\Teacher\AssesmentRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AssesmentController extends Controller
{
    private $view;
    private $assesment;

    public function __construct(){
        $this->view = "pages.teacher.assesment.";
        $this->assesment = new Assesment();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AssesmentsDataTable $dataTable) {
        $assesment_count = $this->assesment->count();
        return $dataTable->render($this->view . 'index', [
            'assesment_count' => $assesment_count,
        ]);
    }

    public function edit(string $id = null) {
        $assesment = null;
        $variables = \App\Models\Variable::all();
        if ($id) {
            $assesment = Assesment::findOrFail($id);
        }
        return view($this->view . 'edit', [
            'assesment' => $assesment,
            'variables' => $variables
        ]);
    }

    public function store(AssesmentRequest $request) {
        DB::beginTransaction();
        try {
            $data = $request->has('id')
                ? Assesment::findOrFail($request->id)
                : new Assesment();

            
            $data->fill($request->validated());

            $question = $request->input('assesment-trixFields.question');

            $data->question = $question;

            $data->save();

            DB::commit();

            session()->flash(
                'alert.assesment.success',
                $request->has('id')
                    ? 'Data assesment berhasil diperbarui'
                    : 'Data assesment berhasil ditambahkan'
            );

            return $request->has('id')
                ? redirect()->route('teacher.assesment.edit', $data->id)
                : redirect()->route('teacher.assesment.index');

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            session()->flash('alert.assesment.error', 'Terjadi kesalahan: ' . $e->getMessage());
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
            $assesment = Assesment::find($id);
            if (!$assesment) {
                continue;
            }
            $assesment->delete();
        }
        return HttpResponse::success(Response::HTTP_OK, 'Assesment deleted successfully');
    }

    public function single_destroy() {
        $assesment = Assesment::findOrFail(request()->route('id'));

        if (!$assesment) {
            return HttpResponse::fail(Response::HTTP_NOT_FOUND, 'Assesment tidak ditemukan atau sudah dihapus');
        }
        $assesment->delete();
        session()->flash('alert.assesment.success', 'Assesment berhasil dihapus');
        return HttpResponse::success(Response::HTTP_OK, 'Assesment berhasil dihapus', [
            'redirect' => route('teacher.assesment.index')
        ]);
    }
}
