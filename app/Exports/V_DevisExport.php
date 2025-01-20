<?php

namespace App\Exports;

use App\Models\views\V_Devis;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class V_DevisExport implements FromView
{
    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    /**
    * @return \Illuminate\Support\Collection
    */

    /*
    public function collection()
    {
        return V_Devis::all();
    }
     */

    /**
     * @return View
     */
    public function view(): View
    {
        // TODO: Implement view() method.
        return view('orders', [
           'data' => $this->data
        ]);
    }
}
