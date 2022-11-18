<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;

class InvoiceExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Invoice::all();
//        return Invoice::select('invoice_number','invoice_date','due_date','discount','value_vat','rate_vat','total')->get();
    }
}
