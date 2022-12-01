<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BiographiesFormRequest;
use App\Models\Biography;
use Exception;

class BiographiesController extends Controller
{

    /**
     * Display a listing of the biographies.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $biographies = Biography::paginate(15);

        return view('biographies.index', compact('biographies'));
    }

    /**
     * Show the form for creating a new biography.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('biographies.create');
    }

    /**
     * Store a new biography in the storage.
     *
     * @param App\Http\Requests\BiographiesFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(BiographiesFormRequest $request)
    {
        try {
            
            $data = $request->getData();
            
            Biography::create($data);

            return redirect()->route('biographies.biography.index')
                ->with('success_message', 'Biography was successfully added.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Display the specified biography.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $biography = Biography::findOrFail($id);

        return view('biographies.show', compact('biography'));
    }

    /**
     * Show the form for editing the specified biography.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $biography = Biography::findOrFail($id);
        

        return view('biographies.edit', compact('biography'));
    }

    /**
     * Update the specified biography in the storage.
     *
     * @param int $id
     * @param App\Http\Requests\BiographiesFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, BiographiesFormRequest $request)
    {
        try {
            
            $data = $request->getData();
            
            $biography = Biography::findOrFail($id);
            $biography->update($data);

            return redirect()->route('biographies.biography.index')
                ->with('success_message', 'Biography was successfully updated.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }        
    }

    /**
     * Remove the specified biography from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $biography = Biography::findOrFail($id);
            $biography->delete();

            return redirect()->route('biographies.biography.index')
                ->with('success_message', 'Biography was successfully deleted.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }



}
