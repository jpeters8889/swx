<?php

namespace App\Architect;

use App\Models\Group;
use App\Models\GroupAnnouncement;
use JPeters\Architect\Blueprints\Blueprint;
use JPeters\Architect\Plans\DateTime;
use JPeters\Architect\Plans\Select;
use JPeters\Architect\Plans\Textarea;

class GroupAnnouncementBlueprint extends Blueprint
{
    public function model(): string
    {
        return GroupAnnouncement::class;
    }

    public function blueprintName(): string
    {
        return 'Announcements';
    }

    public function blueprintRoute(): string
    {
        return 'announcements';
    }

    public function plans(): array
    {
        return [
            Select::generate('group_id', 'Group')->options($this->groups()),

            Textarea::generate('announcement'),

            DateTime::generate('start_at'),

            DateTime::generate('end_at'),

            DateTime::generate('created_at')->hideOnForms(),
        ];
    }

    protected function groups(): array
    {
        return Group::query()
            ->orderBy('name')
            ->get()
            ->mapWithKeys(static function (Group $group) {
                return [$group->id => $group->name];
            })
            ->toArray();
    }
}
