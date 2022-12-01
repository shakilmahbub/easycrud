<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestForm3sFormRequest;
use App\Models\TestForm3;
use Exception;

class TestForm3sController extends Controller
{

    /**
     * Display a listing of the test form3s.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $testForm3s = TestForm3::paginate(25);

        return view('test_form3s.index', compact('testForm3s'));
    }

    /**
     * Show the form for creating a new test form3.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('test_form3s.create');
    }

    /**
     * Store a new test form3 in the storage.
     *
     * @param App\Http\Requests\TestForm3sFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(TestForm3sFormRequest $request)
    {
        try {
            
            $data = $request->getData();
            
            TestForm3::create($data);

            return redirect()->route('test_form3s.test_form3.index')
                ->with('success_message', 'Test Form3 was successfully added.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Display the specified test form3.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $testForm3 = TestForm3::findOrFail($id);

        return view('test_form3s.show', compact('testForm3'));
    }

    /**
     * Show the form for editing the specified test form3.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $testForm3 = TestForm3::findOrFail($id);
        

        return view('test_form3s.edit', compact('testForm3'));
    }

    /**
     * Update the specified test form3 in the storage.
     *
     * @param int $id
     * @param App\Http\Requests\TestForm3sFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, TestForm3sFormRequest $request)
    {
        try {
            
            $data = $request->getData();
            
            $testForm3 = TestForm3::findOrFail($id);
            $testForm3->update($data);

            return redirect()->route('test_form3s.test_form3.index')
                ->with('success_message', 'Test Form3 was successfully updated.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }        
    }

    /**
     * Remove the specified test form3 from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $testForm3 = TestForm3::findOrFail($id);
            $testForm3->delete();

            return redirect()->route('test_form3s.test_form3.index')
                ->with('success_message', 'Test Form3 was successfully deleted.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }



}
