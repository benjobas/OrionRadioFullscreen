<?php

namespace App\Services\Parsers;

use App\Services\Parsers\Badge\NitroBadgeParser;

/**
 * @author iNicollas <inicollas>
 */
class ExternalTextsParser
{
    protected ?NitroBadgeParser $nitroParser = null;

    public function __construct() {
        $this->nitroParser = new NitroBadgeParser();
    }

    public function getBadgeData(string $badgeCode): array
    {
        return [
            'code' => $badgeCode,
            'image' => $this->getBadgeImageUrl($badgeCode),
            'nitro' => $this->nitroParser->getBadgeData($badgeCode),
        ];
    }

    public function getBadgeImageUrl(string $badgeCode): string
    {
        return sprintf('%s%s.gif', getSetting('badges_path'), $badgeCode);
    }

    public function updateNitroBadgeTexts(
        string $code,
        string $title,
        string $description
    ): void {
        $this->nitroParser->updateBadgeTexts($code, $title, $description);
    }

    

    public function getNitroParser(): ?NitroBadgeParser
    {
        return $this->nitroParser;
    }
}
