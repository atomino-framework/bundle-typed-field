<?php namespace Atomino\Bundle\JSON;

interface JSONFieldValueInterface {
    /**
     * Instantiates the class based on the passed values.
     * Ideally `static::fromArray($this->toArray())->toArray() == $this->toArray()`
     * @see toArray()
     *
     * @param array $array
     *
     * @return static
     */
    public static function fromArray(array $array): static;

    /**
     * Converts this to its array representation.
     * Ideally `static::fromArray($this->toArray())->toArray() == $this->toArray()`
     * @see fromArray()
     *
     * @return array
     */
    public function toArray(): array;
}
