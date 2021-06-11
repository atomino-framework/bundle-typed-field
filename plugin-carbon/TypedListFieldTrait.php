<?php namespace Atomino\Carbon\Plugins\TypedField;

use Atomino\Carbon\Attributes\EventHandler;
use Atomino\Carbon\Entity;
use Atomino\Carbon\Model;

/**
 * @method static Model model()
 */
trait TypedListFieldTrait {
    #[EventHandler(Entity::EVENT_ON_LOAD)]
    protected function TypedListFieldTrait_onLoad() {
        foreach ($this->TypedListFieldTrait_fetchPluginList() as $plugin) {
            $this->{$plugin->targetField} = [];
            foreach (($this->{$plugin->sourceField} ?: []) as $key => $value) {
                $this->{$plugin->targetField}[$key] = $plugin->targetClass::fromArray($value);
            }
        }
    }

    #[EventHandler(Entity::EVENT_BEFORE_INSERT, Entity::EVENT_BEFORE_UPDATE)]
    protected function TypedListFieldTrait_BeforeInsert() {
        foreach ($this->TypedListFieldTrait_fetchPluginList() as $plugin) {
            $this->{$plugin->sourceField} = [];
            foreach (($this->{$plugin->targetField} ?? []) as $key => $value) {
                $this->{$plugin->sourceField}[$key] = $value->toArray();
            }
        }
    }

    /**
     * @return TypedField[]
     */
    private function TypedListFieldTrait_fetchPluginList(): array {
        return is_array($plugins = TypedListField::fetch(static::model())) ? $plugins : [$plugins];
    }
}
