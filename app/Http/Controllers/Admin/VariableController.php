<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Variable;
use App\DataTables\Admin\VariablesDataTable;
use App\Helpers\HttpResponse;
use Illuminate\Http\Response;
use App\Http\Requests\Admin\VariableRequest;

class VariableController extends Controller
{
    private $view;
    private $variable;

    public function __construct(){
        $this->view = "pages.admin.variable.";
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
        $data = null;
        if ($id) {
            $data = $this->variable::findOrFail($id);
        }
        return view($this->view . 'edit', [
            'data' => $data
        ]);
    }

    public function store(VariableRequest $request) {
        if ($request->has('id')) {
            $variable = $this->variable::findOrFail($request->id);
            $variable->update($request->validated());
            session()->flash('alert.variable.success', 'Data variabel berhasil diperbarui');
            return redirect()->route('admin.variable.edit', $request->id);
        } else {
            $this->variable::create($request->validated());
            session()->flash('alert.variable.success', 'Data variabel berhasil ditambahkan');
            return redirect()->route('admin.variable.index');
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
            $variable = $this->variable::find($id);
            if (!$variable) {
                continue;
            }
            $variable->delete();
        }
        return HttpResponse::success(Response::HTTP_OK, 'Variable deleted successfully');
    }

    public function single_destroy() {
        $variable = $this->variable::findOrFail(request()->route('id'));

        if (!$variable) {
            return HttpResponse::fail(Response::HTTP_NOT_FOUND, 'Variable tidak ditemukan atau sudah dihapus');
        }
        $variable->delete();
        session()->flash('alert.variable.success', 'Variable berhasil dihapus');
        return HttpResponse::success(Response::HTTP_OK, 'Variable berhasil dihapus', [
            'redirect' => route('admin.variable.index')
        ]);
    }
}
