<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\TheLoai;
use App\Slide;
use App\LoaiTin;
use App\TinTuc;
use App\User;

class PagesController extends Controller
{
	function __construct() {
		$theloai = TheLoai::all();
		$slide = Slide::all();
		view() -> share('theloai',$theloai);
		view() -> share('slide',$slide);

        if(Auth::check()) {
            view()->share('nguoidung',Auth::user());
        }
	}

    function trangchu() {
    	return view('pages.trangchu');
    }

    function lienhe() {
    	return view('pages.lienhe');
    }

    function loaitin($id) {
    	$loaitin = LoaiTin::find($id);
    	$tintuc = TinTuc::where('idLoaiTin',$id)->paginate(5);
    	return view('pages.loaitin',['loaitin'=>$loaitin,'tintuc'=>$tintuc]);
    }

    function tintuc($id) {
        $tintuc = TinTuc::find($id);
        $tinnoibat = TinTuc::where('NoiBat',1)->take(4)->get();
        $tinlienquan = TinTuc::where('idLoaiTin',$tintuc->idLoaiTin)->take(4)->get();
        return view('pages.tintuc',['tintuc'=>$tintuc,'tinnoibat'=>$tinnoibat,'tinlienquan'=>$tinlienquan]);
    }

    function getDangNhap() {
        return view('pages.dangnhap');
    }

    function postDangNhap(Request $request) {
        $this->validate($request,
            [
                'email'=>'required',
                'password'=>'required|min:3|max:32'
            ],
            [
                'email.required' => 'Bạn chưa nhập email',
                'password.required' => 'Bạn chưa nhập mật khẩu',
                'password.min' => 'Mật khẩu có ít nhất 3 ký tự',
                'password.max' => 'Mật khẩu có nhiều nhất nhất 32 ký tự'  
            ]
        );


        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])) {
            return redirect('trangchu');
        }
        else {
            return redirect('dangnhap')->with('thongbao','Đăng nhập không thành công');
        }
    }

    function getDangXuat() {
        Auth::logout();
        return redirect('trangchu');
    }

    function getNguoiDung() {
        $user = Auth::user();
        if(Auth::check())
            return view('pages.nguoidung',['nguoidung'=>$user]);
        else
            return redirect('dangnhap')->with('thongbao','Bạn chưa Đăng Nhập!');
    }

    function postNguoiDung(Request $request) {
        $this->validate($request,
            [
                'name' => 'required|min:3'
                
            ],
            [
                'name.required' => 'Bạn chưa nhập tên người dùng', 
                'name.min' => 'Tên người dùng phải có ít nhất 3 ký tự'
            ]
        );

        $user = Auth::user();
        $user->name = $request->name;
        
        if($request->changePassword == "on") {
            $this->validate($request,
            [
                'password' => 'required|min:3|max:32',
                'passwordAgain' => 'required|same:password'
            ],
            [
                'password.required' => 'Bạn chưa nhập mật khẩu', 
                'password.min' => 'Mật khẩu có ít nhất 3 ký tự',
                'password.max' => 'Mật khẩu có nhiều nhất nhất 32 ký tự',
                'passwordAgain.required' => 'Bạn chưa nhập lại mật khẩu',
                'passwordAgain.same' => 'Mật khẩu nhập lại chưa đúng'
            ]
            );
            $user->password = bcrypt($request->password);

        }

        $user->save();
        return redirect('nguoidung')->with('thongbao','Bạn đã sửa thành công');
    }

    function getDangKy() {
        return view('pages.dangky');
    }

    function postDangKy(Request $request) {
        $this->validate($request,
            [
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:3|max:32',
                'passwordAgain' => 'required|same:password'
            ],
            [
                'name.required' => 'Bạn chưa nhập tên người dùng', 
                'name.min' => 'Tên người dùng phải có ít nhất 3 ký tự', 
                'email.required' => 'Bạn chưa nhập email', 
                'email.email' => 'Bạn chưa nhập đúng định dạng email', 
                'email.unique' => 'Email đã tồn tại', 
                'password.required' => 'Bạn chưa nhập mật khẩu', 
                'password.min' => 'Mật khẩu có ít nhất 3 ký tự',
                'password.max' => 'Mật khẩu có nhiều nhất nhất 32 ký tự',
                'passwordAgain.required' => 'Bạn chưa nhập lại mật khẩu',
                'passwordAgain.same' => 'Mật khẩu nhập lại chưa đúng'
            ]
        );

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->quyen = 0;
        $user->save();
        return redirect('dangky')->with('thongbao','Đăng ký thành công');
        
    }

    function timkiem(Request $request) {
        $tukhoa = $request->tukhoa;
        $tintuc = TinTuc::where('TieuDe','like',"%$tukhoa%")->orWhere('TomTat','like',"%$tukhoa%")->orWhere('NoiDung','like',"%$tukhoa%")->take(30)->paginate(5)->appends(['tukhoa' => $tukhoa]);
        return view('pages.timkiem',['tintuc'=>$tintuc,'tukhoa'=>$tukhoa]);
    }

    function gioithieu() {
        return view('pages.gioithieu');
    }
}

?>