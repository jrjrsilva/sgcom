<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use sgcom\User;

class RelatorioServico extends Model
{

    protected $table = 'servico_diario';

    use SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $dates = ['deleted_at'];

    function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    function policial()
    {
        return $this->belongsTo(Efetivo::class, 'efetivo_id');
    }

    function supervisor()
    {
        return $this->belongsTo(Efetivo::class, 'efetivo_id');
    }

    function coordenador()
    {
        return $this->belongsTo(Efetivo::class, 'efetivo_id');
    }

    function opm()
    {
        return $this->belongsTo(Opm::class);
    }


    public function search(array $dataForm, $totalPage)
    {
        //$retorno =
        return
            $this->where(function ($query) use ($dataForm) {
                if (isset($dataForm['opm'])) {
                    $query->where('opm_id', $dataForm['opm']);
                }
                if (isset($dataForm['tipo_ocorr'])) {
                    $query->where('tipoServico_id', $dataForm['tipo_ocorr']);
                }
                if (isset($dataForm['data_inicio'])) {
                    $query->where('data', '>=', $dataForm['data_inicio']);
                }
                if (isset($dataForm['data_fim'])) {
                    $query->where('data', '<=', $dataForm['data_fim']);
                }
            })
            ->paginate($totalPage);
        // ->toSql();
        //dd($retorno);

    }
}
