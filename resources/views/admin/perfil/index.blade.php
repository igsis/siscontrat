@extends('adminlte::page')

@section('title', 'Relação de perfis')

@section('content_header')
    <h1>Todos os Perfis</h1>
@stop


@section('content')
@include('admin.perfil.mensagens', ['msg' => old('id')])
    <a href="{!! route('perfil.form') !!}" class="btn btn-primary">+Novo</a>
    <table align="center" class=" table table-stripped table-hover tabela-perfil">
    <thead>
        <tr>    
            <th>Descrição</th>      
            <th>Ação</th>
        </tr> 
    </thead>  
    <tbody>
        @foreach($perfis as $perfil)
        <tr scope="row">      
            <td>{{$perfil->descricao}}</td>                
            <td>
                <a href="/perfil/editar/{{$perfil->id}}">Alterar</a>
            </td>                
        </tr> 
        @endforeach        
    </tbody>
    </table>  
    <div class="paginacao">
        {!! $perfis->links() !!}  
    </div>  
@stop
