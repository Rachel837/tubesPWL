<?php

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class OrganizerController extends Controller
{
    public function index()
    {
        $organizers = User::where('role_id', 2)->get(); // 2 = organizer
        return view('organizer.index', compact('organizers'));
    }

    public function create()
    {
        return view('organizer.create');
    }

    public function store(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => 2,
            'status' => 'active'
        ]);

        return redirect('/organizer');
    }

    public function edit($id)
    {
        $organizer = User::find($id);
        return view('organizer.edit', compact('organizer'));
    }

    public function update(Request $request, $id)
    {
        $organizer = User::find($id);

        $organizer->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect('/organizer');
    }

    public function toggleStatus($id)
    {
        $user = User::find($id);

        $user->status = $user->status == 'active' ? 'inactive' : 'active';
        $user->save();

        return back();
    }
}