<?php

declare(strict_types=1);

namespace aieuo\mineflow\flowItem\action\inventory;

use aieuo\mineflow\flowItem\FlowItemExecutor;

class AddItem extends TypeItem {

    protected $id = self::ADD_ITEM;

    protected $name = "action.addItem.name";
    protected $detail = "action.addItem.detail";

    public function execute(FlowItemExecutor $source): \Generator {
        $this->throwIfCannotExecute();

        $item = $this->getItem($source);

        $player = $this->getPlayer($source);
        $this->throwIfInvalidPlayer($player);

        $player->getInventory()->addItem($item);
        yield true;
    }
}