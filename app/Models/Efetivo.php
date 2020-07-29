<?php

namespace sgcom\Models;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Efetivo extends Model
{
    //
    protected $table = 'pmgeral';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function grauhierarquico()
    {
        return $this->belongsTo(GrauHierarquico::class, 'grauhierarquico_id');
    }

    public function secao()
    {
        return $this->belongsTo(Secao::class);
    }

    public function funcao()
    {
        return $this->belongsTo(Funcao::class);
    }

    public function opm()
    {
        return $this->belongsTo(Opm::class);
    }

    public function situacao()
    {
        return $this->belongsTo(SituacaoEfetivo::class, 'situacao_efetivo_id');
    }

    public function porOpm($efetivo, $totalPage)
    {
        $retorno =
            $this->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
            ->join('grauhierarquico', 'pmgeral.grauhierarquico_id', '=', 'grauhierarquico.id')
            ->where('opm_id', '=', $efetivo)
            ->select('pmgeral.id', 'grauhierarquico.sigla', 'matricula', 'opm.opm_sigla', 'dataadmissao', 'sexo', 'nome')
            ->orderBy('grauhierarquico.precedencia', 'ASC')
            ->paginate($totalPage);
        // ->toSql();
        //dd($retorno);
        return $retorno;
    }

    public function searchUnique(array $dataForm, $totalPage)
    {
        //  dd( $dataForm);
        $retorno =
            $this->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
            ->join('grauhierarquico', 'pmgeral.grauhierarquico_id', '=', 'grauhierarquico.id')
            ->where(function ($query) use ($dataForm) {
                if (isset($dataForm['pnome'])) {
                    $query->where('nome', 'LIKE', '%' . $dataForm['pnome'] . '%');
                }
                if (isset($dataForm['pmatricula'])) {
                    $query->where('matricula', 'like', $dataForm['pmatricula'].'%');
                }
                if (isset($dataForm['popm'])) {
                    $query->where('opm_id', '=', $dataForm['popm']);
                }
                if (isset($dataForm['pgh'])) {
                    $query->where('grauhierarquico_id', '=', $dataForm['pgh']);
                }
                if (isset($dataForm['pregional'])) {
                    $query->where('opm.cpr_id', '=', $dataForm['pregional']);
                }
                if (isset($dataForm['pfuncao'])) {
                    $query->where('funcao_id', '=', $dataForm['pfuncao']);
                }
                if (isset($dataForm['psecao'])) {
                    $query->where('secao_id', '=', $dataForm['psecao']);
                }
                if (isset($dataForm['pcidade'])) {
                    $query->where('cidade_estado', '=', $dataForm['pcidade']);
                }
            })
            // ->where('opm_id','=',Auth::user()->efetivo->opm->id)
            ->whereOr('opm_id', '=', '309999')
            ->select('pmgeral.id', 'grauhierarquico.sigla', 'matricula', 'opm.opm_sigla', 'dataadmissao', 'sexo', 'nome')
            ->orderBy('grauhierarquico.precedencia', 'ASC')
            ->paginate($totalPage);

       return $retorno;
    }


    public function tempoDecorrido($data)
    {
        list($ano, $mes, $dia) = explode('-', $data);
        $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $dataAlvo = mktime(0, 0, 0, $mes, $dia, $ano);
        return  floor((((($hoje - $dataAlvo) / 60) / 60) / 24) / 365.25);
    }

    public function pesquisaAniversarios(array $dataForm, $totalPage)
    {

        $retorno =
            $this->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
            ->join('grauhierarquico', 'pmgeral.grauhierarquico_id', '=', 'grauhierarquico.id')
            ->where('opm.cpr_id', '=', 12)
            ->whereMonth('datanascimento', '=', $dataForm['mes'])
            ->where(function ($query) use ($dataForm) {
                if (isset($dataForm['opm'])) {
                    $query->where('opm.id', '=', $dataForm['opm']);
                }
            })
            ->select('nome', 'opm.opm_sigla', 'datanascimento', 'grauhierarquico.sigla')
            ->orderBy('grauhierarquico.precedencia', 'ASC')
            ->paginate($totalPage);
        //->toSql();
        //dd($retorno);
        return $retorno;
    }

    public function pesquisaFerias(array $dataForm, $totalPage)
    {

        $retorno =
            $this->join('opm', 'pmgeral.opm_id', '=', 'opm.id')
            ->join('grauhierarquico', 'pmgeral.grauhierarquico_id', '=', 'grauhierarquico.id')
            ->where('opm.cpr_id', '=', 12)
            ->whereMonth('dataadmissao', '=', $dataForm['mes'])
            ->where(function ($query) use ($dataForm) {
                if (isset($dataForm['opm'])) {
                    $query->where('opm.id', '=', $dataForm['opm']);
                }
            })
            ->select('nome', 'opm.opm_sigla', 'dataadmissao', 'grauhierarquico.sigla')
            ->orderBy('grauhierarquico.precedencia', 'ASC')
            ->paginate($totalPage);
        //->toSql();
        //dd($retorno);
        return $retorno;
    }
}
