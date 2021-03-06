<?php

namespace aieuo\mineflow\variable;

class ListVariable extends Variable implements \JsonSerializable {

    public $type = Variable::LIST;

    /** @var string */
    private $showString;

    protected $value = [];

    /**
     * @return Variable[]
     */
    public function getValue(): array {
        return parent::getValue();
    }

    /**
     * @param Variable[] $value
     * @param string|null $str
     */
    public function __construct(array $value, ?string $str = "") {
        parent::__construct($value);
        $this->showString = $str;
    }

    public function appendValue(Variable $value): void {
        $this->value[] = $value;
    }

    /**
     * @param int|string $key
     * @param Variable $value
     */
    public function setValueAt($key, Variable $value): void {
        $this->value[(int)$key] = $value;
        $this->value = array_values($this->value);
    }

    public function removeValue(Variable $value): void {
        $index = array_search($value, $this->value, true);
        if ($index === false) return;
        unset($this->value[$index]);
        $this->value = array_merge($this->value);
    }

    public function getValueFromIndex(string $index): ?Variable {
        if (!isset($this->value[(int)$index])) return null;
        return $this->value[(int)$index];
    }

    public function callMethod(string $name, array $parameters = []): ?Variable {
        switch ($name) {
            case "count":
                return new NumberVariable(count($this->value));
        }
        return null;
    }

    public function getCount(): int {
        return count($this->value);
    }

    public function __toString(): string {
        if (!empty($this->getShowString())) return $this->getShowString();

        $values = [];
        foreach ($this->getValue() as $value) {
            $values[] = (string)$value;
        }
        return "[".implode(",", $values)."]";
    }

    public function getShowString(): string {
        return $this->showString;
    }

    public function jsonSerialize(): array {
        return [
            "type" => $this->getType(),
            "value" => $this->getValue(),
        ];
    }

    public function toArray(): array {
        $result = [];
        foreach ($this->getValue() as $i => $value) {
            if ($value instanceof ListVariable) $result[$i] = $value->toArray();
            else $result[$i] = (string)$value;
        }
        return $result;
    }
}