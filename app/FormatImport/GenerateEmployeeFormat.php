<?php

namespace App\FormatImport;

use App\Models\Bank;
use App\Models\BranchOffice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\EmployeeType;
use App\Models\Department;
use App\Models\Position;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Auth;



class GenerateEmployeeFormat implements FromView, ShouldAutoSize, WithEvents, WithStrictNullComparison
{
    public function view(): View
    {
        return view('employees.format');
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:AA1'; // All headers
                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                // Kolom C
                $kolom_c = 'C';
                $kolomC = [];
                $dataDepartemen = Department::get();
                foreach ($dataDepartemen as $value) {
                    array_push($kolomC, $value->department_name);
                }
                $validationC = $event->sheet->getCell("{$kolom_c}2")->getDataValidation();
                $validationC->setType(DataValidation::TYPE_LIST);
                $validationC->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validationC->setAllowBlank(false);
                $validationC->setShowInputMessage(true);
                $validationC->setShowErrorMessage(true);
                $validationC->setShowDropDown(true);
                $validationC->setErrorTitle('Input error');
                $validationC->setError('Value is not in list.');
                $validationC->setPromptTitle('Pick from list');
                $validationC->setPrompt('Please pick a value from the drop-down list.');
                $validationC->setFormula1(sprintf('"%s"', implode(',', $kolomC)));

                // Kolom D
                $kolom_d = 'D';
                $kolomD = [
                    'Male',
                    'Female',
                ];
                $validationD = $event->sheet->getCell("{$kolom_d}2")->getDataValidation();
                $validationD->setType(DataValidation::TYPE_LIST);
                $validationD->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validationD->setAllowBlank(false);
                $validationD->setShowInputMessage(true);
                $validationD->setShowErrorMessage(true);
                $validationD->setShowDropDown(true);
                $validationD->setErrorTitle('Input error');
                $validationD->setError('Value is not in list.');
                $validationD->setPromptTitle('Pick from list');
                $validationD->setPrompt('Please pick a value from the drop-down list.');
                $validationD->setFormula1(sprintf('"%s"', implode(',', $kolomD)));

                // Kolom F
                $kolom_f = 'F';
                $kolomF = [
                    'Single',
                    'Married',
                    'Divorced',
                    'Widowed',
                ];
                $validationF = $event->sheet->getCell("{$kolom_f}2")->getDataValidation();
                $validationF->setType(DataValidation::TYPE_LIST);
                $validationF->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validationF->setAllowBlank(false);
                $validationF->setShowInputMessage(true);
                $validationF->setShowErrorMessage(true);
                $validationF->setShowDropDown(true);
                $validationF->setErrorTitle('Input error');
                $validationF->setError('Value is not in list.');
                $validationF->setPromptTitle('Pick from list');
                $validationF->setPrompt('Please pick a value from the drop-down list.');
                $validationF->setFormula1(sprintf('"%s"', implode(',', $kolomF)));

                // Kolom G
                $kolom_g = 'G';
                $kolomG = [
                    'KTP',
                ];
                $validationG = $event->sheet->getCell("{$kolom_g}2")->getDataValidation();
                $validationG->setType(DataValidation::TYPE_LIST);
                $validationG->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validationG->setAllowBlank(false);
                $validationG->setShowInputMessage(true);
                $validationG->setShowErrorMessage(true);
                $validationG->setShowDropDown(true);
                $validationG->setErrorTitle('Input error');
                $validationG->setError('Value is not in list.');
                $validationG->setPromptTitle('Pick from list');
                $validationG->setPrompt('Please pick a value from the drop-down list.');
                $validationG->setFormula1(sprintf('"%s"', implode(',', $kolomG)));


                // Kolom L
                $kolom_l = 'L';
                $kolomL = [];
                $dataBranchOffice = BranchOffice::get();
                foreach ($dataBranchOffice as $value) {
                    array_push($kolomL, $value->name);
                }
                $validationL = $event->sheet->getCell("{$kolom_l}2")->getDataValidation();
                $validationL->setType(DataValidation::TYPE_LIST);
                $validationL->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validationL->setAllowBlank(false);
                $validationL->setShowInputMessage(true);
                $validationL->setShowErrorMessage(true);
                $validationL->setShowDropDown(true);
                $validationL->setErrorTitle('Input error');
                $validationL->setError('Value is not in list.');
                $validationL->setPromptTitle('Pick from list');
                $validationL->setPrompt('Please pick a value from the drop-down list.');
                $validationL->setFormula1(sprintf('"%s"', implode(',', $kolomL)));


                // Kolom P
                $kolom_p = 'P';
                $kolomP = [
                    'Active',
                    'Non Active',
                ];
                $validationP = $event->sheet->getCell("{$kolom_p}2")->getDataValidation();
                $validationP->setType(DataValidation::TYPE_LIST);
                $validationP->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validationP->setAllowBlank(false);
                $validationP->setShowInputMessage(true);
                $validationP->setShowErrorMessage(true);
                $validationP->setShowDropDown(true);
                $validationP->setErrorTitle('Input error');
                $validationP->setError('Value is not in list.');
                $validationP->setPromptTitle('Pick from list');
                $validationP->setPrompt('Please pick a value from the drop-down list.');
                $validationP->setFormula1(sprintf('"%s"', implode(',', $kolomP)));

                $kolom_q = 'Q';
                $kolomQ = [
                    'IDR',
                    'USD',
                ];
                $validationQ = $event->sheet->getCell("{$kolom_q}2")->getDataValidation();
                $validationQ->setType(DataValidation::TYPE_LIST);
                $validationQ->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validationQ->setAllowBlank(false);
                $validationQ->setShowInputMessage(true);
                $validationQ->setShowErrorMessage(true);
                $validationQ->setShowDropDown(true);
                $validationQ->setErrorTitle('Input error');
                $validationQ->setError('Value is not in list.');
                $validationQ->setPromptTitle('Pick from list');
                $validationQ->setPrompt('Please pick a value from the drop-down list.');
                $validationQ->setFormula1(sprintf('"%s"', implode(',', $kolomQ)));

                $kolom_u = 'U';
                $kolomU = [
                    'daily',
                    'monthly',
                    'monthly_and_daily',
                ];
                $validationU = $event->sheet->getCell("{$kolom_u}2")->getDataValidation();
                $validationU->setType(DataValidation::TYPE_LIST);
                $validationU->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validationU->setAllowBlank(false);
                $validationU->setShowInputMessage(true);
                $validationU->setShowErrorMessage(true);
                $validationU->setShowDropDown(true);
                $validationU->setErrorTitle('Input error');
                $validationU->setError('Value is not in list.');
                $validationU->setPromptTitle('Pick from list');
                $validationU->setPrompt('Please pick a value from the drop-down list.');
                $validationU->setFormula1(sprintf('"%s"', implode(',', $kolomU)));


                $kolom_y = 'Y';
                $kolomY = [];
                $dataBank = Bank::get();
                foreach ($dataBank as $value) {
                    array_push($kolomY, $value->name);
                }
                $validationY = $event->sheet->getCell("{$kolom_y}2")->getDataValidation();
                $validationY->setType(DataValidation::TYPE_LIST);
                $validationY->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validationY->setAllowBlank(false);
                $validationY->setShowInputMessage(true);
                $validationY->setShowErrorMessage(true);
                $validationY->setShowDropDown(true);
                $validationY->setErrorTitle('Input error');
                $validationY->setError('Value is not in list.');
                $validationY->setPromptTitle('Pick from list');
                $validationY->setPrompt('Please pick a value from the drop-down list.');
                $validationY->setFormula1(sprintf('"%s"', implode(',', $kolomY)));

                for ($i = 3; $i <= 1000; $i++) {
                    $event->sheet->getCell("{$kolom_c}{$i}")->setDataValidation(clone $validationC);
                    $event->sheet->getCell("{$kolom_d}{$i}")->setDataValidation(clone $validationD);
                    $event->sheet->getCell("{$kolom_f}{$i}")->setDataValidation(clone $validationF);
                    $event->sheet->getCell("{$kolom_g}{$i}")->setDataValidation(clone $validationG);
                    $event->sheet->getCell("{$kolom_l}{$i}")->setDataValidation(clone $validationL);
                    $event->sheet->getCell("{$kolom_p}{$i}")->setDataValidation(clone $validationP);
                    $event->sheet->getCell("{$kolom_q}{$i}")->setDataValidation(clone $validationQ);
                    $event->sheet->getCell("{$kolom_u}{$i}")->setDataValidation(clone $validationU);
                    $event->sheet->getCell("{$kolom_y}{$i}")->setDataValidation(clone $validationY);
                }
            },
        ];
    }
}
