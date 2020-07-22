<?php

namespace App\Architect\Cards\Groups;

use JPeters\Architect\Cards\Card as ArchitectCard;

class Card extends ArchitectCard
{
    public function vueComponent(): string
    {
        return 'groups-card';
    }

    public function modelParameters(): array
    {
        return [];
    }
}
