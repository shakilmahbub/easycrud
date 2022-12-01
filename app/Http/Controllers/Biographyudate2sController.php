<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Biographyudate2sFormRequest;
use App\Models\Biographyudate2;
use Exception;

class Biographyudate2sController extends Controller
{

    /**
     * Display a listing of the biographyudate2s.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $biographyudate2s = Biographyudate2::paginate(15);

        return view('biographyudate2s.admin.index', compact('biographyudate2s'));
    }

    /**
     * Show the form for creating a new biographyudate2.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('biographyudate2s.admin.create');
    }

    /**
     * Store a new biographyudate2 in the storage.
     *
     * @param App\Http\Requests\Biographyudate2sFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Biographyudate2sFormRequest $request)
    {
        try {
            
            $data = $request->getData();
            
            Biographyudate2::create($data);

            return redirect()->route('biographyudate2s.biographyudate2.index')
                ->with('success_message', 'Biographyudate2 was successfully added.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Display the specified biographyudate2.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $biographyudate2 = Biographyudate2::findOrFail($id);

        return view('biographyudate2s.admin.show', compact('biographyudate2'));
    }

    /**
     * Show the form for editing the specified biographyudate2.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $biographyudate2 = Biographyudate2::findOrFail($id);
        

        return view('biographyudate2s.admin.edit', compact('biographyudate2'));
    }

    /**
     * Update the specified biographyudate2 in the storage.
     *
     * @param int $id
     * @param App\Http\Requests\Biographyudate2sFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Biographyudate2sFormRequest $request)
    {
        try {
            
            $data = $request->getData();
            
            $biographyudate2 = Biographyudate2::findOrFail($id);
            $biographyudate2->update($data);

            return redirect()->route('biographyudate2s.biographyudate2.index')
                ->with('success_message', 'Biographyudate2 was successfully updated.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }        
    }

    /**
     * Remove the specified biographyudate2 from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $biographyudate2 = Biographyudate2::findOrFail($id);
            $biographyudate2->delete();

            return redirect()->route('biographyudate2s.biographyudate2.index')
                ->with('success_message', 'Biographyudate2 was successfully deleted.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }



}
