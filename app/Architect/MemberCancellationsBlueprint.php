<?php

namespace App\Architect;

use App\Architect\Cards\MemberCancellations\Card;
use App\Models\MemberCancellation;
use Illuminate\Container\Container;
use Illuminate\Contracts\Cache\Repository;
use JPeters\Architect\Blueprints\Blueprint;

class MemberCancellationsBlueprint extends Blueprint
{
    public function model(): string
    {
        return MemberCancellation::class;
    }

    public function plans(): array
    {
        return [];
    }

    public function card(): ?string
    {
        return Card::class;
    }

    public function blueprintName(): string
    {
        return 'Cancellations';
    }

    public function searchable(): bool
    {
        return false;
    }

    public function canEdit(): bool
    {
        return false;
    }

    public function displayCount(): int
    {
        $cacheRepository = Container::getInstance()->make(Repository::class);

        return MemberCancellation::query()
            ->where('id', '>', $cacheRepository->get('architect-cancellations-last-seen', 0))
            ->count();
    }
}
