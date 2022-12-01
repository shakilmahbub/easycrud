<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Biography09sFormRequest;
use App\Models\Biography09;
use Exception;

class Biography09sController extends Controller
{

    /**
     * Display a listing of the biography09s.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $biography09s = Biography09::paginate(15);

        return view('biography09s.index', compact('biography09s'));
    }

    /**
     * Show the form for creating a new biography09.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('biography09s.create');
    }

    /**
     * Store a new biography09 in the storage.
     *
     * @param App\Http\Requests\Biography09sFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Biography09sFormRequest $request)
    {
        try {
            
            $data = $request->getData();
            
            Biography09::create($data);

            return redirect()->route('biography09s.biography09.index')
                ->with('success_message', 'Biography09 was successfully added.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Display the specified biography09.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $biography09 = Biography09::findOrFail($id);

        return view('biography09s.show', compact('biography09'));
    }

    /**
     * Show the form for editing the specified biography09.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $biography09 = Biography09::findOrFail($id);
        

        return view('biography09s.edit', compact('biography09'));
    }

    /**
     * Update the specified biography09 in the storage.
     *
     * @param int $id
     * @param App\Http\Requests\Biography09sFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Biography09sFormRequest $request)
    {
        try {
            
            $data = $request->getData();
            
            $biography09 = Biography09::findOrFail($id);
            $biography09->update($data);

            return redirect()->route('biography09s.biography09.index')
                ->with('success_message', 'Biography09 was successfully updated.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }        
    }

    /**
     * Remove the specified biography09 from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $biography09 = Biography09::findOrFail($id);
            $biography09->delete();

            return redirect()->route('biography09s.biography09.index')
                ->with('success_message', 'Biography09 was successfully deleted.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }



}
