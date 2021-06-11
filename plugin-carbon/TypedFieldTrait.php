<?php namespace Atomino\Carbon\Plugins\TypedField;

use Atomino\Carbon\Attributes\EventHandler;
use Atomino\Carbon\Entity;
use Atomino\Carbon\Model;

/**
 * @method static Model model()
 */
trait TypedFieldTrait {
    #[EventHandler(Entity::EVENT_ON_LOAD)]
    protected function TypedFieldTrait_onLoad() {
        foreach ($this->TypedFieldTrait_fetchPluginList() as $plugin) {
            $this->{$plugin->targetField} = $plugin->targetClass::fromArray($this->{$plugin->sourceField});
        }
    }

    #[EventHandler(Entity::EVENT_BEFORE_INSERT, Entity::EVENT_BEFORE_UPDATE)]
    protected function TypedFieldTrait_BeforeInsert() {
        foreach ($this->TypedFieldTrait_fetchPluginList() as $plugin) {
            $this->{$plugin->sourceField} = $this->{$plugin->targetField}->toArray();
        }
    }

    /**
     * @return TypedField[]
     */
    private function TypedFieldTrait_fetchPluginList(): array {
        return is_array($plugins = TypedField::fetch(static::model())) ? $plugins : [$plugins];
    }
}
