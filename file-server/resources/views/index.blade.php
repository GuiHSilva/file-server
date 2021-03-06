@extends('base')

@section('content')
        
    <p>
        Lista de arquivos registrados
    </p>

    <div>
        <form action="{{ url('arquivo/novo') }}" method="post">
        
            <div class="form-group">
                <label for="file">Adicionar um novo arquivo</label>
                <input type="file" class="form-control" name="file" aria-describedby="helpId">
                <input type="submit">
            </div>           
        
        </form> 
    </div>

    <table class="table table-hover table-inverse table-responsive">
        <thead class="thead-inverse">
            <tr>
                <th>ID</th>
                <th>Arquivo</th>
                <th>Extensão</th>
                <th>Açao</th>
                <th>Data</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($arquivos as $item)
                <tr>
                    <td scope="row">{{ $item->id }}</td>
                    <td>{{ $item->file }}</td>
                    <td>{{ $item->extension }}</td>
                    <td><a class="btn btn-primary btn-sm" href="{{ url('arquivo/' . $item->url) }}" role="button">Ver</a></td>
                    <td>{{ $item->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
    </table>

@endsection