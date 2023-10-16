<?php

namespace App\Helper;

class UniqueCharacters
{
    private array $items;

    public function __construct($items = [])
    {
        $this->items = $items;
    }

    public function uniqueCharacters(): array
    {
        $collection = collect($this->items);
        $duplicatesCharacters = $collection->duplicates();
        $uniqueCharacters = $collection->unique()->values();
        $differenceCharacters = $uniqueCharacters->diff($duplicatesCharacters);

        return collect($differenceCharacters)->values()->all();
    }

    public function numberUniqueCharacters(): int
    {
        return count($this->uniqueCharacters());
    }
}
