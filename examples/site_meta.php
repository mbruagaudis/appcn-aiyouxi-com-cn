<?php
/**
 * Site Meta Information Helper
 *
 * Provide basic metadata about the website, including supported areas,
 * content keywords, and a simple method to generate a short description.
 */

class SiteMetaHelper
{
    /**
     * @var array<string, mixed>
     */
    private array $metaData;

    /**
     * @param array<string, mixed> $initialData Optional initial meta data
     */
    public function __construct(array $initialData = [])
    {
        $defaultMeta = [
            'url'         => 'https://appcn-aiyouxi.com.cn',
            'siteName'    => '爱游戏',
            'keywords'    => ['爱游戏', '游戏资讯', '手游攻略'],
            'language'    => 'zh-CN',
            'charset'     => 'UTF-8',
            'description' => '专注于提供最新游戏动态与攻略',
        ];

        $this->metaData = array_merge($defaultMeta, $initialData);
    }

    /**
     * Set a specific meta field.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function set(string $key, $value): void
    {
        $this->metaData[$key] = $value;
    }

    /**
     * Get a specific meta field.
     *
     * @param string $key
     * @param mixed  $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $this->metaData[$key] ?? $default;
    }

    /**
     * Return a plain text description string based on current meta data.
     * The description will combine site name, keywords, and the primary URL.
     *
     * @param int $maxLength Maximum length for the description (optional)
     * @return string
     */
    public function generateShortDescription(int $maxLength = 160): string
    {
        $siteName  = $this->metaData['siteName'] ?? '';
        $keywords  = $this->metaData['keywords'] ?? [];
        $url       = $this->metaData['url'] ?? '';
        $desc      = $this->metaData['description'] ?? '';

        $keywordStr = implode('、', $keywords);

        $parts = [];
        if ($siteName !== '') {
            $parts[] = $siteName;
        }
        if ($keywordStr !== '') {
            $parts[] = $keywordStr;
        }
        if ($desc !== '') {
            $parts[] = $desc;
        }
        if ($url !== '') {
            $parts[] = '官网: ' . $url;
        }

        $fullText = implode(' — ', $parts);

        if (mb_strlen($fullText) > $maxLength) {
            $fullText = mb_substr($fullText, 0, $maxLength - 3) . '...';
        }

        return $fullText;
    }

    /**
     * Return an HTML-safe meta description tag string.
     *
     * @param int $maxLength
     * @return string
     */
    public function getMetaDescriptionTag(int $maxLength = 160): string
    {
        $safeDesc = htmlspecialchars($this->generateShortDescription($maxLength), ENT_QUOTES, 'UTF-8');
        return '<meta name="description" content="' . $safeDesc . '" />';
    }

    /**
     * Export all meta data as an associative array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->metaData;
    }
}

// ------------------------------------------------------------------
// Example usage (can be removed or kept as-is for demonstration)
// ------------------------------------------------------------------
$meta = new SiteMetaHelper();
$meta->set('keywords', ['爱游戏', '手游排行榜', '新游推荐']);
$meta->set('description', '每日更新最热手游资讯与深度评测');

echo $meta->generateShortDescription() . "\n";
echo $meta->getMetaDescriptionTag() . "\n";