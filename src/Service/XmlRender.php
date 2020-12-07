<?php


namespace Documentor\Service;


class XmlRender implements RenderInterface
{
    private $reportsDir;

    public function __construct(string $reportsDir)
    {
        $this->reportsDir = $reportsDir;
    }

    public function render(array $data)
    {
        $dom = new \DomDocument('1.0');

        $class = $dom->appendChild($dom->createElement('class'));

        $class_name = $class->appendChild($dom->createElement('class_name'));
        $class_name->appendChild(
            $dom->createTextNode($data['class_name']));

        $class_data = $class->appendChild($dom->createElement('class_data'));
        $author = $class_data->appendChild($dom->createElement('author'));
        $author->appendChild(
            $dom->createTextNode($data['class_data']['author']));
        $copyright = $class_data->appendChild($dom->createElement('copyright'));
        $copyright->appendChild(
            $dom->createTextNode($data['class_data']['copyright']));

        $methods_tag = $class->appendChild($dom->createElement('methods'));

        $methods = $data['methods'];
        foreach ($methods as $one)
        {
            $method = $methods_tag->appendChild($dom->createElement($one['name']));

            foreach ($one['arguments'] as $argument)
            {
                $arg_name = $method->appendChild($dom->createElement('name'));
                $arg_name->appendChild(
                    $dom->createTextNode($argument['name']));

                $arg_type = $method->appendChild($dom->createElement('type'));
                $arg_type->appendChild(
                    $dom->createTextNode($argument['type']));
            }
            $return_type = $method->appendChild($dom->createElement('return_type'));
            $return_type->appendChild(
                $dom->createTextNode($one['return_type']));
        }

        $dom->formatOutput = true; // установка атрибута formatOutput
        // save XML as file
        $dom->save($this->reportsDir . time() . '.xml'); // сохранение файла
    }

}