<?php

use Phinx\Migration\AbstractMigration;

class InitMigration extends AbstractMigration
{

    public function change()
    {
        $game = $this->table('game');
        $game
            ->addColumn('user', 'string', ['limit' => 255])
            ->addTimestamps('start', 'end')
            ->addColumn('position', 'string', ['limit' => 4096])
            ->create();

        $result = $this->table('result');
        $result
            ->addColumn('user', 'string', ['limit' => 255])
            ->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('time', 'time')
            ->create();
    }
}
