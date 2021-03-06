<?php

namespace App\Http\Controllers;

use App\Models\Arquivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArquivoController extends Controller
{

    public function __construct()
    {
        $this->middleware('web');
        $this->middleware('web')->except('upload');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arquivos = Arquivo::all();
        return $arquivos;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Tratamento de erros
        try {
            
            // Pega o arquivo que está no request
            $arquivo = $request->file('file');

            // Valida se existe arquivo para upload
            if ( ! isset($arquivo) ) {
                
                return redirect()
                        ->route('index')
                        ->with('error', 'Nenhum arquivo foi anexado!');

            }

            // Salva o arquivo, no nome é concatenado um timestamp pra nao ter arquivos repetidos, o regex é pra
            // garantir que nao vao entrar uns caracteres doidos.
            // O salvamento dos arquivos será separado por pastas, cada pasta é o mimetype dos arquivo enviado
            $nomeArquivo = preg_replace("/[^a-zA-Z0-9_]/", '', explode('.', $arquivo->getClientOriginalName())[0]) . '-' . time() . '.' . $arquivo->getClientOriginalExtension();
            $pastaDestino = $arquivo->getMimeType();

            // Finalmente, salva no storage
            // Está sendo usado o putFile para salvar o arquivo com a extensao, para quando baixar
            // o arquivo pelo storage::download já ser feito o download do arquivo corretamente
            $path = Storage::putFileAs(
                'public/' . $pastaDestino, $arquivo, $nomeArquivo
            );

            // Registra no banco a inserçao do arquivo
            // Instancia o modelo Arquivo
            $arq = new Arquivo;

            // Definicao dos valores do modelo Arquivo
            $arq->filePath  = $path;
            $arq->fileName  = $arquivo->getClientOriginalName();
            $arq->extension = $arquivo->getClientOriginalExtension();
            $arq->url       = $this->generateNewUrl();

            // Salva no banco o modelo Arquivo
            $operacao = $arq->save();

            // Callback para responder a solicitacao de upload
            if ( $operacao ) {

                return redirect()
                        ->route('index')
                        ->with('success', 'O arquivo ' . $arq->fileName . ' foi armazenado com sucesso!');

            }

            return redirect()
                ->route('index')
                ->with('error', 'Houve um erro ao armazenar o arquivo');

        } catch (\Throwable $th) {
            
            return redirect()
                ->route('index')
                ->with('error', 'Houve uma falha ao armazenar o arquivo: ' . $th->getMessage());
            
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $arquivo = Arquivo::where('url', $request->url)->first();

        if ( ! isset($arquivo) ) {
            abort(404);
        }

        return view('show', compact('arquivo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Arquivo  $arquivo
     * @return \Illuminate\Http\Response
     */
    public function edit(Arquivo $arquivo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Arquivo  $arquivo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Arquivo $arquivo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Arquivo  $arquivo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Arquivo $arquivo)
    {

        // deleta um arquivo e remove o registro do banco
        Storage::delete($arquivo->filePath);
        $arquivo->delete();

        return redirect()
            ->route('index')
            ->with('success', 'O arquivo ' . $arquivo->fileName . ' foi deletado!');

    }

    /**
     * Download the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function download(Request $request)
    {
        $arquivo = Arquivo::where('url', $request->url)->first();

        if ( ! isset($arquivo) ) {
            abort(404);
        }

        $storage = Storage::download($arquivo->filePath);

        return $storage;
    }

    /**
     * -------------------
     * Funcoes utilitarias
     * -------------------
     */

    /**
     * Gera um novo url, um UUID ordenado
     */
    private function generateNewUrl()
    {
        return Str::orderedUuid();
    }

}
