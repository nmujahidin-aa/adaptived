<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\Teacher\AnswersDataTable;
use Illuminate\Support\Facades\Auth;
use App\Models\Answer;
use App\Models\Assesment;
use Illuminate\Support\Facades\Http;
use App\Helpers\HttpResponse;
use Illuminate\Http\Response;

class AnswerController extends Controller
{
    protected $view;
    protected $route;
    protected $analysis;

    private $apiKey;
    private $baseUrl;
    private $model;

    public function __construct(){
        $this->view = "pages.teacher.answer.";
        $this->route = "teacher.answer.";
        $this->analysis = new Answer();

        $this->baseUrl = config('services.byteplus.base_url');
        $this->apiKey = config('services.byteplus.api_key');
        $this->model = config('services.byteplus.model');
        
        if (empty($this->baseUrl)) {
            throw new \Exception('BYTEPLUS_BASE_URL is not set in environment variables');
        }
        if (empty($this->apiKey)) {
            throw new \Exception('BYTEPLUS_API_KEY is not set in environment variables');
        }
        if (empty($this->model)) {
            throw new \Exception('ARK_MODEL_NAME is not set in environment variables');
        }
    }

    public function index(AnswersDataTable $dataTable, $assesment_id)
    {
        $assesment_count = Answer::where('assesment_id', $assesment_id)->count();
        return $dataTable->with(['assesment_id' => $assesment_id])
        ->render($this->view.'index', [
            'assesment_id' => $assesment_id,
            'assesment_count' => $assesment_count,
        ]);
    }

    public function show($assesment_id, $id)
    {
        $assesment = Assesment::findOrFail($assesment_id);
        $data = Answer::findOrFail($id);

        return view($this->view . 'show', [
            'data' => $data,
            'assesment' => $assesment,
        ]);
    }

    public function analyze($assesment_id, $id)
    {
        try {
            $assesment = Assesment::findOrFail($assesment_id);
            $data = Answer::findOrFail($id);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.ai.token'),
                'Accept' => 'application/json',
            ])->post(config('services.ai.endpoint') . '/analyze', [
                'question' => $assesment->question,
                'answer'   => $data->answer,
            ]);

            dd($response->json());

            if ($response->failed()) {
                throw new \Exception('Gagal menghubungi API AI');
            }

            $analysisResult = $response->json()['result'] ?? null;

            if (!$analysisResult) {
                throw new \Exception('Respons API AI tidak valid');
            }

            // Simpan hasil analisis ke kolom `analysis`
            $data->analysis = $analysisResult;

            $data->save();

            return redirect()
                ->route('teacher.answer.show', [
                    'assesment_id' => $assesment_id,
                    'id' => $id
                ])
                ->with('success', 'Analisis berhasil disimpan.');

        } catch (\Exception $e) {
            return redirect()
                ->route('teacher.answer.show', [
                    'assesment_id' => $assesment_id,
                    'id' => $id
                ])
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
