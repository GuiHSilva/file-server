@extends('base')

@section('content')

  <p>
    Lista de arquivos registrados
  </p>

  <table class="table table-hover table-inverse table-responsive" style="display: inline-table;">

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

    <div class="col-5">

      <form action="{{ url('arquivo/novo') }}" method="post" role="form" enctype="multipart/form-data">

        @csrf
        <div class="row">
            <input type="file" class="form-control" id="file" name="file" aria-describedby="helpId">
            <input type="submit" class="form-control btn-primary btn-sm">

            @include('util/alerts')
        </div>

      </form>
    </div>
    <div class="col-3">

    </div>
    <div class="col-4 float-right">
      {!! $arquivos->links() !!}
    </div>

  </div>

@endsection
