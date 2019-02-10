<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PagoCxp;
use App\FacturaCxp;
use Session;

class PagoCxpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pagos=PagoCxp::all();
        $facturas=FacturaCxp::all();
        return view('PagoCxp.index',compact('pagos','facturas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->FacCxpNum===0){
          Session::flash('message','No seleccionaste ninguna factura');
          Session::flash('class','danger');
          return back();
        }

        $factura=FacturaCxp::where('FacCxpNum',$request->FacCxpNum)->first();
        if($request->MonPag > $factura->SalFac){
          Session::flash('message','El pago es mayor al saldo pendiente, verifique.');
          Session::flash('class','warning');
          return back();
        }

        if($request->MonPag<0){
          Session::flash('message','El pago es un numero invalido, verifique.');
          Session::flash('class','warning');
          return back();
        }

        $pago=new PagoCxp();
        $pago->fill($request->all());

        if($pago->save()){
          Session::flash('message','Pago exitoso');
          Session::flash('class','success');

          //Actualizar el saldo de la factura
          $factura->SalFac -= $request->MonPag;
          $factura->save();
        }else{
          Session::flash('message','Algo salio mal');
          Session::flash('class','danger');
        }

        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return PagoCxp::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $pago=PagoCxp::find($id);
      //FacturaCxp
      $factura=FacturaCxp::where('FacCxpNum',$request->FacCxpNum)->first();
      //total factura
      $total=$factura->TotFac;
      //saldo de la factura
      $saldo=$factura->SalFac;
      //Nuevo Pago
      $nuevoPago=$request->MonPag;


      if($nuevoPago>$total || $nuevoPago<0){
        Session::flash('message','El pago es mayor al total de la factura, o es un numero invalido, verifique');
        Session::flash('class','warning');
        return back();
      }

      //Pago Actual
      $pagoAct=$pago->MonPag;
      $diferencia=$pagoAct-$nuevoPago;

      $pago->fill($request->all());
      //Actualizar el saldo de la factura
      $factura->SalFac += $diferencia;

      if($factura->SalFac<0){
        Session::flash('message','El pago es mayor al saldo pendiente, o es un numero invalido, verifique');
        Session::flash('class','warning');
        return back();
      }

      if($pago->save()){
        Session::flash('message','Pago Actualizado');
        Session::flash('class','success');
        //Confirmando cambio en la factura
        $factura->save();
      }else{
        Session::flash('message','Algo salio mal');
        Session::flash('class','danger');
      }

      return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      PagoCxp::destroy($id);

      Session::flash('message', 'Pago eliminado correctamente');
      Session::flash('class', 'success');

      return back();
    }
}
