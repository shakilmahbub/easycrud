<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestForm4sFormRequest;
use App\Models\TestForm4;
use Exception;

class TestForm4sController extends Controller
{

    /**
     * Display a listing of the test form4s.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $testForm4s = TestForm4::paginate(25);

        return view('test_form4s.index', compact('testForm4s'));
    }

    /**
     * Show the form for creating a new test form4.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('test_form4s.create');
    }

    /**
     * Store a new test form4 in the storage.
     *
     * @param App\Http\Requests\TestForm4sFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(TestForm4sFormRequest $request)
    {
        try {
            
            $data = $request->getData();
            
            TestForm4::create($data);

            return redirect()->route('test_form4s.test_form4.index')
                ->with('success_message', 'Test Form4 was successfully added.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Display the specified test form4.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $testForm4 = TestForm4::findOrFail($id);

        return view('test_form4s.show', compact('testForm4'));
    }

    /**
     * Show the form for editing the specified test form4.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $testForm4 = TestForm4::findOrFail($id);
        

        return view('test_form4s.edit', compact('testForm4'));
    }

    /**
     * Update the specified test form4 in the storage.
     *
     * @param int $id
     * @param App\Http\Requests\TestForm4sFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, TestForm4sFormRequest $request)
    {
        try {
            
            $data = $request->getData();
            
            $testForm4 = TestForm4::findOrFail($id);
            $testForm4->update($data);

            return redirect()->route('test_form4s.test_form4.index')
                ->with('success_message', 'Test Form4 was successfully updated.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }        
    }

    /**
     * Remove the specified test form4 from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $testForm4 = TestForm4::findOrFail($id);
            $testForm4->delete();

            return redirect()->route('test_form4s.test_form4.index')
                ->with('success_message', 'Test Form4 was successfully deleted.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }



}
