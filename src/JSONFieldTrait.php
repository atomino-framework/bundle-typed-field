<?php namespace Atomino\Molecules\EntityPlugin\JSON;

use Atomino\Entity\Attributes\EventHandler;
use Atomino\Entity\Entity;
use Atomino\Entity\Model;

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