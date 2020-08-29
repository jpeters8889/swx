<?php

namespace App\Architect\Cards\MemberCancellations;

use JPeters\Architect\Cards\Card as ArchitectCard;

class Card extends ArchitectCard
{
    public function vueComponent(): string
    {
        return 'member-cancellations-card';
    }

    public function modelParameters(): array
    {
        return [];
    }
}
