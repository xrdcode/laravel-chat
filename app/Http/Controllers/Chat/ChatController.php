<?php
/**
 * Created by PhpStorm.
 * User: nakama
 * Date: 04/03/18
 * Time: 0:40
 */

namespace App\Http\Controllers\Chat;


use App\ChatMessage;
use App\Events\ChatSent;
use App\Http\Controllers\Controller;
use App\Operator;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware(["auth"]);
    }

    public function index($productid) {
        $product = Product::findOrFail($productid);
        return view("chat.index", compact('product'));
    }

    public function operator($id) {
        $operator = Operator::findOrFail($id);
        return view("chat.operator");
    }

    public function sendMessage(Request $request, $productid) {
        $product = Product::findOrFail($productid);
        $user = Auth::user();
        $message = new ChatMessage();
        $message->body = $request->get("body");
        $message->user()->associate($user);
        $message->product()->associate($product);
        $message->save();

        broadcast(new ChatSent($message))->toOthers();

        return response()->json($request->all());
    }

    public function fetchMessage($product_id) {
        $message = ChatMessage::where("product_id", $product_id)->where("user_id", Auth::id())->get();
        return response()->json($message);
    }

}