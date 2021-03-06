@extends('base')

@section('content')
        
    <p>
        Lista de arquivos registrados
    </p>

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
                    <td>{{ $item->fileName }}</td>
                    <td>{{ $item->extension }}</td>
                    <td><a class="btn btn-primary btn-sm" href="{{ url('arquivo/' . $item->url) }}" role="button">Ver</a></td>
                    <td>{{ $item->getData($item->created_at) }}</td>
                </tr>
                @endforeach
            </tbody>
    </table>

    
    <div class="row">
        
    <div class="col-4">
        <form action="{{ url('arquivo/novo') }}" method="post" role="form" enctype="multipart/form-data">
        
            @csrf

            <div class="row">
                <input type="file" class="form-control" id="file" name="file" aria-describedby="helpId">
                <input type="submit" class="form-control btn-primary btn-sm">
            </div>           
        
        </form> 
    </div>
    <div class="col-4">
        <nav aria-label="Page navigation">
          <ul class="pagination">
            <li class="page-item disabled">
              <a class="page-link" href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
              </a>
            </li>
            <li class="page-item active"><a class="page-link" href="#"></a></li>
            <li class="page-item"><a class="page-link" href="#"></a></li>
            <li class="page-item">
              <a class="page-link" href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
              </a>
            </li>
          </ul>
        </nav>
    </div>
    </div>

@endsection