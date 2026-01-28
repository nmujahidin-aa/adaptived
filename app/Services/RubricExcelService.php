<?php

namespace App\Services;

use Maatwebsite\Excel\Facades\Excel;

class RubricExcelService
{
    public function getRubricByQuestion(string $questionText): ?array
    {
        $rows = Excel::toArray(
            [],
            storage_path('app/rubrik_penilaian.xlsx')
        )[0];

        foreach ($rows as $index => $row) {
            if ($index === 0) continue;

            if (trim(strip_tags($row[0])) === trim(strip_tags($questionText))) {
                return [
                    'kunci_jawaban' => $row[1],
                    'rubrik' => [
                        5 => $row[2],
                        4 => $row[3],
                        3 => $row[4],
                        2 => $row[5],
                        1 => $row[6],
                    ],
                ];
            }
        }

        return null;
    }

    public function rubricToText(array $rubrik): string
    {
        return collect($rubrik)
            ->map(fn ($desc, $score) => "Skor {$score}: {$desc}")
            ->implode("\n");
    }
}
