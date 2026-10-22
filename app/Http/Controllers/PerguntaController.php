<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pergunta;
use Illuminate\Support\Facades\Auth;

class PerguntaController extends Controller
{
    public function votar(Pergunta $pergunta)
    {
        $resultado = $pergunta->votos()->toggle(Auth::id());

        $mensagem = count($resultado['attached']) > 0
            ? 'Voto registrado!'
            : 'Voto removido.';

        return back()->with('status', $mensagem);
    }
}
