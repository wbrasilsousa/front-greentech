@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Listagem de Fornecedores</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
        <h3 class="card-title">Fornecedores</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Estado</th>
                    <th style="width: 120px"></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($suppliers as $supplier)    
                    <tr>
                        <td>{{ $supplier->id }}</td>
                        <td>{{ $supplier->nome }}</td>
                        <td>{{ $supplier->email }}</td>
                        <td>{{ $supplier->estado }}/{{ $supplier->uf }}</td>
                        <td>
                            <a type="btn" href="{{ route('supplier.edit', ['id' => $supplier->id]) }}" class="btn btn-block bg-gradient-primary btn-xs">Editar</a>
                            <a type="btn" class="btn btn-block bg-gradient-danger btn-xs" data-toggle="modal" data-target="#exampleModal{{ $supplier->id }}">Deletar</a>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal{{ $supplier->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Atenção</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                Tem certeza que deseja deletar?
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <a type="button" href="{{ route('supplier.delete', ['id' => $supplier->id]) }}" class="btn btn-danger">Deletar</a>
                            </div>
                        </div>
                        </div>
                    </div>
                @endforeach
                
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
@stop

@section('css')

@stop

@section('js')
    
@stop