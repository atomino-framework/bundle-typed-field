<?php namespace Atomino\Molecules\EntityPlugin\JSON;

use Atomino\Entity\Generator\CodeWriter;
use Atomino\Entity\Plugin\Plugin;

/**
 * Class JsonField
 *
 * Appends $targetField as a mutable public property that contains an instance of $targetClass
 * populated with JSON decoded data from $sourceField.
 *
 * @package Atomino\Molecules\EntityPlugin\JSON
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
class JSONField extends Plugin {
    public string $sourceField;

	public function __construct(
        public string $targetField,
	    public string|JSONFieldValueInterface $targetClass,
	    string $sourceField = null,
    ) {
	    if (!is_a($this->targetClass, JSONFieldValueInterface::class, true)) {
	        throw new \InvalidArgumentException(sprintf(
	            'Unsupported value class %s. Value class must implement %s',
                $this->targetClass,
                JSONFieldValueInterface::class
            ));
        }

        $this->sourceField = $sourceField ?? $this->targetField . 'Data';
    }

	public function generate(\ReflectionClass $entityReflection, CodeWriter $codeWriter) {
        $codeWriter->addAttribute("#[RequiredField( '" . $this->sourceField . "', \Atomino\Entity\Field\JsonField::class )]");
        $codeWriter->addCode("public \\".$this->targetClass." $".$this->targetField . ';');
    }

	public function getTrait(): string|null { return JSONFieldTrait::class; }
}