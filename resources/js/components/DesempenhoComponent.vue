<template>
    <div>
        <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
            <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">COAL</a>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 main-title">
                    <h1 class="h2">Desempenho</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-1">
                    <select class="browser-default custom-select" v-model="filter.month_from">
                        <option selected="selected" value="01">Jan</option>
                        <option value="02">Fev</option>
                        <option value="03">Mar</option>
                        <option value="04">Abr</option>
                        <option value="05">Mai</option>
                        <option value="06">Jun</option>
                        <option value="07">Jul</option>
                        <option value="08">Ago</option>
                        <option value="09">Set</option>
                        <option value="10">Out</option>
                        <option value="11">Nov</option>
                        <option value="12">Dez</option>
                    </select>
                </div>
                <div class="col-sm-1">
                    <select class="browser-default custom-select" v-model="filter.year_from">
                        <option value="2003">2003</option>
                        <option value="2004">2004</option>
                        <option value="2005">2005</option>
                        <option value="2006">2006</option>
                        <option selected="selected" value="2007">2007</option>
                    </select>
                </div>
                <div class="col-sm-1" style="text-align: center">
                    a
                </div>
                <div class="col-sm-1">
                    <select class="browser-default custom-select" v-model="filter.month_to">
                        <option selected="selected" value="01">Jan</option>
                        <option value="02">Fev</option>
                        <option value="03">Mar</option>
                        <option value="04">Abr</option>
                        <option value="05">Mai</option>
                        <option value="06">Jun</option>
                        <option value="07">Jul</option>
                        <option value="08">Ago</option>
                        <option value="09">Set</option>
                        <option value="10">Out</option>
                        <option value="11">Nov</option>
                        <option value="12">Dez</option>
                    </select>
                </div>
                <div class="col-sm-1">
                    <select class="browser-default custom-select" v-model="filter.year_to">
                        <option value="2003">2003</option>
                        <option value="2004">2004</option>
                        <option value="2005">2005</option>
                        <option value="2006">2006</option>
                        <option selected="selected" value="2007">2007</option>
                    </select>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Consultores</h5>
                            <select multiple class="card-text list-user" v-model="leftMultipleSelections">
                                <option  v-for="list in leftList" :value="list">{{list.text}}</option>
                            </select>
                            <div class="center">
                                <a class="btn btn-primary" @click="leftSelector()"> >> </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Consultores Seleccionados</h5>
                            <select multiple class="card-text list-user" v-model="rightMultipleSelections">
                                <option  v-for="list in rightList" :value="list">{{list.text}}</option>
                            </select>
                            <div class="center">
                                <a class="btn btn-primary" @click="rightSelector()"> << </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 center">
                    <button type="button" class="btn btn-primary" @click="relatorio()">Relatorio</button>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <h2>Grafico</h2>
                    <div class="card">
                        <div class="card-body">
                                <monthly-income
                                        :chart-data="datacollection"
                                        :width="400"
                                        :height="600"
                                        :max="max"
                                ></monthly-income>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <h2>Grafico</h2>
                    <div class="card">
                        <div class="card-body">
                            <polar-income
                                    :chart-data="polarcollection"
                                    :width="400"
                                    :height="400"
                            ></polar-income>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <h2>Consultores</h2>
                    <div v-for="(user, index) in results">
                        <br>
                        <div class="card" >
                            <div class="card-body" >
                                <div class="table-responsive" >
                                    <table class="table table-striped table-sm">
                                        <thead>
                                        <tr>
                                            <td colspan="5" style="text-align: center">{{user[0].no_usuario}}</td>
                                        </tr>
                                        <tr>
                                            <th>Período</th>
                                            <th>Receita Líquida</th>
                                            <th>Custo Fixo</th>
                                            <th>Comissão</th>
                                            <th>Lucro</th>
                                        </tr>
                                        </thead>
                                        <tbody >

                                        <tr  v-for="row in user">
                                            <td>{{(row.data_emissao)}}</td>
                                            <td>-R$ {{formatPrice(row.receita_liquida)}}</td>
                                            <td>-R$ {{formatPrice(row.custo_fixo)}}</td>
                                            <td>-R$ {{formatPrice(row.comission)}}</td>
                                            <td>-R$ {{formatPrice(row.lucro)}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

        </div>
    </div>
</template>

<script>
    import axios from "axios";
    import PolarIncome from "./chars/PolarIncome";
    import MonthlyIncome from "./chars/MonthlyIncome";
    export default {
        components: {
            MonthlyIncome,
            PolarIncome,
        },
        mounted() {
            this.leftList = this.users;
        },
        props:{
            users: Array,
        },
        data(){
            return {
                leftMultipleSelections:[],
                rightMultipleSelections:[],
                leftList:[

                ],
                rightList:[

                ],
                results:[],
                graph:[],
                min:0,
                max:32000,
                filter:{
                    month_from  :"01",
                    year_from   :"2007",
                    month_to    :"01",
                    year_to     :"2007",
                },
                datacollection:
                     {

                    }
                ,
                polarcollection:{},
            }
        },
        methods:{
            leftSelector(){
                this.leftMultipleSelections.forEach((element) =>{
                    let index = this.leftList.findIndex(function(el){
                        return element.value === el.value;
                    });
                    this.leftList.splice(index,1);
                    this.rightList.push(element);
                });
            },
            rightSelector(){
                this.rightMultipleSelections.forEach((element) =>{
                    let index = this.rightList.findIndex(function(el){
                        return element.value === el.value;
                    });
                    this.rightList.splice(index,1);
                    this.leftList.push(element);
                });
            },
            relatorio(){
                let rows = [];
                let users = []
                axios.post("/get_gain",{
                    users_selected:this.rightList,
                    filter:this.filter
                }).then((response)=>{

                    let promedio = 0;
                    let promedio_total = [];
                    let consult = [];
                    let lucro = [];
                    let receita_liquida = [];
                    let colors = [];

                    let max_receita = response.data.graph[response.data.graph.length - 1].receita_liquida;

                    response.data.graph.forEach((element)=>{
                        promedio += element.custo_fixo;
                        consult.push(element.no_usuario);
                        lucro.push(element.lucro);
                        receita_liquida.push(Math.round((element.receita_liquida * 100) / max_receita));
                        colors.push('#'+Math.floor(Math.random()*16777215).toString(16));
                    });

                    promedio = promedio / response.data.graph.length;

                    response.data.graph.forEach((element)=>{
                        promedio_total.push(promedio)
                    });

                    let graph = {
                        labels: consult,
                            datasets: [
                                {
                                    label: "Custo Fixo Medio",
                                    backgroundColor: "#BAEBCC",
                                    data: promedio_total
                                },
                                {
                                    label: "Lucro de consultores",
                                    backgroundColor: "#69CC8D",
                                    data: lucro
                                },
                            ]
                    };

                    let polarcollection = {
                        datasets: [{
                            data: receita_liquida,
                            backgroundColor: colors,
                            label: 'Consultores' // for legend
                        }],
                        labels: consult
                    };

                    this.datacollection     = graph;
                    this.polarcollection    = polarcollection;

                    if(this.graph.length > 0){
                        this.min = Math.round(this.graph[0].receita_liquida);
                        this.max = Math.round(this.graph[this.graph.length - 1].receita_liquida);
                    }
                    response.data.results.forEach((element,index)=>{
                        rows.push(element);

                        if(this.validate(index,response.data.results)){
                            users.push(rows);
                            rows = [];
                        }
                    });
                    this.results = users;
                });
            },
            validate(index, results) {

                    return (
                        results[index + 1] === undefined ||
                        results[index].co_usuario !== results[index + 1].co_usuario
                    );

            },
            formatPrice(value) {
                let val = (value/1).toFixed(2).replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            }
        }
    }
</script>
