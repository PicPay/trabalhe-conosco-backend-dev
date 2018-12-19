<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ItemController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $priority = $this->getPriority();

        if($request->get('search')){
            $items = Item::orWhere("name", "LIKE", "%{$request->get('search')}%")
                ->orWhere("username", "LIKE", "%{$request->get('search')}%")
                ->orderBy(DB::raw("(id IN($priority[0]))"), "DESC")
                ->orderBy(DB::raw("(id IN($priority[1]))"), "DESC")
                ->paginate(15);
        }else{
		    $items = Item::orderBy(DB::raw("(id IN($priority[0]))"), "DESC")
                ->orderBy(DB::raw("(id IN($priority[1]))"), "DESC")
                ->paginate(15);
        }

        return response($items);
    }

    public function getPriority()
    {
        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $priority1 = file($storagePath.'/public/lista_relevancia_1.txt');
        $priority2 = file($storagePath.'/public/lista_relevancia_2.txt');
        $priorityFirst = '';
        $prioritySecond = '';

        foreach($priority1 as $p1) {
            $priorityFirst .= '"'.preg_replace('/\s+/', '', $p1).'",';
        }

        $priorityFirst = substr($priorityFirst, 0, -1);

        foreach($priority2 as $p2) {
            $prioritySecond .= '"'.preg_replace('/\s+/', '', $p2).'",';
        }
        $prioritySecond = substr($prioritySecond, 0, -1);

        return [$priorityFirst, $prioritySecond];
    }
}
