<?php

namespace App\Architect;

use App\Architect\Cards\Groups\Card;
use App\Models\Group;
use Illuminate\Database\Eloquent\Builder;
use JPeters\Architect\Blueprints\Blueprint;

class GroupBlueprint extends Blueprint
{
    public function model(): string
    {
        return Group::class;
    }

    public function card()
    {
        return Card::class;
    }

    public function plans(): array
    {
        return [];
    }

    public function canEdit(): bool
    {
        return false;
    }

    public function perPage(): int
    {
        return 1;
    }

    public function paginate(): bool
    {
        return false;
    }

    public function blueprintName()
    {
        return 'Your Groups';
    }
}
