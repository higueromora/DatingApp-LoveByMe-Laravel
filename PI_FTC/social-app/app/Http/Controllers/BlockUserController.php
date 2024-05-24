<?php

namespace App\Http\Controllers;

use App\Models\message;
use App\Models\User;
use App\Models\UserBlock;
use App\Models\UserMatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlockUserController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        $blockedUsers = UserBlock::where('blocker_id', Auth::id())->with('blocked')->paginate(5);

        return view('userblock.block', ['users' => $blockedUsers]);
    }




    /**
     * Block a user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function block(Request $request)
    {
        $blockerId = $request->input('blocker_id');
        $blockedId = $request->input('blocked_id');

        // Create the block
        UserBlock::create([
            'blocker_id' => $blockerId,
            'blocked_id' => $blockedId,
        ]);

        // Remove any existing matches
        UserMatch::where(function ($query) use ($blockerId, $blockedId) {
            $query->where('user1_id', $blockerId)
                ->where('user2_id', $blockedId);
        })->orWhere(function ($query) use ($blockerId, $blockedId) {
            $query->where('user1_id', $blockedId)
                ->where('user2_id', $blockerId);
        })->delete();

        // Remove any existing messages
        message::where(function ($query) use ($blockerId, $blockedId) {
            $query->where('sender_id', $blockerId)
                ->where('receiver_id', $blockedId);
        })->orWhere(function ($query) use ($blockerId, $blockedId) {
            $query->where('sender_id', $blockedId)
                ->where('receiver_id', $blockerId);
        })->delete();

        // Delete comments received from the blocked user
        \App\Models\Comment::where('user_id', $blockedId)->delete();

        return redirect()->back();
    }


    public function unblock(Request $request)
    {
        $blockerId = $request->input('blocker_id');
        $blockedId = $request->input('blocked_id');

        // Delete the block
        UserBlock::where('blocker_id', $blockerId)
            ->where('blocked_id', $blockedId)
            ->delete();


        return redirect()->back();
    }


}


