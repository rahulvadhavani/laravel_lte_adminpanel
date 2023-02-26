<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $baseurl = url('admin/users');
            $data = User::where('role', User::ROLEUSER)->orderby('id', 'desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function ($row) use ($baseurl) {
                    $url = "<div class='actions-a'>
                <a class='btn-circle btn btn-dark btn-sm module_view_record' data-id='" . $row->id . "' data-url='" . $baseurl . "' title='View'><i class='text-info fas fa-eye'></i></a>
                <a class='btn-circle btn btn-dark btn-sm module_edit_record' data-id='" . $row->id . "' data-url='" . $baseurl . "' title='Edit'><i class='text-warning far fa-edit'></i></a>
                <a class='btn-circle btn btn-dark btn-sm module_delete_record' data-id='" . $row->id . "' data-url='" . $baseurl . "' title='Delete'><i class='text-danger far fa-trash-alt'></i></a>
                </div>";
                    return $url;
                })

                ->addColumn('image', function ($row) {
                    $image = '<img src="' . $row->image . '" class="img-fluid img-radius" width="40px" height="40px">';
                    return $image;
                })
                ->rawColumns(['actions', 'image'])
                ->make(true);
        }
        $title =  'Users';
        return view('users.index', compact('title'));
    }

    // add or edit user
    public function store(UserRequest $request)
    {
        try {
            $post_data = $request->only('first_name', 'last_name', 'name', 'image', 'password', 'id', 'email');
            $post_data['role'] = User::ROLEUSER;
            $post_data['provider'] = 'email';
            $user = User::where('id', $post_data['id'])->first();
            if ($request->image != '') {
                $img = $this->FileUploadHelper($post_data['image'], 'uploads/user');
                $post_data['image'] = $img;
            }
            if ($request->password == null) {
                unset($post_data['password']);
            }
            if ($request->id == 0) {
                $post_data['email_verified_at'] = date('Y-m-d H:i:s');
            }
            if ($user == null) {
                unset($post_data['id']);
                User::create($post_data);
            } else {
                if ($request->image != '') {
                    $path = public_path('uploads/user/' . basename($user->image));
                    $this->destroyFileHelper($path);
                }
                $user->update($post_data);
            }
            return success('User ' . $request->id == 0 ? 'added' : 'updated' . ' successfully.');
        } catch (Exception $e) {
            return error('Something went wrong!!!', $e->getMessage());
        }
    }

    // get edit user details
    public function show($id)
    {
        try {
            $user = User::where('id', $id)->select('id', 'name', 'first_name', 'last_name', 'email', 'created_at', 'image')->first();
            if (empty($user)) {
                return error('Invalid user details');
            }
            $user->url =  url('admin/users');
            return success("Success", $user);
        } catch (\Exception $e) {
            return error('Something went wrong!', $e->getMessage());
        }
    }
    // delete user
    public function destroy($id)
    {
        try {
            $user = User::where('id', $id)->first();
            if (empty($user)) {
                return error('Invalid user details');
            }
            $path = public_path('uploads/user/' . basename($user->image));
            $user->delete();
            $this->destroyFileHelper($path);
            return success("User deleted successfully.");
        } catch (\Exception $e) {
            return error('Something went wrong!', $e->getMessage());
        }
    }

    public function deleteSelected(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => [
                    'required',
                    Rule::exists('users')->where(function ($query) use ($request) {
                        return $query->whereIn('id', $request->id);
                    }),
                ],
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors()
                ], 200);
            }

            $users = User::userRole()->whereIn('id', $request->id);
            foreach ($users->get() as $user) {
                $path = public_path('uploads/user/' . basename($user->image));
                $user->delete();
                $this->destroyFileHelper($path);
            }
            return success("Users deleted successfully.");
        } catch (\Exception $e) {
            return error('Something went wrong!', $e->getMessage());
        }
    }
}
