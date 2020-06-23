<?php

namespace Tests\Feature;

use App\Article;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * 引数としてnullを受け取った場合、
     * - falseを返却すること
     */
    public function isLikedBy_引数がnull()
    {
        // 事前準備
        $article = factory(Article::class)->create();
        // メソッド実行
        $result = $article->isLikedBy(null);
        // 検証
        $this->assertFalse($result);
    }

    /**
     * @test
     *
     * 対象の記事をいいねしているUserモデルを引数として受け取った場合、
     * - trueを返却すること
     */
    public function isLikedBy_いいねしているユーザ()
    {
        // 事前準備
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();
        $article->likes()->attach($user); // 指定したユーザが記事に「いいね」する振る舞いを用意

        // メソッド実行
        $result = $article->isLikedBy($user);
        // 検証
        $this->assertTrue($result);
    }

    /**
     * @test
     *
     * 対象の記事をいいねしていないUserモデルを引数として受け取った場合、
     * - falseを返却すること 
     */
    public function isLikedBy_いいねしていないユーザ()
    {
        // 事前準備
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();
        $anotherUser = factory(User::class)->create();
        $article->likes()->attach($anotherUser); // 2人目に作成したユーザに「いいね」させる

        // メソッド実行
        $result = $article->isLikedBy($user); // いいねしていない1人目のユーザで判定を実行する
        // 検証
        $this->assertFalse($result);
    }
}
