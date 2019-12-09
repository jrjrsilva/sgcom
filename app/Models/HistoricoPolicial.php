<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;

class HistoricoPolicial extends Model
{
    protected $table = 'historico_policial';

    protected $fillable = ['efetivo_id','observacao','data_inicio','data_fim'];

    protected $guarded = ['id','created_at','updated_at'];

    function tipohistorico() {
        return $this->belongsTo(TipoHistorico::class, 'tipo_historico_id');
    }

    public function searchHistorico(Array $dataForm, $totalPage)
    {
  //  dd( $dataForm);
     $retorno =
     $historicos = HistoricoPolicial::
     where(function($query) use ($dataForm){
        if(isset($dataForm['ptipo'])){
            $query->where('tipo_historico_id','=',$dataForm['ptipo']);
        }
    })->where('efetivo_id',$dataForm['id'])
     ->orderBy('data_inicio','DESC')
     ->paginate($this->totalPage);

   return $retorno;
    }

}
