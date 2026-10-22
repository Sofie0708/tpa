<?php

namespace Tests\Feature;

use App\Models\Evento;
use App\Models\Pergunta;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpvotePerguntaTest extends TestCase
{
    use RefreshDatabase;

    private function criarPergunta(User $autor): Pergunta
    {
        $evento = Evento::factory()->create();

        return Pergunta::create([
            'evento_id' => $evento->id,
            'user_id'   => $autor->id,
            'texto'     => 'Pergunta de teste para votação',
            'status'    => 'pendente',
        ]);
    }

    public function test_anonimo_nao_pode_votar(): void
    {
        $pergunta = $this->criarPergunta(User::factory()->create());

        $this->post(route('perguntas.votar', $pergunta))->assertRedirect(route('login'));
        $this->assertDatabaseCount('pergunta_user', 0);
    }

    public function test_voto_alterna_entre_inserir_e_remover(): void
    {
        $user = User::factory()->create();
        $pergunta = $this->criarPergunta($user);

        $this->actingAs($user)->post(route('perguntas.votar', $pergunta));
        $this->assertDatabaseHas('pergunta_user', ['pergunta_id' => $pergunta->id, 'user_id' => $user->id]);

        $this->actingAs($user)->post(route('perguntas.votar', $pergunta));
        $this->assertDatabaseMissing('pergunta_user', ['pergunta_id' => $pergunta->id, 'user_id' => $user->id]);
    }
}
