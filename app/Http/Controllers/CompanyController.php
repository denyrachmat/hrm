<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Http\Requests\{StoreCompanyRequest, UpdateCompanyRequest};
use Yajra\DataTables\Facades\DataTables;
use Image;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:company view')->only('index');
        $this->middleware('permission:company edit')->only('update');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = Company::findOrFail(1)->first();
        return view('companies.edit', compact('company'));
    }

    public function view(){
        $company = Company::findOrFail(1);
        return response()->json([
            'code' => 200,
            'data' => $company,
            'msg' => 'Berhasil, Data Perusahaan Berhasil Diambil'
        ], 200);
    }

    public function update(UpdateCompanyRequest $request, Company $company)
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
            if ($company->logo != null && file_exists($path . $company->logo)) {
                unlink($path . $company->logo);
            }

            $attr['logo'] = $filename;
        }

        $company->update($attr);

        return redirect()
            ->route('companies.index')
            ->with('success', __('The company was updated successfully.'));
    }
}
