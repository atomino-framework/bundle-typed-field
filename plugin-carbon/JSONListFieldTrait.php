<?php namespace Atomino\Carbon\Plugins\JSON;

use Atomino\Carbon\Attributes\EventHandler;
use Atomino\Carbon\Entity;
use Atomino\Carbon\Model;

/**
 * @method static Model model()
 */
trait JSONListFieldTrait {
    #[EventHandler(Entity::EVENT_ON_LOAD)]
    protected function JsonListFieldTrait_onLoad($event, $data) {
        foreach ($this->JsonListFieldTrait_fetchPluginList() as $plugin) {
            $this->{$plugin->targetField} = [];
            foreach (($this->{$plugin->sourceField} ?: []) as $key => $value) {
                $this->{$plugin->targetField}[$key] = $plugin->targetClass::fromArray($value);
            }
        }
    }

    #[EventHandler(Entity::EVENT_BEFORE_INSERT, Entity::EVENT_BEFORE_UPDATE)]
    protected function JsonListFieldTrait_BeforeInsert($event, $data) {
        foreach ($this->JsonListFieldTrait_fetchPluginList() as $plugin) {
            $this->{$plugin->sourceField} = [];
            foreach (($this->{$plugin->targetField} ?? []) as $key => $value) {
                $this->{$plugin->sourceField}[$key] = $value->toArray();
            }
        }
    }

    /**
     * @return JSONField[]
     */
    private function JsonListFieldTrait_fetchPluginList(): array {
        return is_array($plugins = JSONListField::fetch(static::model())) ? $plugins : [$plugins];
    }
}