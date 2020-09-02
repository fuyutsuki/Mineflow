<?php

namespace aieuo\mineflow\flowItem\condition;

use aieuo\mineflow\flowItem\FlowItemContainer;
use aieuo\mineflow\recipe\Recipe;

class NandScript extends AndScript {

    protected $id = self::CONDITION_NAND;

    protected $name = "condition.nand.name";
    protected $detail = "condition.nand.detail";

    public function getDetail(): string {
        $details = ["-----------nand-----------"];
        foreach ($this->getItems(FlowItemContainer::CONDITION) as $condition) {
            $details[] = $condition->getDetail();
        }
        $details[] = "------------------------";
        return implode("\n", $details);
    }

    public function execute(Recipe $origin) {
        return !(yield from parent::execute($origin));
    }
}