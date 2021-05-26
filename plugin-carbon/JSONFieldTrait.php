<?php namespace Atomino\Carbon\Plugins\JSON;

use Atomino\Carbon\Attributes\EventHandler;
use Atomino\Carbon\Entity;
use Atomino\Carbon\Model;

/**
 * @method static Model model()
 */
trait JSONFieldTrait {
    #[EventHandler(Entity::EVENT_ON_LOAD)]
    protected function JsonSubFieldTrait_onLoad($event, $data) {
        $model = JSONField::fetch(static::model());
        $this->{$model->targetField} = $model->targetClass::fromArray($this->{$model->sourceField});
    }

    #[EventHandler(Entity::EVENT_BEFORE_INSERT, Entity::EVENT_BEFORE_UPDATE)]
    protected function JsonSubFieldTrait_BeforeInsert($event, $data){
        $model = JSONField::fetch(static::model());

        $this->{$model->sourceField} = $this->{$model->targetField}->toArray();
    }
}