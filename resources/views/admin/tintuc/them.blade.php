@extends('admin.layout.index')
@section('content')

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Tin tuc
                    <small>Thêm</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-7" style="padding-bottom:120px">
            
                @if(count($errors) > 0)
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $err)
                            {{$err}}<br>
                        @endforeach
                    </div>
                @endif

                @if(session('thongbao'))
                    <div class="alert alert-success">
                        {{session('thongbao')}}
                    </div>
                @endif

                <form action="admin/tintuc/them" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="form-group">
                        <label>The loai</label>
                        <select class="form-control" name="TheLoai" id="TheLoai">
                            @foreach($theloai as $tl)
                                <option value="{{$tl->id}}">{{$tl->Ten}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Loai tin</label>
                        <select class="form-control" name="LoaiTin" id="LoaiTin">
                            @foreach($loaitin as $lt)
                                <option value="{{$lt->id}}">{{$lt->Ten}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Tieu de</label>
                        <input class="form-control" name="TieuDe" placeholder="Please Enter Category Name" />
                    </div>
                    <div class="form-group">
                        <label>Tom tat</label>
                        <textarea id="demo" name="TomTat" class="ckeditor" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Noi dung</label>
                        <textarea id="demo" name="NoiDung" class="ckeditor" rows="5"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Hinh anh</label>
                        <input type="file" name="Hinh" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Noi bat</label>
                        <label class="radio-inline">
                            <input name="NoiBat" value="0" checked="" type="radio">Khong
                        </label>
                        <label class="radio-inline">
                            <input name="NoiBat" value="1" type="radio">Co
                        </label>
                    </div>

                    <button type="submit" class="btn btn-default">Them</button>
                    <button type="reset" class="btn btn-default">Lam moi</button>
                </form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
   

@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $("#TheLoai").change(function(){
                var idTheLoai = $(this).val();
                $.get("admin/ajax/loaitin/"+idTheLoai, function(data){               
                    $("#LoaiTin").html(data);
                });
            });
        });
    </script>
@endsection