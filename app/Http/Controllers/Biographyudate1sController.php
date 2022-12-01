<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Biographyudate1sFormRequest;
use App\Models\Biographyudate1;
use Exception;

class Biographyudate1sController extends Controller
{

    /**
     * Display a listing of the biographyudate1s.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $biographyudate1s = Biographyudate1::paginate(15);

        return view('biographyudate1s.admin.index', compact('biographyudate1s'));
    }

    /**
     * Show the form for creating a new biographyudate1.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('biographyudate1s.admin.create');
    }

    /**
     * Store a new biographyudate1 in the storage.
     *
     * @param App\Http\Requests\Biographyudate1sFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Biographyudate1sFormRequest $request)
    {
        try {
            
            $data = $request->getData();
            
            Biographyudate1::create($data);

            return redirect()->route('biographyudate1s.biographyudate1.index')
                ->with('success_message', 'Biographyudate1 was successfully added.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Display the specified biographyudate1.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $biographyudate1 = Biographyudate1::findOrFail($id);

        return view('biographyudate1s.admin.show', compact('biographyudate1'));
    }

    /**
     * Show the form for editing the specified biographyudate1.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $biographyudate1 = Biographyudate1::findOrFail($id);
        

        return view('biographyudate1s.admin.edit', compact('biographyudate1'));
    }

    /**
     * Update the specified biographyudate1 in the storage.
     *
     * @param int $id
     * @param App\Http\Requests\Biographyudate1sFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Biographyudate1sFormRequest $request)
    {
        try {
            
            $data = $request->getData();
            
            $biographyudate1 = Biographyudate1::findOrFail($id);
            $biographyudate1->update($data);

            return redirect()->route('biographyudate1s.biographyudate1.index')
                ->with('success_message', 'Biographyudate1 was successfully updated.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }        
    }

    /**
     * Remove the specified biographyudate1 from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $biographyudate1 = Biographyudate1::findOrFail($id);
            $biographyudate1->delete();

            return redirect()->route('biographyudate1s.biographyudate1.index')
                ->with('success_message', 'Biographyudate1 was successfully deleted.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }



}
