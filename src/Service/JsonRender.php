<?php


namespace Documentor\Service;


class JsonRender implements RenderInterface
{
    private string $reportsDir;

    public function __construct(string $reportsDir)
    {
        $this->reportsDir = $reportsDir;
    }

    public function render(array $data)
    {
        file_put_contents($this->reportsDir . time() . '.json',json_encode($data));
    }
}