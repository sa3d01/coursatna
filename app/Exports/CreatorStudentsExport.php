<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;

class CreatorStudentsExport implements FromCollection, WithMapping
{
    private $where;

    public function __construct($where)
    {
        $this->where = $where;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::with('university')->with('faculty')
            ->role('UNIVERSITY_CREATOR_STUDENT')
            ->where($this->where)
            //->select('name', 'email', 'phone', 'university_id', 'faculty_id', 'subject')
            ->get();
    }

    public function map($row): array
    {
        return [
            $row->name,
            $row->email,
            $row->phone,
            $row->school_name,
            $row->university->name ?? '',
            $row->faculty->name ?? '',
            $row->level,
            $row->os_type,
            $row->gender,
        ];
    }
}
