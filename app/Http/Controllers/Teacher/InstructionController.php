<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Instruction;
use Illuminate\Support\Facades\Auth;
use App\Models\Wor;
use Illuminate\Http\Response;
use App\DataTables\Teacher\InstructionsDataTable;
use App\Http\Requests\Teacher\InstructionRequest;
use App\Helpers\HttpResponse;
use Illuminate\Support\Facades\DB;

class InstructionController extends Controller
{
    protected $view;
    protected $route;
    protected $instruction;

    public function __construct(){
        $this->view = "pages.teacher.instruction.";
        $this->route = "teacher.instruction.";
        $this->instruction = new Instruction();
    }

    public function index(InstructionsDataTable $dataTable, $worksheet_id)
    {
        $instruction_count = Instruction::where('worksheet_id', $worksheet_id)->count();
        return $dataTable->with(['worksheet_id' => $worksheet_id])
        ->render($this->view.'index', [
            'worksheet_id' => $worksheet_id,
            'instruction_count' => $instruction_count,
        ]);
    }

    public function edit($worksheet_id, string $id = null) {
        if ($id) {
            $data = Instruction::findOrFail($id);
        } else {
            $data = new Instruction();
            $data->worksheet_id = $worksheet_id;
        }

        return view($this->view . 'edit', [
            'data' => $data,
            'worksheet_id' => $worksheet_id,
        ]);
    }

    public function store(InstructionRequest $request) {
        DB::beginTransaction();
        try {
            $data = $request->filled('id')
                ? Instruction::findOrFail($request->id)
                : new Instruction();
            
            $data->fill($request->validated());

            $data->instruction = $request->input('instruction-trixFields.instruction', $data->instruction);

            $data->save();

            DB::commit();

            session()->flash(
                'alert.instruction.success',
                $request->has('id')
                    ? 'Data instruksi berhasil diperbarui'
                    : 'Data instruksi berhasil ditambahkan'
            );

            return $request->has('id')
                ? redirect()->route('teacher.instruction.edit', ['worksheet_id' => $data->worksheet_id, 'id' => $data->id])
                : redirect()->route('teacher.instruction.index', ['worksheet_id' => $data->worksheet_id]);

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            session()->flash('alert.instruction.error', 'Terjadi kesalahan: ' . $e->getMessage());
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
            $instruction = Instruction::find($id);
            if (!$instruction) {
                continue;
            }
            $instruction->delete();
        }
        return HttpResponse::success(Response::HTTP_OK, 'Instruction deleted successfully');
    }

    public function single_destroy() {
        $instruction = Instruction::findOrFail(request()->route('id'));

        if (!$instruction) {
            return HttpResponse::fail(Response::HTTP_NOT_FOUND, 'Instruction tidak ditemukan atau sudah dihapus');
        }
        $instruction->delete();
        session()->flash('alert.instruction.success', 'Instruction berhasil dihapus');
        return HttpResponse::success(Response::HTTP_OK, 'Instruction berhasil dihapus', [
            'redirect' => route('teacher.instruction.index', ['worksheet_id' => $instruction->worksheet_id])
        ]);
    } 
}
