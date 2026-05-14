<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBankRequest;
use App\Http\Requests\UpdateBankRequest;
use App\Models\Bank;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Image;

class BankController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:bank view')->only('index', 'show');
        $this->middleware('permission:bank create')->only('create', 'store');
        $this->middleware('permission:bank edit')->only('edit', 'update');
        $this->middleware('permission:bank delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $banks = Bank::query();

            return DataTables::of($banks)

                ->addColumn('logo', function ($row) {
                    if ($row->logo == null) {
                        return 'https://via.placeholder.com/350?text=No+Image+Avaiable';
                    }
                    return asset('storage/uploads/logos/' . $row->logo);
                })

                ->addColumn('action', 'banks.include.action')
                ->toJson();
        }

        return view('banks.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('banks.create');
    }

    public function store(StoreBankRequest $request)
    {
        $attr = $request->validated();

        if ($request->file('logo') && $request->file('logo')->isValid()) {

            $path = storage_path('app/public/uploads/logos/');
            $filename = $request->file('logo')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            Image::make($request->file('logo')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            })->save($path . $filename);

            $attr['logo'] = $filename;
        }

        Bank::create($attr);

        return redirect()
            ->route('banks.index')
            ->with('success', __('The bank was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bank $bank
     * @return \Illuminate\Http\Response
     */
    public function show(Bank $bank)
    {
        return view('banks.show', compact('bank'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bank $bank
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        return view('banks.edit', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bank $bank
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBankRequest $request, Bank $bank)
    {
        $attr = $request->validated();

        if ($request->file('logo') && $request->file('logo')->isValid()) {

            $path = storage_path('app/public/uploads/logos/');
            $filename = $request->file('logo')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            Image::make($request->file('logo')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            })->save($path . $filename);

            // delete old logo from storage
            if ($bank->logo != null && file_exists($path . $bank->logo)) {
                unlink($path . $bank->logo);
            }

            $attr['logo'] = $filename;
        }

        $bank->update($attr);

        return redirect()
            ->route('banks.index')
            ->with('success', __('The bank was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bank $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        try {
            $path = storage_path('app/public/uploads/logos/');

            if ($bank->logo != null && file_exists($path . $bank->logo)) {
                unlink($path . $bank->logo);
            }

            $bank->delete();

            return redirect()
                ->route('banks.index')
                ->with('success', __('The bank was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('banks.index')
                ->with('error', __("The bank can't be deleted because it's related to another table."));
        }
    }
}
