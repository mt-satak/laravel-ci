<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * 初期画面表示処理の結果、
     * - HTTPステータスコード:200を返すこと
     * - 期待値として指定したビューと表示内容のビューが一致すること
     */
    public function index_正常系()
    {
        // メソッド実行
        $response = $this->get(route('articles.index'));
        // 検証
        $response->assertOk()->assertViewIs('articles.index');
    }

    /**
     * @test
     *
     * ユーザが未ログイン状態で記事投稿画面表示処理を行なった結果、
     * - ログイン画面への遷移が行われること
     */
    public function create_正常系_ゲスト()
    {
        // 事前準備でログイン処理を行わず(=未ログイン状態で)メソッド実行
        $response = $this->get(route('articles.create'));
        // 検証
        $response->assertRedirect(route('login'));
    }

    /**
     * @test
     *
     * ユーザがログインした状態で記事投稿画面表示処理を行なった結果、
     * - HTTPステータスコード:200を返すこと
     * - 期待値として指定したビューと表示内容のビューが一致すること
     */
    public function create_正常系_ログイン済()
    {
        // 事前準備
        $user = factory(User::class)->create();

        // ユーザがログインした状態でメソッド実行
        $response = $this->actingAs($user)->get(route('articles.create'));
        // 検証
        $response->assertStatus(200)->assertViewIs('articles.create');
    }
}
