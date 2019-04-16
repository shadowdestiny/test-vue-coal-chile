<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConsultsResource;
use Illuminate\Http\Request;

class DesempenhoController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    function index(){

        $query = "
        SELECT cu.co_usuario as value,no_usuario as text FROM  CAO_USUARIO CU 
        JOIN permissao_sistema PS on (cu.co_usuario = ps.co_usuario) 
        WHERE 
        ps.co_sistema = 1  
        AND PS.IN_ATIVO = 'S'
        AND PS.CO_TIPO_USUARIO IN (0,1,2)
        ";

        $users = (collect(\DB::select($query)));

        return view('index.desempenho',['users'=>$users]);
    }

    function getAgain(Request $request){

        $users_selected = $request->input('users_selected');
        $filter = $request->input('filter');

        $users_value_selected = [];

        if (count($users_selected) > 0){
            foreach($users_selected as $user){
                $users_value_selected[]="'".$user['value']."'";
            }
            $string_users_comma = implode(",",$users_value_selected);
        } else {
            $string_users_comma = 'null';
        }

        $from   = ($filter["year_from"]."-".$filter["month_from"]."-01");
        $to     = $filter["year_to"]."-".$filter["month_to"]."-01";

        $query = "
            SELECT 
            DATE_FORMAT(CF.data_emissao,'%m-%Y') as data_emissao,
            sum(CF.valor - ((CF.valor * CF.total_imp_inc) / 100)) as receita_liquida,
            CAOS.brut_salario as custo_fixo,
            sum((CF.valor - ((CF.valor * CF.total_imp_inc) / 100)) * (CF.comissao_cn / 100)) as comission,
            sum((CF.valor - ((CF.valor * CF.total_imp_inc) / 100)) - CAOS.brut_salario - (CF.valor - ((CF.valor * CF.total_imp_inc) / 100)) * (CF.comissao_cn / 100)) as lucro,
            CU.co_usuario,
            CU.no_usuario
            FROM CAO_FATURA CF 
            JOIN CAO_CLIENTE CC ON CC.CO_CLIENTE = CF.CO_CLIENTE
            JOIN CAO_SISTEMA CS ON CC.CO_CLIENTE = CS.CO_CLIENTE
            INNER JOIN CAO_OS CO ON CS.CO_SISTEMA = CO.CO_SISTEMA
            JOIN cao_salario CAOS ON CO.CO_USUARIO = CAOS.CO_USUARIO
            JOIN CAO_USUARIO CU ON  CAOS.CO_USUARIO = CU.CO_USUARIO
            WHERE CO.CO_USUARIO IN ($string_users_comma)
            AND CF.data_emissao BETWEEN CAST('$from' AS DATE) AND DATE_ADD(CAST('$to' AS DATE), INTERVAL 1 MONTH )
            GROUP BY DATE_FORMAT(CF.data_emissao,'%m-%Y'),CAOS.brut_salario,CU.co_usuario,CU.no_usuario
            ORDER BY CU.no_usuario ASC,CF.data_emissao ASC
        ";

        $data = collect(\DB::select($query));

        $query = "
          SELECT receita_liquida,custo_fixo,lucro,no_usuario FROM (
                SELECT 
                    sum(CF.valor - ((CF.valor * CF.total_imp_inc) / 100)) as receita_liquida,
                    CAOS.brut_salario as custo_fixo,
                    sum((CF.valor - ((CF.valor * CF.total_imp_inc) / 100)) * (CF.comissao_cn / 100)) as comission,
                    sum((CF.valor - ((CF.valor * CF.total_imp_inc) / 100)) - CAOS.brut_salario - (CF.valor - ((CF.valor * CF.total_imp_inc) / 100)) * (CF.comissao_cn / 100)) as lucro,
                    CU.co_usuario,
                    CU.no_usuario
                    FROM CAO_FATURA CF 
                    JOIN CAO_CLIENTE CC ON CC.CO_CLIENTE = CF.CO_CLIENTE
                    JOIN CAO_SISTEMA CS ON CC.CO_CLIENTE = CS.CO_CLIENTE
                    INNER JOIN CAO_OS CO ON CS.CO_SISTEMA = CO.CO_SISTEMA
                    JOIN cao_salario CAOS ON CO.CO_USUARIO = CAOS.CO_USUARIO
                    JOIN CAO_USUARIO CU ON  CAOS.CO_USUARIO = CU.CO_USUARIO
                    WHERE CO.CO_USUARIO IN ($string_users_comma)
                    AND CF.data_emissao BETWEEN CAST('$from' AS DATE) AND DATE_ADD(CAST('$to' AS DATE), INTERVAL 1 MONTH )
                    GROUP BY CAOS.brut_salario,CU.co_usuario,CU.no_usuario
                    ORDER BY CU.no_usuario ASC,CF.data_emissao ASC
            
            ) AS s ORDER BY receita_liquida asc
        ";

        $graph = collect(\DB::select($query));

        return response()->json([
            'status' => '200',
            'results'=>$data,
            'graph'=>$graph
        ]);
    }
}
