<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestBiographiesFormRequest;
use App\Models\testBiography;
use Exception;

class TestBiographiesController extends Controller
{

    /**
     * Display a listing of the test biographies.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $testBiographies = testBiography::paginate(15);

        return view('test_biographies.index', compact('testBiographies'));
    }

    /**
     * Show the form for creating a new test biography.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('test_biographies.create');
    }

    /**
     * Store a new test biography in the storage.
     *
     * @param App\Http\Requests\TestBiographiesFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(TestBiographiesFormRequest $request)
    {
        try {
            
            $data = $request->getData();
            
            testBiography::create($data);

            return redirect()->route('test_biographies.test_biography.index')
                ->with('success_message', 'Test Biography was successfully added.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Display the specified test biography.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $testBiography = testBiography::findOrFail($id);

        return view('test_biographies.show', compact('testBiography'));
    }

    /**
     * Show the form for editing the specified test biography.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $testBiography = testBiography::findOrFail($id);
        

        return view('test_biographies.edit', compact('testBiography'));
    }

    /**
     * Update the specified test biography in the storage.
     *
     * @param int $id
     * @param App\Http\Requests\TestBiographiesFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, TestBiographiesFormRequest $request)
    {
        try {
            
            $data = $request->getData();
            
            $testBiography = testBiography::findOrFail($id);
            $testBiography->update($data);

            return redirect()->route('test_biographies.test_biography.index')
                ->with('success_message', 'Test Biography was successfully updated.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }        
    }

    /**
     * Remove the specified test biography from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $testBiography = testBiography::findOrFail($id);
            $testBiography->delete();

            return redirect()->route('test_biographies.test_biography.index')
                ->with('success_message', 'Test Biography was successfully deleted.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }



}
