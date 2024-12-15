@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Cadastro de Produtos</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
            
                <!-- form start -->
                <form id="quickForm" method="POST" action="{{ route('product.save') }}" novalidate="novalidate">
                    @csrf <!-- {{ csrf_field() }} -->
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="codigo">Código</label>
                                <input type="text" name="codigo" class="form-control" id="codigo" placeholder="Código do Fornecedor">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="nome">Nome</label>
                                <input type="text" name="nome" class="form-control" id="nome" placeholder="Nome do Fornecedor">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="categoria">Categoria</label>
                                <input type="text" name="categoria" class="form-control" id="categoria" placeholder="Categoria">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="quantidade">Quantidade</label>
                                <input type="text" name="quantidade" class="form-control" id="quantidade" placeholder="Quantidade">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="preco">Preço</label>
                                <input type="preco" name="preco" class="form-control" id="preco" placeholder="Preço">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="fornecedor_id">Fornecedor</label>
                                <select name="fornecedor_id" id="fornecedor_id" class="form-control">
                                    @foreach ($suppliers as $supplier) 
                                        <option value="{{ $supplier->id }}">{{ $supplier->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-12">
                                <div class="form-group">
                                    <label>Descrição</label>
                                    <textarea name="descricao" id="descricao" class="form-control" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>

        <!-- /.row -->
    </div>
@stop

@section('css')

@stop

@section('js')
    <script>

        $("#preco").mask('###0.00', {reverse: true});

        $(function () {
        $.validator.setDefaults({
            submitHandler: function () {
                form.submit();
            }
        });
        $('#quickForm').validate({
            rules: {
                codigo: {
                    required: true,
                },
                nome: {
                    required: true,
                },
                categoria: {
                    required: true,
                },
                quantidade: {
                    required: true,
                },
                preco: {
                    required: true,
                },
                descricao: {
                    required: true,
                },
            },
            messages: {
                codigo: {
                    required: "Preencher o codigo"
                },
                nome: {
                    required: "preencher o nome"
                },
                categoria: {
                    required: "Preencher a categoria"
                },
                quantidade: {
                    required: "Preencher a quantidade"
                },
                preco: {
                    required: "Preencher o preço"
                },
                descricao: {
                    required: "Preencher a descrição"
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