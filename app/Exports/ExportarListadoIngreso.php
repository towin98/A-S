<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Http\Controllers\Utilities\ExportsDataTrait;
use Maatwebsite\Excel\Concerns\{
    FromQuery,
    WithColumnFormatting,
    WithEvents,
    WithMapping,
    WithHeadings,
    WithStrictNullComparison,
    WithStyles
};

class exportarListadoIngreso implements
    FromQuery,
    WithMapping,
    WithHeadings,
    WithColumnFormatting,
    WithStrictNullComparison,
    WithEvents,
    WithStyles
{
    use ExportsDataTrait;

    public function styles(Worksheet $sheet)
    {
        return $this->stile($sheet);
    }
    public function registerEvents(): array
    {
        return $this->events();
    }
    public function columnFormats(): array
    {
        return $this->format();
    }
    public function headings(): array
    {
        return [
            'Numero de referencia',
            'Fecha de recepción',
            'Fecha de entrega',
            'Nombre de encargado',
            'Cargo',
            'Numero de contacto ',
            'Correo de contacto',
            'Nombre del cliente',
            'Categoría',
            'SubCategoría',
            'Unidad de medida',
            'Cantidad de medida'
        ];
    }
    public function map($row): array
    {
        //Para filtrar solo los campos que solo nesecita para el excel
        return [
            $row->userEmploymentSituation['user'][0]['full_name'],
            $row->userEmploymentSituation['user'][0]['certification_number'],
            $row->userEmploymentSituation['user'][0]['cell_phone_number'],
            $row->company_name,
            $row->economicSector['industry_name'],
            $row->city['name'],
            $row['company_management'],
            $row['phone_number'],
            $row->employeeCharges['job_title'],
            $row['corresponds_program'],
            $row->salarie['amount_income'],
            $row['created_at']->format('d/m/Y'),

        ];
    }
    public function query()
    {
        //   return $this->getDataEmployee();
    }
}
