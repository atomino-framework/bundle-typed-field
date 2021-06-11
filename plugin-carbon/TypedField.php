<?php namespace Atomino\Carbon\Plugins\TypedField;

use Atomino\Carbon\Generator\CodeWriter;
use Atomino\Carbon\Plugin\Plugin;
use Atomino\Bundle\TypedField\TypeInterface;
use Attribute;
use InvalidArgumentException;
use ReflectionClass;

/**
 * Appends $targetField as a mutable public property that contains an instance of $targetClass
 * populated with values from $sourceField.
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class TypedField extends Plugin {
    public string $sourceField;

	public function __construct(
        public string $targetField,
	    public string|TypeInterface $targetClass,
	    string $sourceField = null,
    ) {
	    if (!is_a($this->targetClass, TypeInterface::class, true)) {
	        throw new InvalidArgumentException(sprintf(
	            'Unsupported value class %s. Value class must implement %s',
                $this->targetClass,
                TypeInterface::class
            ));
        }

        $this->sourceField = $sourceField ?? $this->targetField . 'Data';
    }

	public function generate(ReflectionClass $entityReflection, CodeWriter $codeWriter) {
        $codeWriter->addAttribute("#[RequiredField( '" . $this->sourceField . "', \Atomino\Carbon\Field\JsonField::class )]");
        $codeWriter->addCode("public \\".$this->targetClass." $".$this->targetField . ';');
    }

	public function getTrait(): string|null { return TypedFieldTrait::class; }
}
