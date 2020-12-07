<?php


namespace Documentor\Service;
use Documentor\Service\TwigRender;
use Documentor\Service\CsvRender;
use Documentor\Service\XmlRender;
use Documentor\Service\JsonRender;


class RenderFactory
{
    public static function defineRenderer($outputFormat)
    {
        switch ($outputFormat){
            case 'html':
                return new TwigRender(
                __DIR__ . '/../../templates',
                __DIR__ . '/../../reports/'
            );
            case 'csv':
                return new CsvRender(__DIR__ . '/../../reports/');
            case 'xml':
                return new XmlRender(__DIR__ . '/../../reports/');
            case 'json':
                return new JsonRender(__DIR__ . '/../../reports/');

        }
    }
}