<?php

namespace App\Imports;

use App\Models\Organiser;
use App\Models\User;
use Auth;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;

class UsersImport implements OnEachRow, WithHeadingRow
{
    use Importable;

    public function __construct(Organiser $organiser, bool $emailUsers)
    {
        $this->organiser = $organiser;
        $this->emailUsers = $emailUsers;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function onRow(Row $row)
    {
        $rowArr = $row->toArray();
        $firstName = $rowArr['first_name'];
        $lastName = $rowArr['last_name'];
        $email = $rowArr['email'];

        \Log::info(sprintf("Importing user: %s (%s %s)", $email, $firstName, $lastName));

        $user = User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'organiser_id' => $this->organiser->id,
            'account_id' => Auth::user()->account_id,
        ]);

        if ($this->emailAttendees) {
            SendUserInviteJob::dispatch($user);
        }

        return $user;
    }
}
