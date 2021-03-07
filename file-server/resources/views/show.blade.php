@extends('base')

@section('content')

    <p>
        Visualizando o arquivo. <a href="{{ url('/') }}">Lista de arquivos</a>
    </p>

    <div class="card md-5">
        <div class="card-header">
            Arquivo #{{ $arquivo->id }}
        </div>
        <div class="card-body">
            <p><b>Arquivo:</b> {{ $arquivo->fileName }}</p>
            <p><b>Diretório:</b> {{ $arquivo->filePath }}</p>
            <p><b>Data de upload:</b> {{ $arquivo->getData($arquivo->created_at) }}</p>
            <p><b>Extensão:</b> {{ $arquivo->extension }}</p>
            <p><b>URL:</b> {{ $arquivo->url }}</p>
            @if ( $arquivo->isImage($arquivo->extension) )
                <p><b>Pré-visualização da imagem:</b></p>
                <img src="{{ url('arquivo/' . $arquivo->url . '/view') }}" style="max-width: 250px;">
            @endif
        </div>
        <div class="card-footer">
            <a class="btn btn-info" href="{{ url('arquivo/' . $arquivo->url . '/view') }}" role="button" target="_blank">Acessar arquivo</a>

            <a class="btn btn-primary" href="{{ url('arquivo/' . $arquivo->url . '/download') }}" role="button">Baixar arquivo</a>

            <a class="btn btn-danger" href="{{ url('arquivo/' . $arquivo->id . '/delete') }}" role="button">Apagar arquivo</a>
        </div>
    </div>

@endsection
