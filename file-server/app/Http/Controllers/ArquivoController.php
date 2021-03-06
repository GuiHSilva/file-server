<?php

namespace App\Http\Controllers;

use App\Models\Arquivo;
use Illuminate\Http\Request;
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
        return view('add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Pega o arquivo que está no request
        $arquivo = $request->file('file');

        // Valida se existe arquivo para upload
        if ( ! isset($arquivo) ) {
            return redirect('/');
        }

        // Salva o arquivo, nome é um timestamp pra nao ter conflito, o regex é pra garantir que nao vao entrar uns caracteres doidos
        // O salvamento dos arquivos será separado por pastas, cada pasté é o mimetype de cada arquivo enviado
        $nomeArquivo = preg_replace("/[^a-zA-Z0-9_]/", '', explode('.', $arquivo->getClientOriginalName())[0]);
        $pastaDestino = $arquivo->getMimeType();

        // Finalmente, salva
        $path = $arquivo->storeAs('files', $pastaDestino . '/' . $nomeArquivo . '-' . time() . '.' . $arquivo->getClientOriginalExtension());
    
        // Registra no banco a inserçao do arquivo
        // Instancia o modelo Arquivo
        $arq = new Arquivo;

        // Definicao dos valores do modelo Arquivo
        $arq->filePath  = $path;
        $arq->fileName  = $arquivo->getClientOriginalName();
        $arq->extension = $arquivo->getClientOriginalExtension();
        $arq->url       = $this->generateNewUrl();

        // Salva no banco o modelo Arquivo
        $arq->save();

        dd($path);
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
        //
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
