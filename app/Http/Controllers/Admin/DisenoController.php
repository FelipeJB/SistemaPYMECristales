<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Diseno;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class DisenoController extends Controller
{

  public function desactivate(Request $request){
    try {
      if(Auth::user()->usrRolID==1){
        $id=$request->id;
        $diseno= Diseno::where('dsnID','=',$id)->first();
        $diseno->dsnActivo=0;
        $diseno->save();
        return Redirect::to('/AdministrarDisenos')->with("success", "El diseño se desactivó satisfactoriamente");
      }
      else{
        return Redirect::to('/');
      }
    } catch (\Exception $e) {
      return Redirect::to('/AdministrarDisenos')->with("error", "Error desactivando el diseño");
    }
  }

  public function activate(Request $request){
    try {
      if(Auth::user()->usrRolID==1){
        $id=$request->id;
        $diseno= Diseno::where('dsnID','=',$id)->first();
        $diseno->dsnActivo=1;
        $diseno->save();
        return Redirect::to('/AdministrarDisenos')->with("success", "El diseño se activó satisfactoriamente");
      }
      else{
        return Redirect::to('/');
      }
    } catch (\Exception $e) {
      return Redirect::to('/AdministrarDisenos')->with("error", "Error activando el diseño");
    }
  }

}
