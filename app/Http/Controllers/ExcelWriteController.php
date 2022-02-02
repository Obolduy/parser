<?php

namespace App\Http\Controllers;

class ExcelWriteController extends Controller
{
    private $excel, $writer, $sheet, $columns, $header_columns;

    public function __construct(\PHPExcel $excel)
    {
        $this->excel = $excel;
        $this->excel->setActiveSheetIndex(0);

        $this->sheet = $excel->getActiveSheet();

        $this->writer = new \PHPExcel_Writer_Excel5($this->excel);
    }

    public function setColumnsHeaders(array $columns): void
    {
        $this->setColumns($columns);

        foreach ($this->columns as $key => $elem) {
            $this->header_columns[$key.'1'] = $elem;
        }

        foreach ($this->header_columns as $name => $value) {
            $this->sheet->setCellValue($name, $value);
        }

        $first_column = array_key_first($this->header_columns);
        $last_column = array_key_last($this->header_columns);

        $this->sheet->getStyle($first_column.':'.$last_column)->getFont()->setBold(true);
    }

    public function fillSheet(PageController $page): void
    {
        foreach ($page as $key => $column) {
            $column_letter = array_key_first($this->columns);
            array_shift($this->columns);

            $startColumn = 2;

            for ($i = 0; $i < count($column); $i++) {
                $full_column_name = $column_letter . $startColumn++;
                $this->sheet->setCellValue($full_column_name, $column[$i]);
            }
        }
    }

    public function completeTable(string $path): void
    {
        @$this->writer->save($path);
    }

    private function setColumns(array $columns): void
    {
        $this->columns = $columns;
    }
}