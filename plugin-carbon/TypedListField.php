<?php namespace Atomino\Carbon\Plugins\TypedField;

use Atomino\Carbon\Generator\CodeWriter;
use Attribute;
use ReflectionClass;

/**
 * Appends $targetField as a mutable public property that contains a list of instances of $targetClass
 * populated with values from $sourceField.
 */
#[Attribute(Attribute::TARGET_CLASS + Attribute::IS_REPEATABLE)]
class TypedListField extends TypedField {
    public function generate(ReflectionClass $entityReflection, CodeWriter $codeWriter) {
        $codeWriter->addAttribute("#[RequiredField( '" . $this->sourceField . "', \Atomino\Carbon\Field\JsonField::class )]");
        $codeWriter->addCode("/** @var \\".$this->targetClass."[] */");
        $codeWriter->addCode("public array $".$this->targetField . ';');
    }

	public function getTrait(): string|null { return TypedListFieldTrait::class; }
}
