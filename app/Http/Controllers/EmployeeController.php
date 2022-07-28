<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request){
        if($request->has('search')){
            $data = Employee::where('client','LIKE','%' .$request->search.'%')->paginate(5);
        }else{
            $data = Employee::paginate(5);
        }
        
        return view ('datapegawai',compact('data'));
    }
    public function tambahpegawai(){
        return view ('tambahdata');
    }
    public function insertdata(Request $request){
        //dd($request->all());
        $data = Employee::create($request->all());
        if($request->hasFile('foto')){
            $request->file('foto')->move('fotopegawai/', $request->file('foto')->getClientOriginalName());
            $data->foto = $request->file('foto')->getClientOriginalName();
            $data->save();

        } 


        return redirect()->route('pegawai')->with('success', 'Data yang diinputkan sudah berhasil ditambahkan');
    }
    public function editdata($id){

        $data = Employee::find($id);
        return view ('editdata', compact('data'));
    }
    public function updatedata(Request $request, $id){
        $data = Employee::find($id);
        $data->update($request->all());
        return redirect()->route('pegawai')->with('success', 'Data yang diinputkan sudah berhasil diupdate');

    }
    public function delete ($id){
        $data = Employee::find($id);
        $data->delete();
        return redirect()->route('pegawai')->with('success', 'Data berhasil dihapus');

    }
    
}
