<?php

namespace App\Http\Controllers\Chat;

use App\ChatMessage;
use App\Events\ChatSent;
use App\Operator;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OPChatController extends Controller
{
    public $opchat;
    
    public function __construct()
    {
        //Hardcoded Operators
        $this->opchat = (new Operator)->find(1);
    }

    public function index($productid, $userid) {
        $product = (new Product)->findOrFail($productid);
        $user = (new User)->findOrFail($userid);
        return view("chat.operator", compact(['product','user']));
    }

    public function sendMessage(Request $request, $productid, $userid) {
        $product = (new Product)->findOrFail($productid);
        $user = (new User)->findOrFail($userid);
        $message = new ChatMessage();
        $message->body = $request->get("body");
        $message->user()->associate($user);
        $message->product()->associate($product);
        $message->operator()->associate($this->opchat);
        $message->isFromUser = false;
        $message->save();

        broadcast(new ChatSent($message))->toOthers();

        return response()->json($request->all());
    }
    
    public function fetchMessage($product_id, $user_id) {
        $message = (new ChatMessage)->where("product_id", $product_id)->where("user_id", $user_id)->get();
        return response()->json($message);
    }
}
