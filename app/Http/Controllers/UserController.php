<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function getDanhSach(){
        $user = User::all();
        return view('admin.user.danhsach',['user'=>$user]);
    }

    public function getThem(){
        return view('admin.user.them');
    }

    public function postThem(Request $request){
        $this->validate($request,
        [
            'name' => 'required|min:3',
            'email'=>'required|email|unique:users,email',
            'password' => 'required|min:3|max:32',
            'passwordAgain' => 'required|same:password'
        ],
        [
            'name.required'=>'Bạn chưa nhập tên nguoi dung',
            'name.min'=>'Ten nguoi dung co it nhat 3 ky tu',
            'email.required'=>'Bạn chưa nhập email',
            'email.email'=>'ban chua nhap dung dinh dang email',
            'email.unique'=>'email da ton tai',
            'password.required'=>'ban chua nhap mat khau',
            'password.min'=>'mat khau co it nhat 3 ky tu',
            'password.max'=>'mat khau co toi da 32 ky tu',
            'passwordAgain.required'=>'ban chua nhap lai mat khau',
            'passwordAgain.same'=>'mat khau nhap lai chua khop'
            
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->quyen = $request->quyen;

        $user->save();
        return redirect('admin/user/them')->with('thongbao','thêm thành công');
    }

    public function getSua($id){
        $user = User::find($id);
        return view('admin.user.sua',['user' => $user]);
    }

    public function postSua(Request $request,$id){
        $this->validate($request,
        [
            'name' => 'required|min:3',
        ],
        [
            'name.required'=>'Bạn chưa nhập tên nguoi dung',
            'name.min'=>'Ten nguoi dung co it nhat 3 ky tu',
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->quyen = $request->quyen;

        if($request->changePassword =="on"){
            $this->validate($request,
        [
            'password' => 'required|min:3|max:32',
            'passwordAgain' => 'required|same:password'
        ],
        [
            'password.required'=>'ban chua nhap mat khau',
            'password.min'=>'mat khau co it nhat 3 ky tu',
            'password.max'=>'mat khau co toi da 32 ky tu',
            'passwordAgain.required'=>'ban chua nhap lai mat khau',
            'passwordAgain.same'=>'mat khau nhap lai chua khop'
        ]);
            $user->password = bcrypt($request->password);
        }
        $user->save();
        return redirect('admin/user/sua/'.$id)->with('thongbao','thêm thành công');
    }

    public function getXoa($id){
        $user = User::find($id);
        $user->delete();

        return redirect('admin/user/danhsach')->with('thongbao','ban da xoa thanh cong');
    }

    public function getdangnhapAdmin(){
        return view('admin.login');
    }

    public function postdangnhapAdmin(Request $request){
        $this->validate($request,[
            'email' =>'required',
            'password' =>'required|min:3|max:32',
        ],
        [
            'email.required'=>'Bạn chưa nhập email',
            'password.required'=>'Bạn chưa nhập pass',
            'password.min'=>'khong duoc nho hon 3 ky tu',
            'password.max'=>'khong duoc lon hon 32 ky tu'
        ]);
        if(Auth::attempt(['email' =>$request -> email, 'password'=>$request -> password])){
            return redirect('admin/theloai/danhsach');
        }else{
            return redirect('admin/dangnhap')->with('thongbao','dang nhap khong thành công');
        }
    }

    public function getdangxuatAdmin(){
        Auth::logout();
        return redirect('admin/dangnhap');
    }
}
