<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\LoaiTin;
use App\TinTuc;
use Illuminate\Support\Facades\Auth;
use App\User;



class PagesController extends Controller
{
    //
    

    function trangchu(){      
        return view('pages.trangchu');
    }

    function lienhe(){
        return view('pages.lienhe');
    }

    function loaitin($id){
        $loaitin = LoaiTin::find($id);
        $tintuc = TinTuc::where('idLoaiTin',$id)->paginate(5);
        return view('pages.loaitin',['loaitin'=>$loaitin, 'tintuc'=>$tintuc]);
    }

    function tintuc($id){
        $tintuc = TinTuc::find($id);
        $tinnoibat = TinTuc::where('NoiBat',1)->take(4)->get();
        $tinlienquan = TinTuc::where('idLoaiTin',$tintuc->idLoaiTin)->take(4)->get();
        return view('pages.tintuc',['tintuc'=>$tintuc,'tinnoibat'=>$tinnoibat,'tinlienquan'=>$tinlienquan]);
    }

    function getDangNhap(){
        return view('pages.dangnhap');
    }

    function postDangNhap(Request $request){
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
            return redirect('trangchu');
        }else{
            return redirect('dangnhap')->with('thongbao','dang nhap khong thành công');
        }
    }

    function getDangXuat(){
        Auth::logout();
        return redirect('trangchu');
    }

    function getNguoiDung(){
        $user = Auth::user();
        return view('pages.nguoidung',['nguoidung'=>$user]);
    }
    function postNguoiDung(Request $request){
        $this->validate($request,
        [
            'name' => 'required|min:3',
        ],
        [
            'name.required'=>'Bạn chưa nhập tên nguoi dung',
            'name.min'=>'Ten nguoi dung co it nhat 3 ky tu',
        ]);

        $user = Auth::user();
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
        return redirect('nguoidung')->with('thongbao','thêm thành công');
    }

    function getDangKy(){
        return view('pages.dangky');

    }

    function postDangKy(Request $request){
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
        $user->quyen = 0;

        $user->save();
        return redirect('dangnhap')->with('thongbao','dang ky thanh cong');
    }

    function getTimKiem(Request $request)
    {
        // $tukhoa = $request->tukhoa;
        $tukhoa=$request->get('tukhoa');
        $tintuc = TinTuc::where('TieuDe','like','%'.$tukhoa.'%')->orWhere('TomTat','like','%'.$tukhoa.'%')->orWhere('NoiDung','like','%'.$tukhoa.'%')->paginate(5);
        return view('pages.timkiem',['tukhoa'=>$tukhoa,'tintuc'=>$tintuc]);
    }
}
