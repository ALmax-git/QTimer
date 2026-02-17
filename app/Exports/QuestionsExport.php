<?php

namespace App\Exports;

use App\Models\Subject;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class QuestionsExport implements FromCollection, WithHeadings
{
    protected $subjectId;

    public function __construct($subjectId)
    {
        $this->subjectId = $subjectId;
    }

    public function collection()
    {
        $subject = Subject::with('questions_all.options')
            ->findOrFail($this->subjectId);

        $rows = collect();

        foreach ($subject->questions_all as $question) {
            $options = $question->options->values();

            $correctIndex = null;

            foreach ($options as $index => $option) {
                if ($option->is_correct) {
                    $correctIndex = $index + 1;
                }
            }

            $rows->push([
                $question->text,
                $options[0]->option ?? '',
                $options[1]->option ?? '',
                $options[2]->option ?? '',
                $options[3]->option ?? '',
                $correctIndex,
            ]);
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'Question',
            'Option 1',
            'Option 2',
            'Option 3',
            'Option 4',
            'Correct Option (1-4)',
        ];
    }
}
