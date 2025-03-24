<?php

namespace App\Exports;

use App\Models\Exam;
use Maatwebsite\Excel\Concerns\FromCollection;



use App\Models\Set;
use App\Models\Result;
use App\Models\QuestionAnswer;
use App\Models\User;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;





class ExamResultsExport implements FromCollection, WithHeadings, WithTitle, WithEvents
{
    protected $set_id, $exam_id, $columns = [], $exam;

    public function __construct($set_id, $exam_id)
    {
        $this->set_id = $set_id;
        $this->exam_id = $exam_id;
    }

    public function collection()
    {
        // Fetch the set and exam
        $set = Set::find($this->set_id);
        $this->exam = Exam::find($this->exam_id);

        $total_question_count = 0;
        foreach ($this->exam->subjects as $subject) {
            $total_question_count += $subject->questions->count(); // Add subject titles as columns
        }

        // Define the columns for the Excel sheet
        // $this->columns = ['Name', 'Email', 'ID_Number', 'Status', 'Total (' . $total_question_count . ')', 'Attempts'];
        $this->columns = ['Name', 'ID_Number', 'Status', 'Total (' . $total_question_count . ')', 'Attempts'];
        foreach ($this->exam->subjects as $subject) {
            $this->columns[] = $subject->title . ' [Q: ' . $subject->questions->count() . ' ]'; // Add subject titles as columns
        }

        // Fetch students in the set
        $set_students = $set->users;

        // Prepare the data for export
        $data = [];
        $row = [
            'Name' => "Student Name",
            //'Email' => 'Email',
            'ID_Number' => 'ID_Number',
            'Status' => 'Status', // Default status
            'Total (' . $total_question_count . ')' => 'Total (' . $total_question_count . ')', // Default total score
            'Attempts' => 'Attempts',
        ];
        // Initialize subject-wise scores
        foreach ($this->exam->subjects as $subject) {
            $row[$subject->title . ' (' . $subject->questions->count() . ' )'] = $subject->title . ' (' . $subject->questions->count() . ' )'; // Initialize subject-wise percentage
        }
        $data[] = $row;

        foreach ($set_students as $student) {
            $row = [
                'Name' => $student->name,
                //'Email' => $student->email,
                'ID_Number' => $student->id_number,
                'Status' => 'absent', // Default status
                'Total (' . $total_question_count . ')' => '0', // Default total score
                'Attempts' => '0',
            ];

            // Initialize subject-wise scores
            foreach ($this->exam->subjects as $subject) {
                $row[$subject->title . ' (' . $subject->questions->count() . ' )'] = '0'; // Initialize subject-wise percentage
            }

            // Check if the student has taken the exam
            $result = Result::where('user_id', $student->id)
                ->where('exam_id', $this->exam_id)
                ->first();

            if ($result) {
                $row['Status'] = 'present';

                // Calculate total score and subject-wise scores
                $totalCorrect = 0;
                $totalQuestions = 0;

                foreach ($this->exam->subjects as $subject) {
                    $subjectCorrect = 0;
                    $subjectQuestions = $subject->questions->count();

                    foreach ($subject->questions as $question) {
                        $QuestionAnswer = QuestionAnswer::where('exam_id', $this->exam_id)
                            ->where('user_id', $student->id)
                            ->where('question_id', $question->id)
                            ->first();

                        if ($QuestionAnswer && $QuestionAnswer->is_correct) {
                            $subjectCorrect++;
                            $totalCorrect++;
                        }
                    }

                    // Calculate subject-wise percentage
                    // $subjectPercentage = $subjectQuestions > 0 ? round(($subjectCorrect / $subjectQuestions) * 100, 2) : '0';
                    $subjectPercentage = $subjectQuestions > 0 ? $subjectCorrect : '0';
                    $row[$subject->title . ' (' . $subject->questions->count() . ' )'] = '' . $subjectPercentage . '';
                    $totalQuestions += $subjectQuestions;
                }

                // Calculate total percentage
                // $total_score =  $totalQuestions > 0 ? round(($totalCorrect / $totalQuestions) * 100, 2) : '0';
                $total_score =  $totalQuestions > 0 ? $totalCorrect : '0';
                $row['Total (' . $total_question_count . ')'] = '' . $total_score . '';
                $row['Attempts'] = ''. QuestionAnswer::where('exam_id', $this->exam_id)->where('user_id', $student->id)->count() . '';
                // dd($this, $row, $result);
            }

            // Add the row to the data array
            $data[] = $row;
        }

        return collect($data);
    }

    public function headings(): array
    {
        // First row: Exam title
        $this->exam = Exam::find($this->exam_id);
        $firstRow = ['Exam: ' . $this->exam->title];

        // Second row: Column headers
        $secondRow = $this->columns;

        return [$firstRow, $secondRow];
    }

    public function title(): string
    {
        return 'Exam Results'; // Sheet title
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Merge cells for the exam title row
                $event->sheet->mergeCells('A1:' . $event->sheet->getHighestColumn() . '1');

                // Style the exam title row
                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // Style the column headers row
                $event->sheet->getStyle('A2:' . $event->sheet->getHighestColumn() . '2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'argb' => 'FFD9D9D9',
                        ],
                    ],
                ]);
            },
        ];
    }
}
