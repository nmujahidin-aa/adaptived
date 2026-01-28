<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guide;
use App\Http\Requests\Admin\GuideRequest;
use Illuminate\Support\Facades\DB;

class GuideController extends Controller
{
    private $route;
    private $view;
    private $guide;

    public function __construct(){
        $this->route = 'admin.guide';
        $this->view = 'pages.admin.guide.';
        $this->guide = new Guide();
    }

    public function index(){
        // mengambil data panduan pertama
        $data = $this->guide->first();
        return view($this->view . 'index', compact('data'));
    }

    public function store(GuideRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->has('id')
                ? Guide::findOrFail($request->id)
                : new Guide();

            
            $data->fill($request->validated());
            $content = $request->input('guide-trixFields.content');

            $data->content = $content;
            $data->save();

            DB::commit();

            session()->flash(
                'alert.guide.success',
                $request->has('id')
                    ? 'Data petunjuk berhasil diperbarui'
                    : 'Data petunjuk berhasil ditambahkan'
            );

            return $request->has('id')
                ? redirect()->route('admin.guide.index')
                : redirect()->route('admin.guide.index');

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            session()->flash('alert.guide.error', 'Terjadi kesalahan: ' . $e->getMessage());
            return back()->withInput();
        }
    }
}
