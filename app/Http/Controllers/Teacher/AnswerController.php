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
use Illuminate\Support\Facades\Log;
use OpenAI;

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

    public function show($assesment_id, $user_id)
    {
        $assesment = Assesment::findOrFail($assesment_id);

        $answers = Answer::with(['question', 'user'])
            ->where('assesment_id', $assesment_id)
            ->where('user_id', $user_id)
            ->get();

        return view($this->view . 'show', [
            'assesment' => $assesment,
            'answers' => $answers,
        ]);
    }

    public function analyze($assesment_id, $id)
    {
        try {
            $data = Answer::findOrFail($id);
            $question = strip_tags($data->question->question);
            $answer = strip_tags($data->trixRender('answer'));

            $client = OpenAI::client(env('OPENAI_API_KEY'));
            $prompt = "Analisis terstruktur dan objektif.\n\nKonteks:\nPertanyaan: {$question}\nJawaban: {$answer}\n\nInstruksi:\n1. Ringkasan singkat (1 kalimat).\n2. Akurasi/kebenaran: jelaskan tepat/keliru dan beri bukti atau alasan (maks 2 kalimat).\n3. Kelebihan: tampilkan 2 poin bullet.\n4. Kekurangan: tampilkan 2 poin bullet.\n5. Rekomendasi perbaikan singkat (1 kalimat).\n\nPenting:\n- Jangan ajukan pertanyaan, jangan menawarkan varian.\n- Jangan gunakan frasa seperti \"Apakah Anda ingin...\" atau \"Mau saya buatkan...\".\n- Batasi total output hingga ~250 kata. Nada: profesional, jelas.";

            $response = $client->chat()->create([
                'model' => 'gpt-5-nano',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => "{$prompt}"
                    ]
                ]
            ]);

            $answer = $response->choices[0]->message->content
                ?? "Tidak ada hasil dari OpenAI.";

            $data->analysis = $answer;
            $data->save();

            return response()->json([
                "status" => "success",
                "data" => $answer
            ]);

        } catch (\Exception $e) {

            Log::error("AI Analyze Error", [
                "error" => $e->getMessage(),
                "line" => $e->getLine(),
                "file" => $e->getFile()
            ]);

            return response()->json([
                "status" => "error",
                "message" => "Sistem error",
                "debug" => $e->getMessage()
            ], 500);
        }
    }

    public function analyzeAll($assesment_id, Request $request)
    {
        $user_id = $request->user_id;

        $answers = Answer::with('question')
            ->where('assesment_id', $assesment_id)
            ->where('user_id', $user_id)
            ->get();

        foreach ($answers as $data) {
            if ($data->analysis) continue;
            $question = strip_tags($data->question->question);
            $answer   = strip_tags($data->trixRender('answer'));

            $prompt = "Analisis singkat dan objektif.\n\nPertanyaan: {$question}\nJawaban: {$answer}";

            $client = OpenAI::client(env('OPENAI_API_KEY'));
            $response = $client->chat()->create([
                'model' => 'gpt-5-nano',
                'messages' => [[
                    'role' => 'user',
                    'content' => $prompt
                ]]
            ]);

            $data->analysis = $response->choices[0]->message->content ?? null;
            $data->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Semua jawaban berhasil dianalisis'
        ]);
    }
}
