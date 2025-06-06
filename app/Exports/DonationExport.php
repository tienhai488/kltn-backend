<?php

namespace App\Exports;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class DonationExport implements FromView, Responsable, ShouldAutoSize, WithColumnFormatting
{
    use Exportable;

    /**
     * {@inheritdoc}
     */
    private $fileName = 'donations.xlsx';

    public function __construct(
        protected $project = null,
        protected $donations = null,
    ) {
        $this->fileName = $this->project->name . '.xlsx';
    }

    public function view(): View
    {
        return view('admin.donation.export', [
            'project' => $this->project,
            'donations' => $this->donations,
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
            'J' => '0',
        ];
    }
}