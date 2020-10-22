<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\Dashboard\ChargingCodeStoreRequest;
use App\Http\Requests\Dashboard\ChargingCodeUpdateRequest;
use App\Models\ChargingCode;
use App\Traits\MoneyOperations\ChargingCodesFileTrait;
use App\Http\Controllers\Controller;

class ChargingCodeController extends Controller
{
    use ChargingCodesFileTrait;

    public function __construct()
    {
        $this->authorizeResource(ChargingCode::class, 'charging_code');
    }

    public function index()
    {
        return view('dashboard.charging-codes.index')
            ->with('chargingCodes', ChargingCode::orderBy('id', 'desc')->paginate())
            ->with('total', ChargingCode::count())
            ->with('indexUrl', route('dashboard.charging-codes.index'));
    }

    public function create()
    {
        return view('dashboard.charging-codes.create');
    }

    public function store(ChargingCodeStoreRequest $request)
    {
        $fileContent = '';
        for ($i = 0; $i < $request['count']; $i++) {

            $chargingCode = ChargingCode::create([
                'expires_at' => $request['expires_at'],
                'money' => $request['money'],
            ]);
            $fileContent .= $chargingCode->code . "\r\n";
        }

        $this->storeNewFile($fileContent, $request['count'], $request['money'], $request['expires_at']);

        return redirect()->route('dashboard.charging-codes.index')
            ->with('message', $request['count'] . ' generated successfully')->with('class', 'alert-success');
    }

    public function show(ChargingCode $chargingCode)
    {
        return redirect()->route('dashboard.charging-codes.edit', $chargingCode['id']);
    }

    public function edit(ChargingCode $chargingCode)
    {
        return view('dashboard.charging-codes.edit')
            ->with('chargingCode', $chargingCode);
    }

    public function update(ChargingCodeUpdateRequest $request, ChargingCode $chargingCode)
    {
        $chargingCode->update($request->validated());
        return redirect()->route('dashboard.charging-codes.index')
            ->with('message', 'charging Code updated successfully')->with('class', 'alert-success');
    }

    public function destroy(ChargingCode $chargingCode)
    {
        try {
            $chargingCode->delete();
            return response()->json(['message' => 'Deleted Successfully'], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception], 400);
        }
    }

}
