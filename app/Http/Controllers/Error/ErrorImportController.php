<?php

namespace App\Http\Controllers\Error;

use App\Http\Controllers\Controller;
use App\Models\error\ErrorImport;
use Illuminate\Http\Request;

class ErrorImportController extends Controller
{
    //
    public function showCaErrorImports()
    {
        $data['errors'] = ErrorImport::where('type', 2)
            ->paginate(30);
        return view('error/erreur-import-ca')->with($data);
    }
    public function showDevisErrorImports()
    {
        $data['errors'] = ErrorImport::where('type', 1)
            ->paginate(30);
        return view('error/erreur-import-devis')->with($data);
    }
}
