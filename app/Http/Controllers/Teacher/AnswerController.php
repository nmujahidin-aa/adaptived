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
        $data = Answer::findOrFail($id);
        $kata = strip_tags($data->trixRender('answer'));

        $apiKey = env('GEMINI_API_KEY');
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-3-pro-preview:generateContent?key={$apiKey}";

        try {

            $response = Http::timeout(20)
                ->withHeaders([
                    "Content-Type" => "application/json",
                ])
                ->post($url, [
                    "contents" => [
                        [
                            "parts" => [
                                ["text" => "Analisa jawaban berikut:\n\n{$kata}"]
                            ]
                        ]
                    ]
                ]);

            // Kalau gagal dari sisi API (403, 429, 500)
            if ($response->failed()) {

                $errorMessage = $response->json()['error']['message'] ?? 'Terjadi kesalahan pada layanan AI.';

                return back()->with('error', "Gagal memproses analisis AI: {$errorMessage}");
            }

            // Ambil output AI
            $result = $response->json();
            $output = $result['candidates'][0]['content']['parts'][0]['text'] ?? 'Tidak ada hasil analisis.';

            return view('teacher.answer.analysis', compact('data', 'output'));

        } catch (\Exception $e) {

            // Error internal (timeout, jaringan, parsing, dll)
            return back()->with('error', "Terjadi kesalahan sistem: " . $e->getMessage());
        }
    }
}
