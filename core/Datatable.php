<?php

namespace Core;

class Datatable
{
    public function datatable($col = false)
    {
        if (isset($_POST['start'])) {
            $row = $_POST['start'];
            $rowperpage = $_POST['length'];
            $columnIndex = $_POST['order'][0]['column'];
            $columnName = $_POST['columns'][$columnIndex]['data'];
            $columnSortOrder = $_POST['order'][0]['dir'];

            $retour = " order by " . $columnName . " " . $columnSortOrder;
            if ($col) $retour .= " , " . $col . " " . $columnSortOrder;
            if ($rowperpage != '-1')
                $retour .= " limit " . $row . "," . $rowperpage;
        } else $retour = '';

        return $retour;
    }

    public static function datatable_retour($total, $filtre, $retour, $autres = [])
    {
        return [
            "draw" => intval($_POST['draw']),
            "iTotalRecords" => $total,
            "iTotalDisplayRecords" => $filtre,
            "aaData" => $retour,
            "autres" => $autres
        ];
    }
}
