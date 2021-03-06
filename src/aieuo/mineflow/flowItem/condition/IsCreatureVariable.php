<?php

namespace aieuo\mineflow\flowItem\condition;

use aieuo\mineflow\flowItem\FlowItemExecutor;
use pocketmine\entity\Creature;

class IsCreatureVariable extends IsActiveEntityVariable {

    protected $id = self::IS_CREATURE_VARIABLE;

    protected $name = "condition.isCreatureVariable.name";
    protected $detail = "condition.isCreatureVariable.detail";

    public function execute(FlowItemExecutor $source): \Generator {
        $this->throwIfCannotExecute();

        $entity = $this->getEntity($source);
        $this->throwIfInvalidEntity($entity);

        yield true;
        return $entity instanceof Creature;
    }
}