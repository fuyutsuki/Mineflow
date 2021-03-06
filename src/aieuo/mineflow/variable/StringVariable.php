<?php

namespace aieuo\mineflow\variable;

use aieuo\mineflow\exception\UnsupportedCalculationException;

class StringVariable extends Variable implements \JsonSerializable {

    public $type = Variable::STRING;

    public function getValue(): string {
        return parent::getValue();
    }

    public function append(StringVariable $var): StringVariable {
        $result = $this->getValue().$var->getValue();
        return new StringVariable($result);
    }

    public function replace(StringVariable $var): StringVariable {
        $result = str_replace($var->getValue(), "", $this->getValue());
        return new StringVariable($result);
    }

    public function repeat(StringVariable $var): StringVariable {
        $result = str_repeat($this->getValue(), (int)$var->getValue());
        return new StringVariable($result);
    }

    public function split(StringVariable $var): ListVariable {
        $result = array_map(function (string $text) {
            return new StringVariable(trim($text));
        }, explode($var->getValue(), $this->getValue()));
        return new ListVariable($result);
    }

    public function add($target): Variable {
        return new StringVariable($this->getValue().$target);
    }

    public function sub($target): Variable {
        return new StringVariable(str_replace((string)$target, "", $this->getValue()));
    }

    public function mul($target): Variable {
        if ($target instanceof NumberVariable) $target = $target->getValue();
        if(is_numeric($target)) new StringVariable(str_repeat($this->getValue(), (int)$target));

        throw new UnsupportedCalculationException();
    }

    public function jsonSerialize(): array {
        return [
            "type" => $this->getType(),
            "value" => $this->getValue(),
        ];
    }
}