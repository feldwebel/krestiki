<?php

class StartAction implements IAction {

    public function execute(HttpRequest $request)
    {
        $position = $this->getInitPosition();

        $result =
            (new GameModel())
                ->beginGame($request->getOrElse('user'), $position);

        return new HttpResponse('lets start', $position);
    }

    private function getInitPosition()
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
