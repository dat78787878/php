@extends('admin.layout.index')
@section('content')

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Slide
                    <small>{{$slide->Ten}}</small>
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

                <form action="admin/slide/sua/{{$slide->id}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="form-group">
                        <label>Ten</label>
                        <input class="form-control" name="Ten" value="{{$slide->Ten}}" placeholder="Please Enter Category Name" />
                    </div>
                    <div class="form-group">
                        <label>Noi dung</label>
                        <textarea id="demo" name="NoiDung" class="form-control ckeditor" rows="3">
                            {{$slide->NoiDung}}
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label>Link</label>
                        <input class="form-control" name="link" placeholder="Nhap link" value="{{$slide->link}}" />
                    </div>
                   
                    <div class="form-group">
                        <label>Hinh anh</label>
                        <p>
                            <img width="300px" src="upload/slide/{{$slide->Hinh}}">
                        </p>
                        <input type="file" name="Hinh" class="form-control" />
                    </div>
                    <button type="submit" class="btn btn-default">Sua</button>
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