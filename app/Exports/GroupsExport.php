<?php

namespace App\Exports;

use App\Models\Group;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Auth;
use DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;

class GroupsExport implements FromQuery, WithHeadings, WithEvents
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
        $query = Group::query()->select([
            'groups.name',
            'groups.town',
            'groups.email',
            'groups.country_id',
            'groups.created_at',
            'groups.id',
        ])->join('organisers', 'organiser_id', '=', 'groups.organiser_id')
            ->where('groups.organiser_id', $this->organiser_id)
            ->where('groups.account_id', Auth::user()->account_id);

        return $query;
    }

    public function headings(): array
    {
        return [
            trans("Group.name"),
            trans("Group.town "),
            trans("Group.email"),
            trans("Group.country"),
            trans("Group.created_at"),
            trans("Group.id"),
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