<?php


namespace Documentor\Service;


class CsvRender implements RenderInterface
{
    private $reportsDir;

    public function __construct(string $reportsDir)
    {
        $this->reportsDir = $reportsDir;
    }

    public function render(array $data)
    {
        $fp = fopen($this->reportsDir . time(). '.csv', 'w');
        $prepared_data = [];
        //название класса и инфо с докблока
        $prepared_data[] = ['class_name','class_data'];
        $prepared_data[] = [$data['class_name'],$data['class_data']['author'].' '.$data['class_data']['copyright']];
        $prepared_data[] = [];

        $methods = $data['methods'];
        $header = [];
        foreach ($methods[0] as $name => $value)
        {
            $header[] = $name;
        }

        $prepared_data[] = $header; //шапка таблицы с данными о методах
        //формируем строки с данными о методах
        foreach ($methods as $method)
        {
            $item = [];
            foreach ($method as $key => $value)
            {
                if (is_array($value))
                {
                    $item_in = [];
                    foreach ($value as $kk => $vv)
                    {
                        if (is_array($vv))
                        {
                            $item_in_in = [];
                            foreach ($vv as $k => $v)
                            {
                                $item_in_in[] = $v;
                            }
                            $item_in[] = implode(':',$item_in_in);
                        }
                        else
                        {
                            $item_in[] = $vv;
                        }
                    }
                    $item[] = implode(' ',$item_in);
                }
                else
                {
                    $item[] = $value;
                }
            }
            $prepared_data[] = $item;
        }
        //записываем данные в файл
        foreach ($prepared_data as $row) {
            fputcsv($fp, $row,';', '"');
        }
        fclose($fp);
    }
}