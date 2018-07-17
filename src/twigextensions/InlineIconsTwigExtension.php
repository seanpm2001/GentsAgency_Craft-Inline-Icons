<?php
/**
 * Inline Icons module for Craft CMS 3.x
 *
 * A Twig helper for SVG icons
 *
 * @link      https://github.com/pieterbeulque
 * @copyright Copyright (c) 2018 Pieter Beulque
 */

namespace gentsagency\inlineicons\twigextensions;

use gentsagency\inlineicons\InlineIcons;

use Craft;

/**
 * @author    Pieter Beulque
 * @package   InlineIcons
 * @since     1.0.0
 */
class InlineIconsTwigExtension extends \Twig_Extension
{
    private $cachedDocuments = array();
    private $cachedSVG = array();

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'InlineIcons';
    }

    /**
     * @inheritdoc
     */
    public function getFilters()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'icon',
                [$this, 'icon'],
                array(
                    'is_safe' => array('html'),
                )
            ),
        ];
    }

    /**
     * @param null $icon
     * @param array $options
     *
     * @return string
     */
    public function icon($icon, $options = array())
    {
        $class = !empty($options['class']) ? $options['class'] : 'icon';
        $inline = isset($options['inline']) ? (bool) $options['inline'] : false;
        $path = !empty($options['path']) ? $options['path'] : '/assets/icons/icons.svg';
        $alt = isset($options['alt']) ? $options['alt'] : $icon;
        $role = is_string($alt) ? 'image' : 'presentation';
        $titleid = uniqid('icon-'. $icon . '-label-');

        if ($inline) {
            $path = Craft::getAlias('@webroot') . $path;
            $svgCacheKey = $path . '#icon-' . $icon;

            if (isset($this->cachedSVG[$svgCacheKey])) {
                return $this->cachedSVG[$svgCacheKey];
            }

            if (isset($this->cachedDocuments[$path])) {
                $document = $this->cachedDocuments[$path];
            } else {
                $svg = @file_get_contents($path);
                $document = new \DOMDocument();
                @$document->loadXML($svg);
                $this->cachedDocuments[$path] = $document;
            }

            $symbols = $document->getElementsByTagName('symbol');

            for ($i = 0; $i < $symbols->count(); $i++) {
                $symbol = $symbols->item($i);

                if ($symbol->getAttribute('id') === 'icon-' . $icon) {
                    $viewBox = $symbol->getAttribute('viewBox');
                    $innerHTML = '';

                    $children = $symbol->childNodes;

                    foreach ($children as $child) {
                        $innerHTML .= $child->ownerDocument->saveXML($child);
                    }

                    $inlineSVG = '
                        <svg class="' . $class . '" focusable="false" aria-labelledby="' . $titleid . '" role="' . $role . '" viewBox=' . $viewBox .'>
                            <title id="' . $titleid . '">'. $alt . '</title>
                            ' . $innerHTML . '
                        </svg>
                    ';

                    $this->cachedSVG[$svgCacheKey] = $inlineSVG;

                    return $inlineSVG;
                }
            }
        }

        return '
            <svg class="' . $class . '" focusable="false" aria-labelledby="' . $titleid . '" role="' . $role . '">
                <title id="' . $titleid . '">'. $alt . '</title>
                <use xlink:href="' . $path . '#icon-' . strtolower($icon) .'"></use>
            </svg>
        ';
    }
}
