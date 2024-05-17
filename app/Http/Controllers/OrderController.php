<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public int $price = 100000;

    public function chooseDomain(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $validatedData = $request->validate([
           'domain' => 'required'
        ]);

        $selectedDomain = $validatedData['domain'];
        $price = $this->price;

        return view('checkout', compact('selectedDomain', 'price'));
    }

    /**
     * @throws ValidationException
     * @throws \Exception
     */
    public function checkout(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'domain' => 'required',
            'duration' => 'required',
            'name' => 'sometimes',
            'email' => 'sometimes',
            'password' => 'sometimes'
        ]);

        $validatedData = $validator->validated();

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();
            $order = new Order();
            $order->fill($validatedData);

            if(isset($validatedData['email'])){
                $user = new User();
                $user->fill(Arr::only($validatedData, ['name', 'email']));
                $user->password = Hash::make($validatedData['password']);
                $user->save();
                Auth::login($user);
            }

            $order->user_id = auth()->user()->id;
            $order->save();
            DB::commit();
        } catch (\Exception $e){
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

        return redirect()->route('invoice', ['order_id' => $order->id]);
    }

    public function invoice(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $order = Order::findOrFail($request->order_id);
        $price = $this->price;
        return view('invoice', compact('order', 'price'));
    }
}
