<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

//ルーティングの記述は$app->http_method('URL',function)

//// 掲示板全体画面の表示
//$app->get('/board', function (Request $request, Response $response) {
//    return $this->renderer->render($response, 'board.phtml');
//});

//掲示板(上)　内容入力送信フォーム
$app->post('/board', function (Request $request, Response $response) {
    // フォーム(post)で受け取った値を変数に代入
    $message = $request->getParsedBodyParam('message');
    $name = $request->getParsedBodyParam('name');
    // SQL文でデータベースに挿入(message，nameをbody，user_nameに)
    $sql = 'INSERT INTO message (body,user_name) values (:message,:name)';
    // プリペアドステートメントを作って，実行した後，結果の取得
    $stmt = $this->db->prepare($sql);
    $result = $stmt->execute(['message' => $message,'name' => $name]);

    if (!$result) {
        throw new \Exception('掲示板に保存されませんでした');
    }

    // 保存が正常にできたら一覧ページへリダイレクトする
    return $response->withRedirect("/board");
});

//掲示板一覧(下)　投稿一覧
$app->get('/board', function (Request $request, Response $response) {
    // messageテーブル全てを取得
    $sql = 'SELECT * FROM message';
    // SQLに渡すパラメータがない時はqueryを使う
    $stmt = $this->db->query($sql);
    $boards = [];
    while($row = $stmt->fetch()) {
        $boards[] = $row;
    }
    $data = ['boards' => $boards];
    return $this->renderer->render($response, 'board.phtml', $data);
});


//default
$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
