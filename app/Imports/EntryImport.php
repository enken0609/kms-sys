<?php

namespace App\Imports;

use App\Models\Entry;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class EntryImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $raceId;

    public function __construct($raceId)
    {
        $this->raceId = $raceId;
    }

    public function model(array $row)
    {
        return new Entry([
            'race_id' => $this->raceId,
            'name' => $row['name'],
            'name_kana' => $row['name_kana'],
            'gender' => $row['gender'],
            'age' => $row['age'],
            'team_name' => $row['team_name'],
            'start_time' => $row['start_time'],
            'bib_number' => $row['bib_number'],
            'category' => $row['category'],
            'award_category' => $row['award_category'],
        ]);
    }

    public function rules(): array
    {
        return [
            '*.bib_number' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'bib_number.unique' => 'The bib number :input is already in use.',
        ];
    }
}
