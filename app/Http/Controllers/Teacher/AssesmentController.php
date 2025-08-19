<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Variable;
use App\DataTables\VariablesDataTable;
use App\Helpers\HttpResponse;
use Illuminate\Http\Response;
use App\Http\Requests\Teacher\VariableRequest;

class AssesmentController extends Controller
{
    private $view;
    private $variable;

    public function __construct(){
        $this->view = "pages.teacher.assesment.";
        $this->variable = new Variable();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(VariablesDataTable $dataTable) {
        $variable_count = $this->variable->count();
        return $dataTable->render($this->view . 'index', [
            'variable_count' => $variable_count,
        ]);
    }

    public function edit(string $id = null) {
        $variable = null;
        if ($id) {
            $variable = Variable::findOrFail($id);
        }
        return view($this->view . 'edit', [
            'variable' => $variable
        ]);
    }

    public function store(VariableRequest $request) {
        if ($request->has('id')) {
            $variable = Variable::findOrFail($request->id);
            $variable->update($request->validated());
            session()->flash('alert.assesment.success', 'Data variabel berhasil diperbarui');
            return redirect()->route('teacher.assesment.edit', $request->id);
        } else {
            Variable::create($request->validated());
            session()->flash('alert.assesment.success', 'Data variabel berhasil ditambahkan');
            return redirect()->route('teacher.assesment.index');
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
            $assesment = Variable::find($id);
            if (!$assesment) {
                continue;
            }
            $assesment->delete();
        }
        return HttpResponse::success(Response::HTTP_OK, 'Assesment deleted successfully');
    }

    public function single_destroy() {
        $assesment = Variable::findOrFail(request()->route('id'));

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
