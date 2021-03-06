<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Driver;
use App\Country;
use Illuminate\View\View;

class DriversController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware([ 'auth', 'admin' ]);
    }
 
    /**
     * Display a listing of the resource.
     *
     * @return Factory|Application|View
     */
    public function index()
    {
        return view('admin.drivers.index')->with('drivers', Driver::with([ 'country', 'entries' ])->paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|Application|View
     */
    public function create()
    {
        return view('admin.drivers.create')->with('countries', Country::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $request->validate(
            [
            'first_name'        => [ 'required', 'min:2' ],
            'surname_prefix'    => [ 'string', 'nullable' ],
            'last_name'         => [ 'required', 'min:2', Rule::unique('drivers')->where('first_name', $request->input('first_name'))->where('country_id', $request->input('country_id')) ],
            'country_id'        => [ 'required', 'integer', 'exists:countries,id' ],
            'active'            => [ 'boolean' ],
            ]
        );
        
        if ($driver = Driver::create($request->only('first_name', 'surname_prefix', 'last_name', 'active', 'country_id'))) {
            session()->flash('status', __("The driver :name has been added.", [ 'name' => $driver->fullName ]));
        }
        
        return redirect()->route('admin.drivers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Driver $driver
     * @return Factory|Application|View
     */
    public function show(Driver $driver)
    {
        return view('admin.drivers.show')->with('driver', $driver);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Driver $driver
     * @return Factory|Application|View
     */
    public function edit(Driver $driver)
    {
        return view('admin.drivers.edit')->with(
            [
            'driver'    => $driver,
            'countries' => Country::all()
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Driver $driver
     * @return RedirectResponse
     */
    public function update(Request $request, Driver $driver)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $request->validate(
            [
            'first_name'        => [ 'required', 'min:2' ],
            'surname_prefix'    => [ 'string', 'nullable' ],
            'last_name'         => [ 'required', 'min:2', Rule::unique('drivers')->where('first_name', $request->input('first_name'))->where('country_id', $request->input('country_id'))->ignore($driver->id) ],
            'country_id'        => [ 'required', 'integer', 'exists:countries,id' ],
            'active'            => [ 'boolean' ],
            ]
        );
        
        if ($driver->update($request->only('first_name', 'surname_prefix', 'last_name', 'active', 'country_id'))) {
            session()->flash('status', __("The driver :name has been changed.", [ 'name' => $driver->fullName ]));
        }
        
        return redirect()->route('admin.drivers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Driver $driver
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Driver $driver)
    {
        try {
            $driver->delete();
            
            session()->flash('status', __("The driver :name has been deleted.", [ 'name' => $driver->fullName ]));
        } catch (QueryException $e) {
            session()->flash('status', __("The driver :name could not be deleted.", [ 'name' => $driver->fullName ]));
        }
            
        return redirect()->route('admin.drivers.index');
    }
}
