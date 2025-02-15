<?php
/**
 * @link https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license https://craftcms.github.io/license/
 */

namespace crafttests\unit\web\twig;

use Codeception\Test\Unit;
use Craft;
use craft\web\View;
use UnitTester;

/**
 * Unit tests for the Various functions in the Extension class.
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @author Global Network Group | Giel Tettelaar <giel@yellowflash.net>
 * @since 3.7.24
 */
class FieldTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @var View
     */
    protected $view;

    /**
     *
     */
    public function testBlocks(): void
    {
        $template = <<<TWIG
{% embed '_includes/forms/field' with {
  id: 'foo',
  labelId: 'label',
} %}
  {% block attr %}data-foo="test"{% endblock %}
  {% block heading %}TEST HEADING{{ parent() }}{% endblock %}
  {% block label %}TEST LABEL{% endblock %}
  {% block instructions %}<p>TEST INSTRUCTIONS</p>{% endblock %}
  {% block tip %}TEST TIP{% endblock %}
  {% block warning %}TEST WARNING{% endblock %}
  {% block input %}<input name="foo">{% endblock %}
{% endembed %}
TWIG;

        $html = $this->view->renderString($template, [], View::TEMPLATE_MODE_CP);
        $this->assertStringContainsString('<div id="foo-field" class="field" data-foo="test">', $html);
        $this->assertStringContainsString('TEST HEADING', $html);
        $this->assertStringContainsString('<label id="label" for="foo">TEST LABEL</label>', $html);
        $this->assertStringContainsString('<div id="foo-instructions" class="instructions"><p>TEST INSTRUCTIONS</p>', $html);
        $this->assertStringContainsString('<p id="foo-tip" class="notice"><span class="icon" aria-hidden="true"></span><span class="visually-hidden">Tip: </span>TEST TIP</p>', $html);
        $this->assertStringContainsString('<p id="foo-warning" class="warning"><span class="icon" aria-hidden="true"></span><span class="visually-hidden">Warning: </span>TEST WARNING</p>', $html);
        $this->assertStringContainsString('<input name="foo">', $html);
    }

    /**
     * @inheritdoc
     */
    protected function _before()
    {
        parent::_before();
        $this->view = Craft::$app->getView();
    }
}
