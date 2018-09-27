<?php

namespace App\Http\Controllers;

use App\User;
use App\UserPriority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request)
    {
        $limit = 15;
        $page = ($request->input('page'))? $request->input('page'): 0;
        $search = $request->input("search");
        $offset = $page * $limit;

        $priority = UserPriority::max("priority");

        $priorityUsers = UserPriority::with(["users" => function($query) use ($search)
        {
            $query->where(function ($query) use ($search) {
                $query->where("id", $search)
                    ->orWhere("username", $search)
                    ->orWhere("nome", $search)
                    ->orWhere("email", $search);
            });

        }])->offset($offset)
            ->limit($limit)
            ->orderBy("priority", "asc")
            ->orderBy("id", "asc")
            ->get();

        $users['data'] = [];
        foreach ($priorityUsers as $priorityUser) {
            if ($priorityUser->users) array_push($users['data'], $priorityUser->users);
        }

        $users['total'] = count($users['data']);
        $lastGeneralOffset = 0;
        $lastGeneralLimit = 0;

        if ($users['total'] < $limit) {

            if ($users['total'] != 0) {
                $lastGeneralLimit = $limit - $users['total'];
                $usersGeneral = User::where("id", $search)
                    ->orWhere("username", $search)
                    ->orWhere("nome", $search)
                    ->orWhere("email", $search)
                    ->offset($lastGeneralOffset)
                    ->limit($lastGeneralLimit)
                    ->get();

            } else {

                $lastGeneralOffset = ($request->input('lastGeneralOffset'))? $request->input('lastGeneralOffset'): 0;
                $lastGeneralLimit = $limit;
                $offset = $limit * $lastGeneralOffset;

                $usersGeneral = User::where("id", $search)
                    ->orWhere("username", $search)
                    ->orWhere("nome", $search)
                    ->orWhere("email", $search)
                    ->offset($offset)
                    ->limit($lastGeneralLimit)
                    ->get();
                $lastGeneralOffset++;
            }
            foreach ($usersGeneral as $userGeneral) {
                array_push($users['data'], $userGeneral);
            }
            $users['data'] = array_unique($users['data']);
            $users['total'] = count($users['data']);
        }

        $users['current_page'] = $request->fullUrl();
        $users['current_page_number'] = $page;
        $page++;
        $users["first_page_url"] = $request->url() . "?page=0";
        $users["next_page_url"] = $request->url() . "?page=$page&lastGeneralLimit=$lastGeneralLimit&lastGeneralOffset=$lastGeneralOffset";
        $users["path"] = $request->url();

        if ($search) {
            $users["next_page_url"] = $users["next_page_url"] . "&search=$search";
            $users["first_page_url"] = $users["first_page_url"] . "&search=$search";
        }
        if ($users['total'] < $limit) {
            $users["next_page_url"] = null;
        }

        if ($request->is("api*")) {
            return $users;
        }
        return view("users.index", ["users" => $users, "priority" => $priority]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $users = new User();
        $priority = UserPriority::max("priority");

        return view("users.create", ["users" => $users, "priority" => $priority]);
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
        $data = $request->all();
        $rules = [
            'nome' => 'required|string|max:255',
            'email' => 'string|email|max:255|unique:users',
            'username' => 'string|max:255|unique:users',
            'password' => 'string|min:6|confirmed',
        ];
        if (!$data['email']) {
            $rules['username'] = $rules['username'] . "|required";
        }
        if (!$data['username']) {
            $rules['email'] = $rules['email'] . "|required";
        }

        $this->validate($request, $rules);

        User::create([
            'id' => $request->input('id'),
            'nome' => $request->input('nome'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $return_message = ["success_message" => "Usuário cadastrado com sucesso"];
        return response()->redirectTo("/users")->with($return_message);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $users = User::select(
            "users.id_auto", "users.id", "users.nome", "users.username", "users.email", "users.email_verified_at", "users.created_at", "users.updated_at",
            "user_priorities.priority as priority"
        )
            ->leftJoin('user_priorities', "users.id", "user_priorities.id")
            ->where("users.id_auto", $id)
            ->first();

        $priority = UserPriority::max("priority");
        return view("users.edit", ["users" => $users, "priority" => $priority]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = $request->all();
        $users = User::find($id);

        $rules = [
            'nome' => 'string|max:255',
            'email' => 'string|email|max:255',
            'username' => 'string|max:255',
            'password' => 'string|min:6',
        ];

        $this->validate($request, $rules);

        $users->nome = $data['nome'];
        $users->email = $data['email'];
        $users->username = $data['username'];

        if ($data['password'] != $users->password) {
            $users->password = Hash::make($data['password']);
        }
        $users->update();

        UserPriority::where("id", $users->id)->delete();

        if ($data['priority']) {
            UserPriority::create([
                "id" => $users->id,
                "priority" => $data['priority']
            ]);
        }

        $return_message = ["success_message" => "Usuário atualizado com sucesso"];
        return response()->redirectTo("/users")->with($return_message);
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
