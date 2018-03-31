<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Relevance;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('authorization');
    }

    /**
     * Users.
     *
     * @return [$user]
     */
    public function getUsers() {
        $user = new User();
        $users = $user->getUsers();

        return response()->json($users);
    }


    /**
     * User.
     *
     * @return [$user]
     */
    public function getUser(Request $request) {
        $user = new User();
        $users = array();
        if (isset($request->key_word)) {
            $users = $user->getUser($request->key_word);
        }

        $users = $this->sortByRelevance($users);

        return response()->json($users);
    }

    public function sortByRelevance($users) {
        $relevance = new Relevance();
        $relevance1Array = $relevance->getRelevance1();
        $relevance2Array = $relevance->getRelevance2();
        $relevance1Users = array();
        $relevance2Users = array();
        $othersUsers = array();
        $usersSorted = array();
        foreach($users as $user) {
            $relevance1User = false;
            foreach($relevance1Array as $relevance1) {
                if($user->id == $relevance1) {
                    $relevance1Users[] = $user;
                    $relevance1User = true;
                    break;
                }
            }

            foreach($relevance2Array as $relevance2) {
                $relevance2User = false;
                if($user->id == $relevance2) {
                    $relevance2Users[] = $user;
                    $relevance2User = true;
                    break;
                }
            }

            if(!$relevance1User && !$relevance2User) {
                $othersUsers[] = $user;
            }
        }

        foreach($relevance1Users as $relevance1) {
            $usersSorted[] = $relevance1;
        }

        foreach($relevance2Users as $relevance2) {
            $usersSorted[] = $relevance2;
        }

        foreach($othersUsers as $otherUser) {
            $usersSorted[] = $otherUser;
        }

        return $usersSorted;
    }
}
