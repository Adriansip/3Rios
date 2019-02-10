<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PagoCxc extends Model
{
    protected $table = 'pag_cxc';

    protected $fillable = ['NumPag', 'FacCxcNum', 'MonPag', 'FecPag', 'RefPag', 'ObsPag'];

    protected $primaryKey = 'PagCxcId';

    /*Un pago pertenece a una factura*/
    public function factura()
    {
        return $this->belongsTo(FacturaCxc::class,'FacCxcNum');
    }

}
