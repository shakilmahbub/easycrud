<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BiographyudatesFormRequest;
use App\Models\Biographyudate;
use Exception;

class BiographyudatesController extends Controller
{

    /**
     * Display a listing of the biographyudates.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $biographyudates = Biographyudate::paginate(15);

        return view('biographyudates.admin.index', compact('biographyudates'));
    }

    /**
     * Show the form for creating a new biographyudate.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('biographyudates.admin.create');
    }

    /**
     * Store a new biographyudate in the storage.
     *
     * @param App\Http\Requests\BiographyudatesFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(BiographyudatesFormRequest $request)
    {
        try {
            
            $data = $request->getData();
            
            Biographyudate::create($data);

            return redirect()->route('biographyudates.biographyudate.index')
                ->with('success_message', 'Biographyudate was successfully added.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Display the specified biographyudate.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $biographyudate = Biographyudate::findOrFail($id);

        return view('biographyudates.admin.show', compact('biographyudate'));
    }

    /**
     * Show the form for editing the specified biographyudate.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $biographyudate = Biographyudate::findOrFail($id);
        

        return view('biographyudates.admin.edit', compact('biographyudate'));
    }

    /**
     * Update the specified biographyudate in the storage.
     *
     * @param int $id
     * @param App\Http\Requests\BiographyudatesFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, BiographyudatesFormRequest $request)
    {
        try {
            
            $data = $request->getData();
            
            $biographyudate = Biographyudate::findOrFail($id);
            $biographyudate->update($data);

            return redirect()->route('biographyudates.biographyudate.index')
                ->with('success_message', 'Biographyudate was successfully updated.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }        
    }

    /**
     * Remove the specified biographyudate from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $biographyudate = Biographyudate::findOrFail($id);
            $biographyudate->delete();

            return redirect()->route('biographyudates.biographyudate.index')
                ->with('success_message', 'Biographyudate was successfully deleted.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }



}
