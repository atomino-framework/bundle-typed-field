<?php namespace Atomino\Carbon\Plugins\JSON;

use Atomino\Carbon\Attributes\EventHandler;
use Atomino\Carbon\Entity;
use Atomino\Carbon\Model;

/**
 * @method static Model model()
 */
trait JSONFieldTrait {
    #[EventHandler(Entity::EVENT_ON_LOAD)]
    protected function JsonFieldTrait_onLoad($event, $data) {
        foreach ($this->JsonFieldTrait_fetchPluginList() as $plugin) {
            $this->{$plugin->targetField} = $plugin->targetClass::fromArray($this->{$plugin->sourceField});
        }
    }

    #[EventHandler(Entity::EVENT_BEFORE_INSERT, Entity::EVENT_BEFORE_UPDATE)]
    protected function JsonFieldTrait_BeforeInsert($event, $data) {
        foreach ($this->JsonFieldTrait_fetchPluginList() as $plugin) {
            $this->{$plugin->sourceField} = $this->{$plugin->targetField}->toArray();
        }
    }

    /**
     * @return JSONField[]
     */
    private function JsonFieldTrait_fetchPluginList(): array {
        return is_array($plugins = JSONField::fetch(static::model())) ? $plugins : [$plugins];
    }
}