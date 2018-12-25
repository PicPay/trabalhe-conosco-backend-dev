<?php
/**
 * Created by IntelliJ IDEA.
 * User: vitorvannuchi
 * Date: 23/12/2018
 * Time: 08:13
 */

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\ListModel;
use Http;
use App\Customer;

class ListController extends Controller
{
    public function index(){

        $request = new Request();

        $request->replace([
            'show_per_page' => 15,
            'page' => 1,
            'list' => "first"
        ]);

        $first_list = $this->getList($request);

        $request->replace([
            'show_per_page' => 15,
            'page' => 1,
            'list' => 'secondary']);

        $secondary_list = $this->getList($request);

        $request->replace([
            'show_per_page' => 14,
            'page' => 1,
            'list' => 'major'
        ]);
        $major_list = $this->getList($request);

        $data = array(
            "first_list" => $first_list,
            "secondary_list" => $secondary_list,
            "major_list" => $major_list,
            "api_token" => Auth::User()->api_token,
        );

        if (Auth::check()) {
            return view('list',$data);
        }else{
            return redirect('/');
        }
    }

    /**
     * @param Request $request
     * @return false|string
     * getList function, used to return the lists of customers with relevance to be displayed
     *  {
     *      "show_per_oage" : 20,
     *      "page" : 1,
     *      "list" : "major"|"first"|"secondary"
     *  }
     */
    public function getList(Request $request){




        if(!$request->all()){
            $response['success'] = false;
            $response['error_code'] = 400;
            $response['message'] = "Please verify your JSON post parameters";
            $response['errors'] = array("format" => array("The format of the post Body is not correct"));
            return json_encode($response);
        }

        $request->replace([
            'show_per_page' => $request->show_per_page,
            'page' => $request->page,
            'list' => $request->list
        ]);


        $validator = Validator::make($request->all(),[
            'show_per_page' => 'required|integer',
            'page' => 'required|integer',
            'list' => 'required'
        ]);


        if ($validator->fails()) {
            $response['success'] = false;
            $response['error_code'] = 422;
            $response['message'] = "Wrong input in one of the body parameters";
            $response['errors'] = $validator->getMessageBag()->messages();
            return json_encode($response);
        }

        $list_model = new ListModel();

//        $customer_model = $this->getCustomer($post_obj->id, $post_obj->name, $post_obj->username, $post_obj->show_per_page, $post_obj->page);
        switch ($request->list){
            case "first":
                $response = $list_model->getFirstList($request);
                break;
            case "secondary":
                $response = $list_model->getSecondaryList($request);
                break;
            case "major" :
                $response = $list_model->getMajorList($request);
                break;
        }


        return $response;
    }

    public function addToPrimaryList(Request $request){
        if(!$request->all()){
            $response['success'] = false;
            $response['error_code'] = 400;
            $response['message'] = "Please verify your JSON post parameters";
            $response['errors'] = array("format" => array("The format of the post Body is not correct"));
            return json_encode($response);
        }

        $request->replace([
            'token' => $request->token,
        ]);


        $customer_model = new Customer();
        $response_customer = $customer_model->getCustomerByToken($request->token);
        $response = "false";

        if($response_customer){
            //update score
            $list_model = new ListModel();
            $response_score = $list_model->updateScoreByToken($response_customer[0]->id, 2);
            $response = $list_model->addFirstList($request);
        }
        return $response;


    }

    public function removeFromPrimaryList(Request $request){
        $customer_model = new Customer();
        $response_customer = $customer_model->getCustomerByToken($request->token);
        $list_model = new ListModel();
        $response_score = $list_model->removeScore($response_customer[0]->id);
        $response = $list_model->removeFirstList($request);
        return $response;
    }

    public function addToSecondaryList(Request $request){

        if(!$request->all()){
            $response['success'] = false;
            $response['error_code'] = 400;
            $response['message'] = "Please verify your JSON post parameters";
            $response['errors'] = array("format" => array("The format of the post Body is not correct"));
            return json_encode($response);
        }

        $request->replace([
            'token' => $request->token,
        ]);


        $customer_model = new Customer();
        $response_customer = $customer_model->getCustomerByToken($request->token);
        $response = "false";

        if($response_customer){
            //update score
            $list_model = new ListModel();
            $response_score = $list_model->updateScoreByToken($response_customer[0]->id, 1);
            $response = $list_model->addSecondaryList($request);
        }
        return $response;

    }

    public function removeFromSecondaryList(Request $request){
        $customer_model = new Customer();
        $response_customer = $customer_model->getCustomerByToken($request->token);
        $list_model = new ListModel();
        $response_score = $list_model->removeScore($response_customer[0]->id);
        $response = $list_model->removeSecondaryList($request);
        return $response;
    }


}
