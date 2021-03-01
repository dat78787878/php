<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\TinTuc;
use App\LoaiTin;
use Illuminate\Support\Str;
use App\Comment;

class TinTucController extends Controller
{
    //
    public function getDanhSach(){
        $tintuc = TinTuc::orderBy('id','DESC')->get();
        return view('admin.tintuc.danhsach',['tintuc'=>$tintuc]);
    }

    public function getThem(){
        $theloai= TheLoai::all();
        $loaitin = LoaiTin::all();
        return view('admin.tintuc.them',['theloai'=>$theloai,'loaitin'=>$loaitin]);
    }

    public function postThem(Request $request){
        $this->validate($request,
        [
            'TheLoai'=>'required',
            'LoaiTin'=>'required',
            'TieuDe' => 'required|min:3|max:100|unique:TinTuc,TieuDe',
            'TomTat'=>'required',
            'NoiDung'=>'required'
        ],
        [
            'TheLoai.required'=>'Bạn chưa nhập t l',
            'LoaiTin.required'=>'Bạn chưa nhập loai tin',
            'TieuDe.required'=>'Bạn chưa nhập tieu de',
            'TomTat.required'=>'Bạn chưa nhập tom tat',
            'NoiDung.required'=>'Bạn chưa nhập noi dung',
            'TieuDe.min'=>'tieu de từ 3 ký tự',
            'TieuDe.max'=>'tieu de max 100 ký tự',
            'TieuDe.unique' => 'tieu de da ton tai'
        ]);

        $tintuc = new TinTuc;
        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau= changeTitle($request->TieuDe);
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->TomTat = $request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;
        $tintuc->SoLuotXem = 0;

        if($request->hasFile('Hinh')){
            $file = $request->file('Hinh');
            $duoi = $file->getClientOriginalExtension();
            if($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jpeg'){
                return redirect('admin/tintuc/them')->with('loi','ban chi duoc chon file co duoi jpg png');
            }
            $name = $file->getClientOriginalName();
            $Hinh = Str::random(4)."_".$name;
            while(file_exists("upload/tintuc/".$Hinh)){
                $Hinh = Str::random(4)."_".$name;
            }
            $file->move("upload/tintuc",$Hinh);
            $tintuc->Hinh = $Hinh;
        }
        else{
            $tintuc->Hinh = "";
        }

        $tintuc->save();


        return redirect('admin/tintuc/them')->with('thongbao','thêm thành công');
    }

    public function getSua($id){
        $theloai= TheLoai::all();
        $loaitin = LoaiTin::all();
        $tintuc = TinTuc::find($id);
        return view('admin.tintuc.sua',['tintuc'=>$tintuc,'theloai'=>$theloai,'loaitin'=>$loaitin]);

    }

    public function postSua(Request $request,$id){
       $tintuc = TinTuc::find($id);
       $this->validate($request,
        [
            'TheLoai'=>'required',
            'LoaiTin'=>'required',
            'TieuDe' => 'required|min:3|max:100|unique:TinTuc,TieuDe',
            'TomTat'=>'required',
            'NoiDung'=>'required'
        ],
        [
            'TheLoai.required'=>'Bạn chưa nhập t l',
            'LoaiTin.required'=>'Bạn chưa nhập loai tin',
            'TieuDe.required'=>'Bạn chưa nhập tieu de',
            'TomTat.required'=>'Bạn chưa nhập tom tat',
            'NoiDung.required'=>'Bạn chưa nhập noi dung',
            'TieuDe.min'=>'tieu de từ 3 ký tự',
            'TieuDe.max'=>'tieu de max 100 ký tự',
            'TieuDe.unique' => 'tieu de da ton tai'
        ]);
        $tintuc->TieuDe = $request->TieuDe;
        $tintuc->TieuDeKhongDau= changeTitle($request->TieuDe);
        $tintuc->idLoaiTin = $request->LoaiTin;
        $tintuc->TomTat = $request->TomTat;
        $tintuc->NoiDung = $request->NoiDung;

        if($request->hasFile('Hinh')){
            $file = $request->file('Hinh');
            $duoi = $file->getClientOriginalExtension();
            if($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jpeg'){
                return redirect('admin/tintuc/them')->with('loi','ban chi duoc chon file co duoi jpg png');
            }
            $name = $file->getClientOriginalName();
            $Hinh = Str::random(4)."_".$name;
            while(file_exists("upload/tintuc/".$Hinh)){
                $Hinh = Str::random(4)."_".$name;
            }
            $file->move("upload/tintuc",$Hinh);
            unlink("upload/tintuc/".$tintuc->Hinh);
            $tintuc->Hinh = $Hinh;
        }
        
        $tintuc->save();
        return redirect('admin/tintuc/sua/'.$id)->with('thongbao','thêm thành công');

    }

    public function getXoa($id){
       $tintuc = TinTuc::find($id);
       $tintuc->delete();
       return redirect('admin/tintuc/danhsach')->with('thongbao','xoa thnah cong');
    }
}
