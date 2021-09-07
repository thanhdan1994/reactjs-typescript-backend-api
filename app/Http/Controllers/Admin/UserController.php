<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Users\Repositories\Interfaces\UserRepositoryInterface;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;
use App\Models\Images\Image;

class UserController extends Controller
{
    private $userRepo;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepo = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->userRepo->listUsers();
        return view('admin.user.index', [
            'users' => $this->userRepo->paginateArrayResults(
                $users->all(),
                Config::get('constants.admin.paginate')
            )
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($id)
    {
        $user = User::find($id);
        $this->authorize('update', $user);
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $this->authorize('update', $user);
        $user->name = $request->name;
        if ($request->file('featured_image')) {
            $file = $request->featured_image;
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '-thumbnail-' . Carbon::now()->timestamp;
            $fileExt = $file->extension();
            $file->storeAs('public/images', $fileName . '.' . $fileExt);
            $image = Image::create([
                'name' => $fileName,
                'ext' => $fileExt,
                'store_path' => 'storage/images'
            ]);
            $user->featured_image = $image->id;
        }
        $user->save();
        return redirect()->route('admin.users.edit', $id)->with('message', 'Cập nhập thông tin thành công!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
