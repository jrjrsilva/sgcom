<?php

namespace sgcom\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Arma extends Model
{
    protected $table = 'arma';

    protected $guarded = ['id'];

    public $timestamps = false;

    function opm()
    {
        return $this->belongsTo(Opm::class);
    }

    function calibre()
    {
        return $this->belongsTo(Calibre::class, 'calibre_id');
    }

    function especiearma()
    {
        return $this->belongsTo(EspecieArma::class, 'especie_da_arma');
    }

    function situacaoarma()
    {
        return $this->belongsTo(SituacaoArma::class, 'situacao');
    }

    function marcaarma()
    {
        return $this->belongsTo(MarcaArma::class, 'marca_da_arma');
    }

    function modeloarma()
    {
        return $this->belongsTo(ModeloArma::class, 'modelo');
    }

    public function search(array $dataForm, $totalPage)
    {
        $usr = Auth::user();
        $opmt = $usr->efetivo->opm_id;
        $cprId = $usr->efetivo->opm->cpr_id;

        if ($usr->existePapel('Gestor CPR') || $usr->existePapel('Admin')) {
            $opms = Opm::orderBy('opm_sigla', 'asc')->where('cpr_id', '=', $cprId)->pluck('id')->toArray();
        } else {
            $opms = Opm::orderBy('opm_sigla', 'asc')->where('id', '=', $opmt)->pluck('id')->toArray();
        }

        //  $opms = DB::table('opm')->select('id')->where('cpr_id', '=', '12')->pluck('id')->toArray();

        return
            //$retorno =
            $this->where(function ($query) use ($dataForm) {
                if (isset($dataForm['pserial'])) {
                    $query->where('numero_de_serie', 'like', '%' . $dataForm['pserial'] . '%');
                }
                if (isset($dataForm['psituacao'])) {
                    $query->where('situacao', '=', $dataForm['psituacao']);
                }
                if (isset($dataForm['pespecie'])) {
                    $query->where('especie_da_arma', '=', $dataForm['pespecie']);
                }
                if (isset($dataForm['pcalibre'])) {
                    $query->where('calibre_id', '=', $dataForm['pcalibre']);
                }
                if (isset($dataForm['popm'])) {
                    $query->where('opm_id', '=', $dataForm['popm']);
                }
            })
            ->whereIn('opm_id', $opms)
            ->orderBy('numero_de_serie', 'asc')
            ->paginate($totalPage);
        //->toSql();
        // dd($retorno);

    }
}
