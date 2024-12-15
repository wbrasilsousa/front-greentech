@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Editar Fornecedor</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- jquery validation -->
                <div class="card card-primary">
                    
                    <!-- form start -->
                    <form id="quickForm" method="POST" action="{{ route('supplier.update') }}" novalidate="novalidate">
                        @csrf <!-- {{ csrf_field() }} -->
                        <input type="hidden" name="id" class="form-control" id="id" value="{{ $supplier->id }}">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label for="nome">Nome</label>
                                    <input type="text" name="nome" class="form-control" id="nome" value="{{ $supplier->nome }}" placeholder="Nome do Fornecedor">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="telefone">Telefone</label>
                                    <input type="text" name="telefone" class="form-control" id="telefone" value="{{ $supplier->telefone }}" placeholder="Telefone do Fornecedor">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="email" name="email" class="form-control" id="email" value="{{ $supplier->email }}" placeholder="E-mail">
                            </div>

                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label for="cep">CEP</label>
                                    <input type="text" name="cep" class="form-control" id="cep" value="{{ $supplier->cep }}" placeholder="CEP">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="logradouro">Logradouro</label>
                                    <input type="text" name="logradouro" class="form-control" id="logradouro" value="{{ $supplier->logradouro }}" placeholder="Logradouro" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label for="complemento">Complemento</label>
                                    <input type="text" name="complemento" class="form-control" id="complemento" value="{{ $supplier->complemento }}" placeholder="Complemento">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="bairro">Bairro</label>
                                    <input type="text" name="bairro" class="form-control" id="bairro" value="{{ $supplier->bairro }}" placeholder="Bairro" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label for="estado">Estado</label>
                                    <input type="text" name="estado" class="form-control" id="estado" value="{{ $supplier->estado }}" placeholder="Estado" readonly>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="uf">UF</label>
                                    <input type="text" name="uf" class="form-control" id="uf" value="{{ $supplier->uf }}" placeholder="UF" readonly>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button onclick="window.history.back();" class="btn btn-secondary">Voltar</button>&nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Produtos Relacionados</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nome</th>
                                <th>Categoria</th>
                                <th>Preço</th>
                                <th>Qt</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($supplier->products as $product)    
                                <tr>
                                    <td>{{ $product->codigo }}</td>
                                    <td>{{ $product->nome }}</td>
                                    <td>{{ $product->categoria }}</td>
                                    <td>{{ $product->preco }}</td>
                                    <td>{{ $product->quantidade }}</td>
                                </tr>
                            @endforeach
                            
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')
    <script>

        $("#cep").mask("99999-999");
        $('#telefone').mask('(00) 0000-00009');

        function limpa_formulário_cep() {
            // Limpa valores do formulário de cep.
            $("#rua").val("");
            $("#bairro").val("");
            $("#estado").val("");
            $("#uf").val("");
            $("#cep").val("");
        }

        //Quando o campo cep perde o foco.
        $("#cep").blur(function() {

            //Nova variável "cep" somente com dígitos.
            var cep = $(this).val().replace(/\D/g, '');

            //Verifica se campo cep possui valor informado.
            if (cep != "") {

                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;

                //Valida o formato do CEP.
                if(validacep.test(cep)) {

                    //Preenche os campos com "..." enquanto consulta webservice.
                    $("#logradouro").val("...");
                    $("#bairro").val("...");
                    $("#estado").val("...");
                    $("#uf").val("...");

                    //Consulta o webservice viacep.com.br/
                    $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            $("#logradouro").val(dados.logradouro);
                            $("#bairro").val(dados.bairro);
                            $("#estado").val(dados.estado);
                            $("#uf").val(dados.uf);
                        } //end if.
                        else {
                            //CEP pesquisado não foi encontrado.
                            limpa_formulário_cep();
                            alert("CEP não encontrado.");
                        }
                    });
                } //end if.
                else {
                    //cep é inválido.
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep();
            }
        });

        $(function () {
        $.validator.setDefaults({
            submitHandler: function () {
                form.submit();
            }
        });
        $('#quickForm').validate({
            rules: {
                nome: {
                    required: true,
                },
                telefone: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
                },
                cep: {
                    required: true,
                },
            },
            messages: {
                nome: {
                    required: "Preencher o nome"
                },
                telefone: {
                    required: "preencher o telefone"
                },
                email: {
                    required: "Preencher o e-mail",
                    email: "Colocar um endereço de e-mail válido"
                },
                cep: {
                    required: "Preencher o CEP"
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
        });
    </script>
@stop