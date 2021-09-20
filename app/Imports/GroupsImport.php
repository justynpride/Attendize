<?php

namespace App\Imports;

use App\Models\Organiser;
use App\Models\Group;
use Auth;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;

class GroupsImport implements OnEachRow, WithHeadingRow
{
    use Importable;

    public function __construct(Organiser $organiser)
    {
        $this->organiser = $organiser;
       }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function onRow(Row $row)
    {
        $rowArr = $row->toArray();
        $name = $rowArr['name'];
        $town = $rowArr['town'];
        $email = $rowArr['email'];

        \Log::info(sprintf("Importing group: %s (%s %s)", $email, $name, $town));

        $group = Group::create([
            'name' => $name,
            'town' => $town,
            'email' => $email,
            'organiser_id' => $this->organiser->id,
            'account_id' => Auth::user()->account_id,
        ]);

        return $group;
    }
}