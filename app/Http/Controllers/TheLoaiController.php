<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;

class TheLoaiController extends Controller
{
    //
    public function getDanhSach(){
        $theloai = TheLoai::all();
        return view('admin.theloai.danhsach',['theloai'=>$theloai]);
    }

    public function getThem(){
        return view('admin.theloai.them');
    }

    public function postThem(Request $request){
        $this->validate($request,
        [
            'Ten' => 'required|min:3|max:100|unique:TheLoai,Ten'
        ],
        [
            'Ten.required'=>'Bạn chưa nhập tên thể loại',
            'Ten.min'=>'Tên thể loại từ 3 đến 100 ký tự',
            'Ten.max'=>'Tên thể loại từ 3 đến 100 ký tự',
            'Ten.unique' => 'ten the loai da ton tai'
        ]);

        $theloai = new TheLoai;
        $theloai->Ten = $request->Ten;
        $theloai->TenKhongDau= changeTitle($request->Ten);
        $theloai->save();

        return redirect('admin/theloai/them')->with('thongbao','thêm thành công');
    }

    public function getSua($id){
        $theloai = TheLoai::find($id);
        return view('admin.theloai.sua',['theloai' => $theloai]);
    }

    public function postSua(Request $request,$id){
        $theloai = TheLoai::find($id);
        $this->validate($request,[
            'Ten' => 'required|unique:TheLoai,Ten|min:3|max:100'
        ],
        [
            'Ten.required' => 'ban chua nhap ten the loai',
            'Ten.unique' => 'ten the loai da ton tai',
            'Ten.min'=>'Tên thể loại từ 3 đến 100 ký tự',
            'Ten.max'=>'Tên thể loại từ 3 đến 100 ký tự'
        ]
        );

        $theloai->Ten = $request->Ten;
        $theloai->TenKhongDau = changeTitle($request->Ten);
        $theloai->save();

        return redirect('admin/theloai/sua/'.$id)->with('thongbao','sua thanh cong');
    }

    public function getXoa($id){
        $theloai = TheLoai::find($id);
        $theloai->delete();

        return redirect('admin/theloai/danhsach')->with('thongbao','ban da xoa thanh cong');
    }
}
