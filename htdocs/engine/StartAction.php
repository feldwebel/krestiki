<?php

class StartAction implements IAction {

    public function execute(HttpRequest $request) {
        $result =
            (new GameModel())
                ->beginGame($request->getOrElse('user'), $this->getPosition());

        return is_null($result) ? 'error' : 'lets start';
    }

    private function getPosition()
    {
        $result = [];
        for ($i = 0; $i < 20; $i++) {
            for ($j = 0; $j < 20; $j++) {
                $result[$i][$j] = 0;
            }
        }
        return serialize($result);
    }
}
