<?php
/**
 * Inline Icons module for Craft CMS 3.x
 *
 * A Twig helper for SVG icons
 *
 * @link      https://github.com/pieterbeulque
 * @copyright Copyright (c) 2018 Pieter Beulque
 */

namespace gentsagency\inlineicons;

use gentsagency\inlineicons\twigextensions\InlineIconsTwigExtension;

use Craft;
use craft\events\RegisterTemplateRootsEvent;
use craft\events\TemplateEvent;
use craft\i18n\PhpMessageSource;
use craft\web\View;

use yii\base\Event;
use yii\base\InvalidConfigException;
use yii\base\Module;

/**
 * Class InlineIcons
 *
 * @author    Pieter Beulque
 * @package   InlineIcons
 * @since     1.0.0
 *
 */
class InlineIcons extends Module
{
    // Static Properties
    // =========================================================================

    /**
     * @var InlineIcons
     */
    public static $instance;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function __construct($id, $parent = null, array $config = [])
    {
        Craft::setAlias('@modules/InlineIcons', $this->getBasePath());

        // Set this as the global instance of this module class
        static::setInstance($this);

        parent::__construct($id, $parent, $config);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$instance = $this;

        Craft::$app->view->registerTwigExtension(new InlineIconsTwigExtension());
    }
}
