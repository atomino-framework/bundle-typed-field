<?php namespace Atomino\Carbon\Plugins\JSON;

use Atomino\Carbon\Generator\CodeWriter;
use Attribute;
use ReflectionClass;

/**
 * Class JsonFieldField
 *
 * Appends $targetField as a mutable public property that contains a list of instances of $targetClass
 * populated with JSON decoded data from $sourceField.
 *
 * @package Atomino\Carbon\Plugins\JSON
 */
#[Attribute(Attribute::TARGET_CLASS + Attribute::IS_REPEATABLE)]
class JSONListField extends JSONField {
    public function generate(ReflectionClass $entityReflection, CodeWriter $codeWriter) {
        $codeWriter->addAttribute("#[RequiredField( '" . $this->sourceField . "', \Atomino\Carbon\Field\JsonField::class )]");
        $codeWriter->addCode("/** @var \\".$this->targetClass."[] */");
        $codeWriter->addCode("public array $".$this->targetField . ';');
    }

	public function getTrait(): string|null { return JSONListFieldTrait::class; }
}