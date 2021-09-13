<?php

namespace craft\conditions\elements;

use Craft;
use craft\conditions\BaseConditionRule;
use craft\conditions\BaseLightswitchConditionRule;
use craft\elements\db\ElementQuery;
use craft\elements\Entry;
use yii\db\QueryInterface;

/**
 * Element trashed condition rule.
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since 4.0.0
 */
class RelatedToConditionRule extends BaseConditionRule implements ElementQueryConditionRuleInterface
{
    /**
     * @var array
     */
    private array $_elementIds = [];

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('app', 'Related to');
    }

    /**
     * @param $value
     */
    public function setElementIds($value): void
    {
        if (!is_array($value)) {
            $value = [];
        }

        $this->_elementIds = $value;
    }

    public function getElementIds()
    {
        return $this->_elementIds;
    }

    /**
     * @inheritdoc
     */
    public function modifyQuery(QueryInterface $query): void
    {
        /** @var ElementQuery $query */
        $query->relatedTo((bool)$this->elementIds);
    }

    /**
     * @inheritdoc
     */
    public function getConfig(): array
    {
        return array_merge(parent::getConfig(), [
            'elementIds' => $this->elementIds
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getHtml(array $options = []): string
    {

        $id = Craft::$app->getView()->namespaceInputId('relatedTo');

        $html = Craft::$app->getView()->renderTemplate('_includes/forms/elementSelect', [
            'name' => 'elementIds',
            'elements' => $this->elementIds,
            'elementType' => Entry::class
        ]);

        return $html;
    }

    /**
     * @inheritdoc
     */
    public function defineRules(): array
    {
        return array_merge(parent::defineRules(), [
            [['elementIds'], 'safe'],
        ]);
    }
}
