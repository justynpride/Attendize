<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Auth;
use DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;

class UsersExport implements FromQuery, WithHeadings, WithEvents
{
    use Exportable;

    public function __construct(int $organiser_id)
    {
        $this->organiser_id = $organiser_id;
    }

    /**
    * @return \Illuminate\Support\Query
    */
    public function query()
    {
        $yes = strtoupper(trans("basic.yes"));
        $no = strtoupper(trans("basic.no"));
        $query = User::query()->select([
            'users.first_name',
            'users.last_name',
            'users.email',
            'users.created_at',
            'users.id',
        ])->join('organisers', 'organiser_id', '=', 'users.organiser_id')
            ->where('users.organiser_id', $this->organiser_id)
            ->where('users.account_id', Auth::user()->account_id);

        return $query;
    }

    public function headings(): array
    {
        return [
            trans("User.first_name"),
            trans("User.last_name "),
            trans("User.email"),
            trans("User.created_at"),
            trans("User.id"),
        ];
    }

     /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            BeforeExport::class => function(BeforeExport $event) {
                $event->writer->getProperties()->setCreator(config('attendize.app_name'));
                $event->writer->getProperties()->setCompany(config('attendize.app_name'));
            },
        ];
    }
}