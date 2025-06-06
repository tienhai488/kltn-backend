<?php

namespace App\Exports;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class VolunteerExport implements FromView, Responsable, ShouldAutoSize, WithColumnFormatting
{
    use Exportable;

    /**
     * {@inheritdoc}
     */
    private $fileName = 'volunteers.xlsx';

    public function __construct(
        protected $project = null,
        protected $volunteers = [],
    ) {
        $this->fileName = $this->project->name . '.xlsx';
    }

    /**
     * {@inheritdoc}
     */
    public function view(): View
    {
        return view('admin.volunteer.export', [
            'project' => $this->project,
            'volunteers' => $this->volunteers,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function columnFormats(): array
    {
        return [
            'A' => '0',
            'B' => '0',
            'C' => '0',
            'D' => '0',
            'E' => '0',
            'F' => '0',
            'G' => '0',
            'H' => '0',
            'I' => '0',
        ];
    }
}