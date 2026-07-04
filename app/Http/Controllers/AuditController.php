<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        if ($this->shouldReturnJson($request)) {
            return response()->json(
                AuditLog::with('user')->orderBy('id', 'desc')->paginate(50)
            );
        }

        return view('auditoria');
    }
}
